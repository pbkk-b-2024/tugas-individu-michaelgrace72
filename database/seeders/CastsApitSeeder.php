<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cast;
use Http;
use Str;

class CastsApitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $api_key = env('TMDB_API_KEY');
        for ($tmdbid = 1; $tmdbid <= 200; $tmdbid++){
            try {
                $response = Http::get('https://api.themoviedb.org/3/person/'.$tmdbid.'?api_key='.$api_key);
                if ($response->failed()) {
                    continue;
                }
                $newCast = $response->json();
                Cast::Create(
                    ['tmdb_id' => $newCast['id'],
                    'name' => $newCast['name'],
                    'slug' => Str::slug($newCast['name']),
                    'poster_path' => $newCast['profile_path'],
                    'birthday' => $newCast['birthday'],
                ]);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        //
    }
}
