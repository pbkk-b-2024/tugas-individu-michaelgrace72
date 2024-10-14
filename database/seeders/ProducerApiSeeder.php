<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producer;
use Http;
use Str;

class ProducerApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    $api_key = env('TMDB_API_KEY');
for ($tmdbid = 1; $tmdbid <= 1000; $tmdbid++){
    try {
        $response = Http::get('https://api.themoviedb.org/3/person/'.$tmdbid.'?api_key='.$api_key);
        if ($response->failed()) {
            continue;
        }
        $newPerson = $response->json();
        
        // Check if the person is known for Production, Writing, Camera, or Directing work
        $knownForDepartment = $newPerson['known_for_department'] ?? '';

        if (in_array($knownForDepartment, ['Production', 'Writing', 'Camera', 'Directing'])) {
            Producer::create([
                'tmdb_id' => $newPerson['id'],
                'name' => $newPerson['name'],
                'role' => $knownForDepartment,
                'slug' => Str::slug($newPerson['name']),
                'poster_path' => $newPerson['profile_path'],
            ]);
        }

    } catch (\Throwable $th) {
        // Handle exception
    }
}

    }
}
