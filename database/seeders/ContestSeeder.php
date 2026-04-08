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
            'description' => 'A large-scale inter-university competition highlighting students in leadership, fashion, and performing arts. Participants represent their institutions and compete for recognition and prizes.',
            'category' => 'Campus Competitions',
            'start_date' => Carbon::now()->subDays(5),
            'end_date' => Carbon::now()->addDays(10),
        ]);

        Contest::query()->create([
            'name' => 'Future Voices Talent Challenge',
            'slug' => 'future-voices-talent-challenge',
            'description' => 'A public voting contest focused on discovering emerging talents in music, dance, and digital content creation. Open to a wide audience with strong community participation.',
            'category' => 'Talent Shows',
            'start_date' => Carbon::now()->subDays(2),
            'end_date' => Carbon::now()->addDays(5),
        ]);

        Contest::query()->create([
            'name' => 'Creative Sprint Finals',
            'slug' => 'creative-sprint-finals',
            'description' => 'A fast-paced creative competition where participants submitted projects across design, tech, and storytelling. This contest is now completed and used for historical data and testing.',
            'category' => 'Online Challenges',
            'start_date' => Carbon::now()->subDays(20),
            'end_date' => Carbon::now()->subDays(5),
        ]);
    }
}
