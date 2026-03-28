<?php

namespace Database\Seeders;

use App\Models\Contest;
use App\Models\Contestant;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Vote;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Vote::query()->delete();
        Transaction::query()->delete();
        Contestant::query()->delete();
        Contest::query()->delete();
        Setting::query()->whereIn('key', ['vote_price', 'voting_enabled'])->delete();

        User::query()->firstOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        if (User::query()->count() < 15) {
            User::factory()->count(15 - User::query()->count())->create();
        }

        $this->call([
            ContestSeeder::class,
            ContestantSeeder::class,
            SettingSeeder::class,
            VoteSeeder::class,
        ]);
    }
}
