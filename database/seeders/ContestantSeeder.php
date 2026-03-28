<?php

namespace Database\Seeders;

use App\Models\Contest;
use App\Models\Contestant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContestantSeeder extends Seeder
{
    /**
     * Seed the application's contestants.
     */
    public function run(): void
    {
        $faker = fake();
        $categories = ['Music', 'Dance', 'Tech', 'Fashion', 'Comedy', 'Leadership'];
        $locations = [
            'Lagos',
            'Abuja',
            'Oyo',
            'Rivers',
            'Enugu',
            'Kano',
            'Kaduna',
            'Ogun',
            'Delta',
            'Anambra',
        ];

        $distribution = [
            'campus-star-showcase-2026' => 15,
            'future-voices-talent-challenge' => 8,
            'creative-sprint-finals' => 5,
        ];

        foreach ($distribution as $contestSlug => $count) {
            $contest = Contest::query()->where('slug', $contestSlug)->firstOrFail();

            for ($index = 0; $index < $count; $index++) {
                $name = $faker->unique()->name();

                Contestant::query()->create([
                    'contest_id' => $contest->id,
                    'name' => $name,
                    'slug' => Str::slug($name.'-'.$contest->id.'-'.$index),
                    'image' => null,
                    'category' => $faker->randomElement($categories),
                    'gender' => $faker->randomElement(['male', 'female']),
                    'location' => $faker->randomElement($locations),
                    'description' => $faker->sentence(18),
                    'total_votes' => 0,
                ]);
            }
        }
    }
}
