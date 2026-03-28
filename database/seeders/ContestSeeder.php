<?php

namespace Database\Seeders;

use App\Models\Contest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ContestSeeder extends Seeder
{
    /**
     * Seed the application's contests.
     */
    public function run(): void
    {
        Contest::query()->create([
            'name' => 'Campus Star Showcase 2026',
            'slug' => 'campus-star-showcase-2026',
            'description' => 'A campus-wide contest celebrating standout students in talent, leadership, and creativity.',
            'start_date' => Carbon::now()->subDays(5),
            'end_date' => Carbon::now()->addDays(10),
        ]);

        Contest::query()->create([
            'name' => 'Future Voices Talent Challenge',
            'slug' => 'future-voices-talent-challenge',
            'description' => 'A live voting contest spotlighting rising performers, creators, and innovators.',
            'start_date' => Carbon::now()->subDays(2),
            'end_date' => Carbon::now()->addDays(5),
        ]);

        Contest::query()->create([
            'name' => 'Creative Sprint Finals',
            'slug' => 'creative-sprint-finals',
            'description' => 'A completed contest used to test expired-voting behavior and historical records.',
            'start_date' => Carbon::now()->subDays(20),
            'end_date' => Carbon::now()->subDays(5),
        ]);
    }
}
