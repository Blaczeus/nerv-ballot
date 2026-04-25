<?php

namespace Database\Seeders;

use App\Models\Contestant;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
// use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VoteSeeder extends Seeder
{
    /**
     * Seed transactions and votes with uneven real-world-like distribution.
     */
    public function run(): void
    {
        DB::transaction(function (): void {
            $users = User::query()->select(['id', 'email'])->get();
            $contestants = Contestant::query()->with('contest')->orderBy('id')->get();
            $anonymousTokensByContest = [];
            $userVotesByContest = [];

            $targetVotes = [
                0, 0, 1, 3, 7, 9,
                0, 4, 8, 67, 123, 188,
                0, 2, 11, 95, 580, 1490,
                0, 0, 1, 5, 10, 18, 42, 76, 128, 205, 610, 1280,
                0, 3, 6, 15, 27, 64, 92, 154, 244, 398, 720, 1460,
                0, 1, 7, 22, 49, 88, 117, 171, 268, 430, 840, 1325,
            ];

            foreach ($contestants as $index => $contestant) {
                if ($contestant->contest?->status() === 'upcoming') {
                    continue;
                }

                $targetTotal = $targetVotes[$index] ?? 0;

                if ($targetTotal <= 0) {
                    continue;
                }

                $remainingVotes = $targetTotal;

                while ($remainingVotes > 0) {
                    $voteBatch = $this->resolveVoteBatch($remainingVotes);
                    $timestamp = $this->resolveVoteTimestamp(
                        $contestant->contest?->start_date ?? Carbon::now()->subDays(10),
                        $contestant->contest?->end_date ?? Carbon::now(),
                    );
                    $contestId = $contestant->contest_id;
                    $isAnonymous = random_int(0, 1) === 1;
                    $user = null;
                    $voterToken = null;
                    $userId = null;
                    $email = null;

                    if (! $isAnonymous) {
                        $contestUserVotes = $userVotesByContest[$contestId] ?? [];
                        $eligibleUsers = $users
                            ->filter(fn (User $candidate) => (($contestUserVotes[$candidate->id] ?? 0) + $voteBatch) <= 50)
                            ->values();

                        if ($eligibleUsers->isNotEmpty()) {
                            $user = $eligibleUsers->random();
                            $userId = $user->id;
                            $contestUserVotes[$userId] = ($contestUserVotes[$userId] ?? 0) + $voteBatch;
                            $userVotesByContest[$contestId] = $contestUserVotes;
                        } else {
                            $isAnonymous = true;
                        }
                    }

                    if ($isAnonymous) {
                        $contestAnonymousVotes = $anonymousTokensByContest[$contestId] ?? [];
                        $eligibleTokens = collect(array_keys($contestAnonymousVotes))
                            ->filter(fn ($token) => (($contestAnonymousVotes[$token] ?? 0) + $voteBatch) <= 50)
                            ->values();

                        if ($eligibleTokens->isEmpty() || random_int(0, 2) === 0) {
                            $voterToken = (string) Str::uuid();
                            $contestAnonymousVotes[$voterToken] = $voteBatch;
                        } else {
                            $voterToken = $eligibleTokens->random();
                            $contestAnonymousVotes[$voterToken] += $voteBatch;
                        }

                        $anonymousTokensByContest[$contestId] = $contestAnonymousVotes;
                    }

                    $email = $user
                        ? $user->email
                        : fake()->safeEmail();

                    $transaction = Transaction::query()->create([
                        'user_id' => $userId,
                        'voter_token' => $voterToken,
                        'email' => $email,
                        'checkout_token' => (string) Str::uuid(),
                        'total_votes' => $voteBatch,
                        'price_per_vote' => 100,
                        'total_amount' => $voteBatch * 100,
                        'status' => 'completed',
                        'payment_reference' => 'seed-'.Str::upper(Str::random(12)),
                        'created_at' => $timestamp,
                        'updated_at' => $timestamp,
                    ]);

                    Vote::query()->create([
                        'transaction_id' => $transaction->id,
                        'user_id' => $transaction->user_id,
                        'voter_token' => $transaction->voter_token,
                        'contestant_id' => $contestant->id,
                        'contest_id' => $contestant->contest_id,
                        'votes_count' => $voteBatch,
                        'created_at' => $timestamp,
                        'updated_at' => $timestamp,
                    ]);

                    $remainingVotes -= $voteBatch;
                }
            }

            // This aggregate refresh is safe here because this is seeding-only code.
            DB::table('contestants')->update([
                'total_votes' => DB::raw('(SELECT COALESCE(SUM(votes_count), 0) FROM votes WHERE votes.contestant_id = contestants.id)'),
            ]);
        });
    }

    /**
     * Resolve a realistic vote batch size for a transaction.
     */
    protected function resolveVoteBatch(int $remainingVotes): int
    {
        if ($remainingVotes <= 10) {
            return $remainingVotes;
        }

        $maxBatch = min($remainingVotes, 250);

        return random_int(1, $maxBatch);
    }

    /**
     * Pick a timestamp that falls within the contest window.
     */
    protected function resolveVoteTimestamp($startDate, $endDate): Carbon
    {
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        $effectiveEnd = $endDate->isFuture() ? Carbon::now() : $endDate->copy();

        if ($effectiveEnd->lessThan($startDate)) {
            return $startDate->copy();
        }

        return Carbon::instance(
            fake()->dateTimeBetween($startDate, $effectiveEnd)
        );
    }
}
