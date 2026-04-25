<?php

namespace Database\Factories;

use App\Models\Contestant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contestant>
 */
class ContestantFactory extends Factory
{
    /**
     * @var list<string>
     */
    protected array $maleImages = [
        '/tmp/images/products/mens/men-1.jpg',
        '/tmp/images/products/mens/men-11.jpg',
        '/tmp/images/products/mens/men-12.jpg',
        '/tmp/images/products/mens/men-13.jpg',
        '/tmp/images/products/mens/men-14.jpg',
        '/tmp/images/products/mens/men-15.jpg',
        '/tmp/images/products/mens/men-16.jpg',
        '/tmp/images/products/mens/men-17.jpg',
        '/tmp/images/products/mens/men-18.jpg',
        '/tmp/images/products/mens/men-19.jpg',
        '/tmp/images/products/mens/men-2.jpg',
        '/tmp/images/products/mens/men-3.jpg',
        '/tmp/images/products/mens/men-5.jpg',
        '/tmp/images/products/mens/men-7.jpg',
        '/tmp/images/products/mens/men-8.jpg',
        '/tmp/images/products/mens/men-9.jpg',
    ];

    /**
     * @var list<string>
     */
    protected array $femaleImages = [
        '/tmp/images/products/womens/grid-1.jpg',
        '/tmp/images/products/womens/grid-2.jpg',
        '/tmp/images/products/womens/grid-3.jpg',
        '/tmp/images/products/womens/women-1.jpg',
        '/tmp/images/products/womens/women-10.jpg',
        '/tmp/images/products/womens/women-102.jpg',
        '/tmp/images/products/womens/women-103.jpg',
        '/tmp/images/products/womens/women-104.jpg',
        '/tmp/images/products/womens/women-11.jpg',
        '/tmp/images/products/womens/women-111.jpg',
        '/tmp/images/products/womens/women-112.jpg',
        '/tmp/images/products/womens/women-12.jpg',
        '/tmp/images/products/womens/women-123.jpg',
        '/tmp/images/products/womens/women-124.jpg',
        '/tmp/images/products/womens/women-13.jpg',
        '/tmp/images/products/womens/women-131.jpg',
        '/tmp/images/products/womens/women-132.jpg',
        '/tmp/images/products/womens/women-133.jpg',
        '/tmp/images/products/womens/women-14.jpg',
        '/tmp/images/products/womens/women-181.jpg',
        '/tmp/images/products/womens/women-182.jpg',
        '/tmp/images/products/womens/women-183.jpg',
        '/tmp/images/products/womens/women-185.jpg',
        '/tmp/images/products/womens/women-186.jpg',
        '/tmp/images/products/womens/women-187.jpg',
        '/tmp/images/products/womens/women-188.jpg',
        '/tmp/images/products/womens/women-19.jpg',
        '/tmp/images/products/womens/women-2.jpg',
        '/tmp/images/products/womens/women-20.jpg',
        '/tmp/images/products/womens/women-23.jpg',
        '/tmp/images/products/womens/women-24.jpg',
        '/tmp/images/products/womens/women-29.jpg',
        '/tmp/images/products/womens/women-3.jpg',
        '/tmp/images/products/womens/women-30.jpg',
        '/tmp/images/products/womens/women-31.jpg',
        '/tmp/images/products/womens/women-33.jpg',
        '/tmp/images/products/womens/women-37.jpg',
        '/tmp/images/products/womens/women-38.jpg',
        '/tmp/images/products/womens/women-4.jpg',
        '/tmp/images/products/womens/women-41.jpg',
        '/tmp/images/products/womens/women-43.jpg',
        '/tmp/images/products/womens/women-47.jpg',
        '/tmp/images/products/womens/women-5.jpg',
        '/tmp/images/products/womens/women-63.jpg',
        '/tmp/images/products/womens/women-64.jpg',
        '/tmp/images/products/womens/women-69.jpg',
        '/tmp/images/products/womens/women-7.jpg',
        '/tmp/images/products/womens/women-70.jpg',
        '/tmp/images/products/womens/women-73.jpg',
        '/tmp/images/products/womens/women-74.jpg',
        '/tmp/images/products/womens/women-78.jpg',
        '/tmp/images/products/womens/women-8.jpg',
        '/tmp/images/products/womens/women-83.jpg',
        '/tmp/images/products/womens/women-84.jpg',
        '/tmp/images/products/womens/women-87.jpg',
        '/tmp/images/products/womens/women-9.jpg',
        '/tmp/images/products/womens/women-94.jpg',
    ];

    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Contestant>
     */
    protected $model = Contestant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->name();
        $gender = fake()->randomElement(['male', 'female']);

        return [
            'name' => $name,
            'slug' => Str::slug("$name-".Str::random(6)),
            'category' => fake()->randomElement(['Music', 'Dance', 'Tech', 'Fashion', 'Comedy', 'Leadership']),
            'gender' => $gender,
            'location' => fake()->randomElement([
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
            ]),
            'description' => fake()->sentence(18),
            'image' => $gender === 'male'
                ? fake()->randomElement($this->maleImages)
                : fake()->randomElement($this->femaleImages),
            'total_votes' => 0,
        ];
    }
}
