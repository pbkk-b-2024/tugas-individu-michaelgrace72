<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
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
            'name' => $this->faker->company,
            'slug' => $this->faker->slug,
            'logo_path' => $this->faker->imageUrl(200, 200, 'company'),
            'origin_country' => $this->faker->countryCode,
        ];
    }
}
