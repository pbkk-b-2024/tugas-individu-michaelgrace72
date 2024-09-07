<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Episode>
 */
class EpisodeFactory extends Factory
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
            'season_id' => \App\Models\Season::factory(),
            'name' => $this->faker->sentence(3),
            'episode_number' => $this->faker->numberBetween(1, 20),
            'is_public' => $this->faker->boolean,
            'visits' => $this->faker->numberBetween(1, 1000),
            'slug' => $this->faker->slug,
            'overview' => $this->faker->paragraph,
        ];
    }
}
