<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cast>
 */
class CastFactory extends Factory
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
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
            'poster_path' => $this->faker->imageUrl(300, 450, 'cast'),
        ];
    }
}
