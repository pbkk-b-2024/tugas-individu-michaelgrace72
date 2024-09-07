<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Season>
 */
class SeasonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
             'tmdb_id' => $this->faker->unique()->randomNumber(6),
            'series_id' => \App\Models\Series::factory(),
            'name' => $this->faker->sentence(2),
            'season_number' => $this->faker->numberBetween(1, 10),
            'slug' => $this->faker->slug,
            'poster_path' => $this->faker->imageUrl(300, 450, 'season'),
        ];
    }
}
