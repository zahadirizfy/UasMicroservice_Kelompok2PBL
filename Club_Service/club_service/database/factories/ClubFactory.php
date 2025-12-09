<?php

namespace Database\Factories;

use App\Models\Club;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Club>
 */
class ClubFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Club::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $clubs = [
            ['name' => 'Persib Bandung', 'city' => 'Bandung', 'stadium' => 'Stadion Si Jalak Harupat'],
            ['name' => 'Persija Jakarta', 'city' => 'Jakarta', 'stadium' => 'Stadion Utama Gelora Bung Karno'],
            ['name' => 'Arema FC', 'city' => 'Malang', 'stadium' => 'Stadion Kanjuruhan'],
            ['name' => 'PSM Makassar', 'city' => 'Makassar', 'stadium' => 'Stadion Mattoangin'],
            ['name' => 'Bali United', 'city' => 'Gianyar', 'stadium' => 'Stadion Kapten I Wayan Dipta'],
        ];

        $selectedClub = fake()->randomElement($clubs);

        return [
            'name' => $selectedClub['name'] . ' ' . fake()->unique()->numberBetween(1, 9999),
            'description' => fake()->paragraph(),
            'city' => $selectedClub['city'],
            'stadium' => $selectedClub['stadium'],
            'founded_year' => fake()->numberBetween(1900, 2020),
            'logo_url' => fake()->optional()->imageUrl(200, 200, 'sports'),
        ];
    }
}

