<?php

namespace Database\Seeders;

use App\Models\Contest;
use App\Models\Contestant;
use Illuminate\Database\Seeder;

class ContestantSeeder extends Seeder
{
    /**
     * Seed the application's contestants.
     */
    public function run(): void
    {
        $contests = Contest::query()->orderBy('id')->get();

        foreach ($contests as $contest) {
            $count = match ($contest->status()) {
                'active' => 12,
                'upcoming' => 11,
                'ended' => 10,
                default => 0,
            };

            Contestant::factory()
                ->count($count)
                ->create([
                    'contest_id' => $contest->id,
                ]);
        }
    }
}
