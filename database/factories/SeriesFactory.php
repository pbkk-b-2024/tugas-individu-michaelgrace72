<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Series>
 */
class SeriesFactory extends Factory
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
            'name' => $this->faker->sentence(3),
            'slug' => $this->faker->slug,
            'created_year' => $this->faker->year,
            'poster_path' => $this->faker->imageUrl(300, 450, 'series'),
            'visits' => $this->faker->numberBetween(1, 1000),
        ];
    }
}
