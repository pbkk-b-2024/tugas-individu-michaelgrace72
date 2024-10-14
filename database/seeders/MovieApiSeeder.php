<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Http;
use App\Models\Movie;
use Str;


class MovieApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $api_key = env('TMDB_API_KEY');
        for ($tmdbid = 1; $tmdbid <= 1001; $tmdbid++) {
                try {
                    $response = Http::get('https://api.themoviedb.org/3/movie/'.$tmdbid.'?api_key='.$api_key);
                    if ($response->failed()) {
                        continue;
                    }
                    $newMovie = $response->json();
                    Movie::Create(
                        ['tmdb_id' => $newMovie['id'],
                        'title' => $newMovie['title'],
                        'release_date' => $newMovie['release_date'],
                        'runtime' => $newMovie['runtime'],
                        'lang' => $newMovie['original_language'],
                        'video_format' => $newMovie['video'],
                        'slug' => Str::slug($newMovie['title']),
                        'rating' => $newMovie['vote_average'],
                        'poster_path' => $newMovie['poster_path'],
                        'overview' => $newMovie['overview'],
                    ]);
                } catch (\Throwable $th) {
                    //throw $th;
                }
        }
    }
}
