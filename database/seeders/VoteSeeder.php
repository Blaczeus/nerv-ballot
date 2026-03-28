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
            $users = User::query()->pluck('id');
            $contestants = Contestant::query()->with('contest')->orderBy('id')->get();

            $targetVotes = [
                0, 0, 1, 3, 7, 9, 12, 18, 56, 74, 98, 132, 176, 540, 1180,
                0, 4, 8, 67, 123, 188, 620, 1490,
                0, 2, 11, 95, 580,
            ];

            foreach ($contestants as $index => $contestant) {
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

                    $transaction = Transaction::query()->create([
                        'user_id' => $users->random(),
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
                        'contestant_id' => $contestant->id,
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
