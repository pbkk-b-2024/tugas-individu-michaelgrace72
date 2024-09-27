<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Http;
use Str;
use App\Models\Company;

class CompaniesApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $api_key = env('TMDB_API_KEY');
        for ($tmdbid = 1; $tmdbid <= 200; $tmdbid++){
            try {
                $response = Http::get('https://api.themoviedb.org/3/company/'.$tmdbid.'?api_key='.$api_key);
                if ($response->failed()) {
                    continue;
                }
                $newCompany = $response->json();
                Company::Create(
                    ['tmdb_id' => $newCompany['id'],
                    'name' => $newCompany['name'],
                    'slug' => Str::slug($newCompany['name']),
                    'logo_path' => $newCompany['logo_path'],
                    'origin_country' => $newCompany['origin_country'],
                ]);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }
}
