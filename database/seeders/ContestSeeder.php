<?php

namespace Database\Seeders;

use App\Models\Contest;
use Illuminate\Database\Seeder;

class ContestSeeder extends Seeder
{
    /**
     * Seed the application's contests.
     */
    public function run(): void
    {
        $endedStart = now()->subDays(20);
        $endedEnd = now()->subDays(5);
        $activeStart = now()->subDays(2);
        $activeEnd = now()->addDays(5);
        $upcomingStart = now()->addDays(2);
        $upcomingEnd = now()->addDays(10);

        $this->createContest(
            'Campus Star Showcase 2026',
            'campus-star-showcase-2026',
            'Campus Competitions',
            $endedStart,
            $endedEnd,
        );

        $this->createContest(
            'Future Voices Talent Challenge',
            'future-voices-talent-challenge',
            'Talent Shows',
            $endedStart,
            $endedEnd,
        );

        $this->createContest(
            'Creative Sprint Finals',
            'creative-sprint-finals',
            'Online Challenges',
            $endedStart,
            $endedEnd,
        );

        $this->createContest(
            'Next Gen Campus Awards',
            'next-gen-campus-awards',
            'Campus Competitions',
            $activeStart,
            $activeEnd,
        );

        $this->createContest(
            'Street Rhythm Talent League',
            'street-rhythm-talent-league',
            'Talent Shows',
            $activeStart,
            $activeEnd,
        );

        $this->createContest(
            'Digital Creator Faceoff',
            'digital-creator-faceoff',
            'Online Challenges',
            $activeStart,
            $activeEnd,
        );

        $this->createContest(
            'Campus Icon Search 2026',
            'campus-icon-search-2026',
            'Campus Competitions',
            $upcomingStart,
            $upcomingEnd,
        );

        $this->createContest(
            'Rising Stage Talent Quest',
            'rising-stage-talent-quest',
            'Talent Shows',
            $upcomingStart,
            $upcomingEnd,
        );

        $this->createContest(
            'Innovation Spotlight Challenge',
            'innovation-spotlight-challenge',
            'Online Challenges',
            $upcomingStart,
            $upcomingEnd,
        );
    }

    protected function createContest(
        string $name,
        string $slug,
        string $category,
        $start,
        $end,
    ): Contest {
        return Contest::query()->create([
            'name' => $name,
            'slug' => $slug,
            'description' => fake()->sentence(30),
            'category' => $category,
            'start_date' => $start,
            'end_date' => $end,
        ]);
    }
}
