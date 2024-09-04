<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Movie;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Movie::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tmdb_id' => $this->faker->unique()->numerify('##########'),
            'title' => $this->faker->sentence(3),
            'release_date' => $this->faker->date(),
            'runtime' => $this->faker->numberBetween(60, 180),
            'lang' => $this->faker->languageCode(),
            'video_format' => $this->faker->randomElement(['DVD', 'Blu-ray', 'VHS']),
            'is_public' => $this->faker->boolean(),
            'visits' => $this->faker->numberBetween(1, 1000),
            'slug' => $this->faker->slug(),
            'rating' => $this->faker->randomFloat(1, 0, 10),
            'poster_path' => $this->faker->imageUrl(640,480,'movies',true),
            'backdrop_path' => $this->faker->imageUrl(1920,1080,'movies',true),
            'overview' => $this->faker->paragraph(3),
            'created_at' => now(),
            'updated_at' => now(), 
            
        ];
    }
}
