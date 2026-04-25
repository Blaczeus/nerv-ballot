<?php

namespace Tests\Feature\Voting;

use App\Models\Contest;
use App\Models\Contestant;
use App\Models\Transaction;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CheckoutFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_checkout_creates_transaction_votes_and_updates_total_votes(): void
    {
        config()->set('app.voting_mode', 'free');

        $contest = $this->createActiveContest();
        $contestant = Contestant::query()->create([
            'name' => 'Ada Bright',
            'slug' => 'ada-bright',
            'contest_id' => $contest->id,
            'category' => 'Music',
            'total_votes' => 0,
        ]);

        $response = $this
            ->from(route('checkout'))
            ->post(route('checkout.process'), [
                'email' => 'voter@example.com',
                'voter_token' => (string) Str::uuid(),
                'checkout_token' => (string) Str::uuid(),
                'items' => [
                    [
                        'contestant_id' => $contestant->id,
                        'votes' => 5,
                    ],
                ],
            ]);

        $response->assertRedirect(route('checkout'));
        $response->assertSessionHas('success', 'Votes submitted successfully');

        $transaction = Transaction::query()->first();

        $this->assertNotNull($transaction);
        $this->assertSame('completed', $transaction->status);
        $this->assertSame(5, $transaction->total_votes);
        $this->assertSame('voter@example.com', $transaction->email);

        $this->assertDatabaseHas('votes', [
            'transaction_id' => $transaction->id,
            'contestant_id' => $contestant->id,
            'contest_id' => $contest->id,
            'votes_count' => 5,
        ]);

        $this->assertSame(5, $contestant->fresh()->total_votes);
    }

    public function test_duplicate_checkout_token_is_rejected(): void
    {
        config()->set('app.voting_mode', 'free');

        $contest = $this->createActiveContest();
        $contestant = Contestant::query()->create([
            'name' => 'Mina Cole',
            'slug' => 'mina-cole',
            'contest_id' => $contest->id,
            'category' => 'Dance',
            'total_votes' => 0,
        ]);

        $checkoutToken = (string) Str::uuid();
        $payload = [
            'email' => 'repeat@example.com',
            'voter_token' => (string) Str::uuid(),
            'checkout_token' => $checkoutToken,
            'items' => [
                [
                    'contestant_id' => $contestant->id,
                    'votes' => 3,
                ],
            ],
        ];

        $this->from(route('checkout'))->post(route('checkout.process'), $payload);

        $response = $this
            ->from(route('checkout'))
            ->post(route('checkout.process'), $payload);

        $response->assertRedirect(route('checkout'));
        $response->assertSessionHasErrors([
            'checkout' => 'Your vote has already been recorded. No further action is needed.',
        ]);

        $this->assertSame(1, Transaction::query()->count());
    }

    public function test_vote_limit_is_enforced_per_voter_per_contest(): void
    {
        config()->set('app.voting_mode', 'free');

        $contest = $this->createActiveContest();
        $contestant = Contestant::query()->create([
            'name' => 'Tolu Marks',
            'slug' => 'tolu-marks',
            'contest_id' => $contest->id,
            'category' => 'Tech',
            'total_votes' => 45,
        ]);

        $voterToken = (string) Str::uuid();
        $existingTransaction = Transaction::query()->create([
            'user_id' => null,
            'voter_token' => $voterToken,
            'email' => 'existing@example.com',
            'checkout_token' => (string) Str::uuid(),
            'total_votes' => 45,
            'price_per_vote' => 50,
            'total_amount' => 2250,
            'status' => 'completed',
        ]);

        Vote::query()->create([
            'transaction_id' => $existingTransaction->id,
            'user_id' => null,
            'voter_token' => $voterToken,
            'contestant_id' => $contestant->id,
            'contest_id' => $contestant->contest_id,
            'votes_count' => 45,
        ]);

        $response = $this
            ->from(route('checkout'))
            ->post(route('checkout.process'), [
                'email' => 'limit@example.com',
                'voter_token' => $voterToken,
                'checkout_token' => (string) Str::uuid(),
                'items' => [
                    [
                        'contestant_id' => $contestant->id,
                        'votes' => 10,
                    ],
                ],
            ]);

        $response->assertRedirect(route('checkout'));
        $response->assertSessionHasErrors([
            'items' => 'Vote limit exceeded for this contest',
        ]);

        $this->assertSame(1, Vote::query()->count());
        $this->assertSame(1, Transaction::query()->count());
    }

    public function test_inactive_contestants_are_rejected(): void
    {
        config()->set('app.voting_mode', 'free');

        $contest = Contest::query()->create([
            'name' => 'Expired Contest',
            'slug' => 'expired-contest',
            'category' => 'Talent Shows',
            'description' => 'Expired voting round.',
            'start_date' => now()->subDays(10),
            'end_date' => now()->subDay(),
        ]);

        $contestant = Contestant::query()->create([
            'name' => 'Ife Stone',
            'slug' => 'ife-stone',
            'contest_id' => $contest->id,
            'category' => 'Fashion',
            'total_votes' => 0,
        ]);

        $response = $this
            ->from(route('checkout'))
            ->post(route('checkout.process'), [
                'email' => 'inactive@example.com',
                'voter_token' => (string) Str::uuid(),
                'checkout_token' => (string) Str::uuid(),
                'items' => [
                    [
                        'contestant_id' => $contestant->id,
                        'votes' => 2,
                    ],
                ],
            ]);

        $response->assertRedirect(route('checkout'));
        $response->assertSessionHasErrors([
            'items' => 'One or more selected contestants are not available for voting right now.',
        ]);

        $this->assertSame(0, Transaction::query()->count());
        $this->assertSame(0, Vote::query()->count());
    }

    protected function createActiveContest(): Contest
    {
        return Contest::query()->create([
            'name' => 'Campus Star Showcase',
            'slug' => 'campus-star-showcase',
            'category' => 'Campus Competitions',
            'description' => 'Active contest for vote testing.',
            'start_date' => now()->subDay(),
            'end_date' => now()->addDays(5),
        ]);
    }
}
