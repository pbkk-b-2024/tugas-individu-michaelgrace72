<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Series;
use App\Models\Cast;
use App\Models\Season;
use App\Models\Episode;
use App\Models\Genre;
use App\Models\Tag;
use App\Models\Producer;
use App\Models\Company;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // Movie::factory(10)->create();
        // Series::factory()->count(10)->create();
        // Cast::factory()->count(20)->create();
        // Season::factory()->count(30)->create();
        // Episode::factory()->count(50)->create();
        // Producer::factory()->count(10)->create();
        // Company::factory()->count(5)->create();
        // Genre::factory()->count(30)->create();
        Tag::factory()->count(30)->create();
    }
}
