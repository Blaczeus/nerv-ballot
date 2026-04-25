<?php

namespace App\Http\Controllers;

use App\Models\Contestant;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\Vote;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    /**
     * Process a checkout request and persist votes.
     */
    public function process(Request $request): RedirectResponse
    {
        $userId = $request->user()?->id;
        $voterToken = (string) $request->input('voter_token', '');
        $checkoutToken = (string) $request->input('checkout_token', '');

        if ($response = $this->ensureVotingIsEnabled($userId, $checkoutToken, $voterToken)) {
            return $response;
        }

        $rules = [
            'checkout_token' => ['required', 'string'],
            'voter_token' => ['required', 'uuid'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.contestant_id' => ['required', 'exists:contestants,id'],
            'items.*.votes' => ['required', 'integer', 'min:1', 'max:1000'],
        ];

        if (! $request->user()) {
            $rules['email'] = ['required', 'email'];
        }

        $validated = $request->validate($rules);

        $checkoutToken = $validated['checkout_token'];
        $voterToken = $validated['voter_token'];
        $email = $request->user()
            ? $request->user()->email
            : $validated['email'];

        if (Transaction::query()->where('checkout_token', $checkoutToken)->exists()) {
            Log::warning('Duplicate checkout request detected before processing.', [
                'user_id' => $userId,
                'voter_token' => $voterToken,
                'checkout_token' => $checkoutToken,
            ]);

            return $this->duplicateCheckoutResponse();
        }

        $pricePerVote = $this->resolveVotePrice();
        $items = $this->normalizeItems($validated['items']);
        $votesRecorded = false;

        try {
            $votesRecorded = DB::transaction(function () use ($items, $checkoutToken, $pricePerVote, $userId, $voterToken, $email): bool {
                $contestantIds = $items->pluck('contestant_id')->all();

                $contestants = Contestant::query()
                    ->with('contest')
                    ->whereIn('id', $contestantIds)
                    ->whereNull('deleted_at')
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                if ($contestants->count() !== \count($contestantIds)) {
                    throw ValidationException::withMessages([
                        'items' => 'One or more selected contestants are no longer available.',
                    ]);
                }

                $this->validateContestAvailability($contestants, $userId, $checkoutToken);
                $contestId = $this->resolveContestId($contestants);
                $this->enforceVoteLimit($userId, $voterToken, $contestId, $items, $email);

                $totalVotes = $items->sum('votes');
                $totalAmount = number_format($totalVotes * (float) $pricePerVote, 2, '.', '');

                $transaction = Transaction::query()->create([
                    'user_id' => $userId,
                    'voter_token' => $voterToken,
                    'email' => $email,
                    'checkout_token' => $checkoutToken,
                    'total_votes' => $totalVotes,
                    'price_per_vote' => $pricePerVote,
                    'total_amount' => $totalAmount,
                    'status' => 'pending',
                ]);

                $votesRecorded = false;

                if (config('app.voting_mode') === 'free') {
                    $this->recordVotes($transaction, $items, $contestants, $userId, $voterToken);
                    $transaction->update([
                        'status' => 'completed',
                    ]);
                    $votesRecorded = true;
                }

                Log::info('Checkout processed.', [
                    'user_id' => $userId,
                    'voter_token' => $voterToken,
                    'email' => $email,
                    'checkout_token' => $checkoutToken,
                    'transaction_id' => $transaction->id,
                    'contest_id' => $contestId,
                    'total_votes' => $totalVotes,
                    'total_amount' => $totalAmount,
                    'votes_recorded' => $votesRecorded,
                    'status' => $transaction->status,
                ]);

                return $votesRecorded;
            });
        } catch (QueryException $exception) {
            if ($this->isCheckoutTokenConflict($exception)) {
                Log::warning('Duplicate checkout request blocked by database constraint.', [
                    'user_id' => $userId,
                    'voter_token' => $voterToken,
                    'checkout_token' => $checkoutToken,
                ]);

                return $this->duplicateCheckoutResponse();
            }

            throw $exception;
        }

        if (! $votesRecorded) {
            return back()->withErrors([
                'checkout' => 'Vote processing is not available right now. Please try again later.',
            ]);
        }

        return back()->with('success', 'Votes submitted successfully');
    }

    /**
     * Ensure voting is currently enabled system-wide.
     */
    protected function ensureVotingIsEnabled(?int $userId, string $checkoutToken, string $voterToken): ?RedirectResponse
    {
        $votingEnabled = filter_var(
            Setting::get('voting_enabled', true),
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        );

        if ($votingEnabled === false) {
            Log::warning('Voting attempt blocked because voting is disabled.', [
                'user_id' => $userId,
                'voter_token' => $voterToken,
                'checkout_token' => $checkoutToken,
            ]);

            return back()->withErrors([
                'system' => 'Voting is currently unavailable. Please try again later.',
            ]);
        }

        return null;
    }

    /**
     * Resolve the active vote price from settings.
     */
    protected function resolveVotePrice(): float
    {
        $configuredPrice = Setting::get('vote_price', 50);

        if (! is_numeric($configuredPrice) || (float) $configuredPrice <= 0) {
            return 50.00;
        }

        return (float) $configuredPrice;
    }

    /**
     * Normalize checkout items by contestant and total votes.
     *
     * @param  array<int, array{contestant_id:int, votes:int}>  $items
     */
    protected function normalizeItems(array $items): Collection
    {
        $normalizedItems = collect($items)
            ->groupBy('contestant_id')
            ->map(function (Collection $groupedItems, int|string $contestantId): array {
                return [
                    'contestant_id' => (int) $contestantId,
                    'votes' => (int) $groupedItems->sum('votes'),
                ];
            })
            ->values();

        foreach ($normalizedItems as $item) {
            if ($item['votes'] < 1 || $item['votes'] > 1000) {
                throw ValidationException::withMessages([
                    'items' => 'Each contestant vote total must be between 1 and 1000.',
                ]);
            }
        }

        return $normalizedItems;
    }

    /**
     * Ensure all selected contestants belong to active contests.
     */
    protected function validateContestAvailability(Collection $contestants, ?int $userId, string $checkoutToken): void
    {
        foreach ($contestants as $contestant) {
            $contest = $contestant->contest;

            if (! $contest) {
                $message = 'This contestant is no longer available.';
            } elseif ($contest->isActive()) {
                continue;
            } elseif ($contest->status() === 'upcoming') {
                $message = 'Voting for this contest has not started yet.';
            } else {
                $message = 'Voting for this contest has ended.';
            }

            Log::warning('Voting attempt blocked for inactive or missing contest.', [
                'user_id' => $userId,
                'checkout_token' => $checkoutToken,
                'contestant_id' => $contestant->id,
                'contest_id' => $contestant->contest_id,
            ]);

            throw ValidationException::withMessages([
                'items' => $message,
            ]);
        }
    }

    /**
     * Ensure all selected contestants belong to the same contest.
     */
    protected function resolveContestId(Collection $contestants): int
    {
        $contestIds = $contestants
            ->pluck('contest_id')
            ->filter()
            ->unique()
            ->values();

        if ($contestIds->count() !== 1) {
            throw ValidationException::withMessages([
                'items' => 'All selected contestants must belong to the same contest.',
            ]);
        }

        return (int) $contestIds->first();
    }

    /**
     * Enforce the contest vote limit for the provided voter token.
     */
    protected function enforceVoteLimit(?int $userId, string $voterToken, int $contestId, Collection $items, ?string $email = null): void
    {
        $incomingVotes = (int) $items->sum('votes');

        $voteLimitQuery = Vote::query()
            ->where('contest_id', $contestId)
            ->lockForUpdate();

        if ($userId) {
            $voteLimitQuery->where('user_id', $userId);
        } else {
            if ($email && Schema::hasColumn('votes', 'email')) {
                $voteLimitQuery->where(function ($query) use ($voterToken, $email): void {
                    $query
                        ->where('voter_token', $voterToken)
                        ->orWhere('email', $email);
                });
            } else {
                Log::info('Vote limit check (guest)', [
                    'voter_token' => $voterToken,
                    'email' => $email,
                    'contest_id' => $contestId,
                ]);

                $voteLimitQuery->where('voter_token', $voterToken);
            }
        }

        $existingVotes = (int) $voteLimitQuery->sum('votes_count');

        if (($existingVotes + $incomingVotes) > 50) {
            throw ValidationException::withMessages([
                'items' => 'Vote limit exceeded for this contest',
            ]);
        }
    }

    /**
     * Persist votes and update cached contestant totals.
     */
    protected function recordVotes(
        Transaction $transaction,
        Collection $items,
        Collection $contestants,
        ?int $userId,
        string $voterToken,
    ): void {
        foreach ($items as $item) {
            $contestant = $contestants->get($item['contestant_id']);

            if (! $contestant) {
                continue;
            }

            Vote::query()->create([
                'transaction_id' => $transaction->id,
                'user_id' => $userId,
                'voter_token' => $voterToken,
                'contestant_id' => $contestant->id,
                'contest_id' => $contestant->contest_id,
                'votes_count' => $item['votes'],
            ]);

            Contestant::query()
                ->whereKey($contestant->id)
                ->increment('total_votes', $item['votes']);
        }

        Cache::forget('leaderboard_all_page_1');

        $contestants
            ->pluck('contest_id')
            ->filter()
            ->unique()
            ->each(function ($contestId): void {
                Cache::forget("leaderboard_{$contestId}_page_1");
            });
    }

    /**
     * Build the user-facing response for duplicate checkout attempts.
     */
    protected function duplicateCheckoutResponse(): RedirectResponse
    {
        return back()->withErrors([
            'checkout' => 'Your vote has already been recorded. No further action is needed.',
        ]);
    }

    /**
     * Determine if the query exception was caused by a duplicate checkout token.
     */
    protected function isCheckoutTokenConflict(QueryException $exception): bool
    {
        $sqlState = $exception->errorInfo[0] ?? null;
        $driverCode = $exception->errorInfo[1] ?? null;
        $message = $exception->getMessage();

        return ($sqlState === '23000' || $sqlState === '23505' || $driverCode === 1062)
            && str_contains($message, 'checkout_token');
    }
}
