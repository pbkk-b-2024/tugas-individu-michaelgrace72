<?php

namespace App\Http\Controllers;

use App\Models\Season;
use App\Models\Series;
use Illuminate\Http\Request;
use http;
use Str;
class SeasonIndex extends Controller
{
    public $search='';
    public $TMDBID='';  

    public function create($seriesID)
    {
        return view('season-create', compact('seriesID') );
    }
    public function store(Request $request, $seriesID){
        $seasonID = $request->input('TMDBID');
        try {
            $response = Http::get('https://api.themoviedb.org/3/tv/'.$seriesID.'/season/'.$seasonID.'?api_key=902916f571ab9c1ffc7e94a6cced1cc1');
            $seasonexists = Season::where('tmdb_id', $seasonID)->first();
            if ($seasonexists) {
                return redirect()->route('admin.seasons.index')
                    ->with('error', 'Season already exists.');
            }
            $newSeason = $response->json();
            Season::create([
                'tmdb_id' => $newSeason['id'],
                'title' => $newSeason['name'],
                'slug' => Str::slug($newSeason['name']),
                'created_year' => $newSeason['first_air_date'],
                'poster_path' => $newSeason['poster_path'],
                'series_id' => $this->serie->id,
            ]);
            return redirect()->route('admin.seasons.index')
                ->with('success', 'Season created successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('admin.seasons.index')
                ->with('error', 'Season not found.');
        } 
    }
    public function edit($serie, $season)
    {
        $season = Season::find($season);
        return view('season-edit', compact('season'));
    }
    public function update(Request $request, $serie, $season)
    {
        $season = Season::find($season);
        $season->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'poster_path' => $request->poster_path,
        ]);
        return redirect()->route('admin.seasons.index')
            ->with('success', 'Season updated successfully.');
    }
    public function destroy($serie, $season)
    {
        $season = Season::find($season);
        $season->delete();
        return redirect()->route('admin.seasons.index')
            ->with('success', 'Season deleted successfully.');
    }
    public function index(Request $request, $seriesID)
    {
        $series = Series::find($seriesID);
        $search = $request->input('search');
        $seasons = Season::where('series_id', $series->id)->when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->paginate(5);
        // Send data to the view
        return view('season-index', compact('seasons', 'series'));

    }
}
