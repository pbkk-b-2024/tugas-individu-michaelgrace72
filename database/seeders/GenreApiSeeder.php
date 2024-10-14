<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre;
use Http;
use Str;

class GenreApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $api_key = env('TMDB_API_KEY');
        for($tmdbid = 1; $tmdbid <= 1001; $tmdbid++) {
            try {
                $response = Http::get('https://api.themoviedb.org/3/genre/movie/list?api_key='.$api_key);
                if ($response->failed()) {
                    continue;
                }
                $newGenre = $response->json();
                Genre::Create(
                    ['tmdb_id' => $newGenre['id'],
                    'name' => $newGenre['name'],
                    'slug' => Str::slug($newGenre['name']),
                ]);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }
}
