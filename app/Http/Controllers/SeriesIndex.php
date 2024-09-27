<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Models\Season;
use App\Models\User;
use Illuminate\Http\Request;
use Str;
use Http;

class SeriesIndex extends Controller
{
    public $search='';

    public $TMDBID='';
    public function create()
    {
        return view('series-create');
    }
    public function store(Request $request)
    {
    $api_key = env('TMDB_API_KEY');
    $input = $request->input('TMDBID');
    try {
        $response = Http::get('https://api.themoviedb.org/3/tv/'.$input.'?api_key='.$api_key);
        $seriesexists = Series::where('tmdb_id', $input)->first();
        if ($seriesexists) {
            return redirect()->route('admin.series.index')
                ->with('error', 'Series already exists.');
        }
        
        $newSeries = $response->json();
        
        try {
            // Create the series entry
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

            return redirect()->route('admin.series.index')
                ->with('success', 'Series and seasons created successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('admin.series.index')
                ->with('error', 'Failed to store series and seasons.');
        }
    } catch (\Throwable $th) {
        return redirect()->route('admin.series.index')
            ->with('error', 'Series not found.');
    }
}

    public function edit($id)
    {
        $series = Series::find($id);
        return view('series-edit', compact('series'));
    }
    public function update(Request $request, $id)
    {
        $series = Series::find($id);
        $series->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.series.index')
            ->with('success', 'series updated successfully.');
    }
    public function destroy($id)
    {
        $series= Series::find($id);
        $series->delete();

        return redirect()->route('admin.series.index')
            ->with('success', 'series deleted successfully.');
    }
    public function index(Request $request)
    {
        $search = $request->input('search');
        $series = Series::when($search, function ($query, $search) {
            return $query->whereRaw('LOWER(name) like ?', ['%' . strtolower($search) . '%']);
        })->orderBy('name')->paginate(5);

        // Send data to the view
        return view('series-index', compact('series'));

    }  
    // API Request
    public function showall(){
        $series = Series::all();
        return response()->json($series);
    }
    public function show($id){
        $series = Series::find($id);
        return response()->json($series);
    }
    public function storeapi(Request $request){
        $user = auth()->user();
        if ($user->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $input = $request->input('TMDBID');
        $api_key = env('TMDB_API_KEY');
        try {
            $response = Http::get('https://api.themoviedb.org/3/tv/'.$input.'?api_key='.$api_key);
            $seriesexists = Series::where('tmdb_id', $input)->first();
            if ($seriesexists) {
                return response()->json(['error' => 'Series already exists.'], 400);
            }
            
            $newSeries = $response->json();
            
            try {
                // Create the series entry
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
    
                return response()->json(['message' => 'Series and seasons created successfully.'], 201);
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Failed to store series and seasons.'], 500);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Series not found.'], 404);
        }

    }
    public function updateapi(Request $request, $id){
        $user = auth()->user();
        if ($user->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $series = Series::find($id);
        $input = $request->input('TMDBID');
        $api_key = env('TMDB_API_KEY');
        try {
            $response = Http::get('https://api.themoviedb.org/3/tv/'.$input.'?api_key='.$api_key);
            $newSeries = $response->json();
            $series->update([
                'tmdb_id' => $newSeries['id'],
                'name' => $newSeries['name'],
                'slug' => Str::slug($newSeries['name']),
                'created_year' => $newSeries['first_air_date'],
                'poster_path' => $newSeries['poster_path'],
                'rating' => $newSeries['vote_average'],
            ]);
            return response()->json(['message' => 'Series updated successfully.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Series not found.'], 404);
        }
    }
    public function deleteapi($id){
        $user = auth()->user();
        if ($user->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $series = Series::find($id);
        $series->delete();
        return response()->json(['message' => 'Series deleted successfully.'], 200);
    }
}
