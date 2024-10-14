<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Series;
use App\Models\Season;
use Http;
use Str;

class SeriesApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $api_key = env('TMDB_API_KEY');
        for ($tmdbid = 1; $tmdbid <= 1000; $tmdbid++) {
                try {
                    $response = Http::get('https://api.themoviedb.org/3/tv/'.$tmdbid.'?api_key='.$api_key);
                    if ($response->failed()) {
                        continue;
                    }
                    $newSeries = $response->json();
                    $createdSeries = Series::create([
                'tmdb_id' => $newSeries['id'],
                'name' => $newSeries['name'],
                'slug' => Str::slug($newSeries['name']),
                'created_year' => $newSeries['first_air_date'],
                'poster_path' => $newSeries['poster_path'],
                'rating' => $newSeries['vote_average'],
            ]);

            // Loop through the seasons array and add each season
            if (isset($newSeries['seasons'])) {
                foreach ($newSeries['seasons'] as $season) {
                    Season::create([
                        'series_id' => $createdSeries->id, // Associate with the series
                        'tmdb_id' => $season['id'],
                        'name' => $season['name'],
                        'slug' => Str::slug($season['name']),
                        // 'air_date' => $season['air_date'],
                        // 'episode_count' => $season['episode_count'],
                        'poster_path' => $season['poster_path'],
                        'season_number' => $season['season_number'],
                        // 'overview' => $season['overview'],
                        // 'vote_average' => $season['vote_average'],
                    ]);
                }
            }


                } catch (\Throwable $th) {
                    //throw $th;
                }
        }
 
    }
}
