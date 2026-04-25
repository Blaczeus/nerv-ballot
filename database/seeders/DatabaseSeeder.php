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
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Vote::query()->delete();
        Transaction::query()->delete();
        Contestant::query()->withTrashed()->forceDelete();
        Contest::query()->withTrashed()->forceDelete();
        Setting::query()->whereIn('key', ['vote_price', 'voting_enabled'])->delete();

        Schema::enableForeignKeyConstraints();

        User::query()->firstOrCreate([
            'email' => 'admin@test.com',
        ], [
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
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
