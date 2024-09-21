<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Str;
use Http;

class GenreIndex extends Controller
{
    //
    public $search='';
    public $TMDBID ='';

    public function create()
    {
        return view('genre-create');
    }
    public function store(Request $request)
    {
        $input = $request->input('TMDBID');
        $api_key = env('TMDB_API_KEY');
        try {
            $response = Http::get('https://api.themoviedb.org/3/genre/'.$input.'?api_key='.$api_key);
            $genreexists = Genre::where('tmdb_id', $input)->first();
            if ($genreexists) {
                return redirect()->route('admin.genres.index')
                    ->with('error', 'Genre already exists.');
            }
            $newGenre = $response->json();
            Genre::create([
                'tmdb_id' => $newGenre['id'],
                'name' => $newGenre['name'],
                'slug' => Str::slug($newGenre['name']),
            ]);
            return redirect()->route('admin.genres.index')
                ->with('success', 'Genre created successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('admin.genres.index')
                ->with('error', 'Genre not found.');
        }

    }
    public function edit($id)
    {
        $genre = Genre::find($id);
        return view('genre-edit', compact('genre'));
    }
    public function update(Request $request, $id)
    {
        $genre = Genre::find($id);
        $genre->update([
            'name' => $request->name,
            'slug' => Str::slug($request['name']),
        ]);

        return redirect()->route('admin.genres.index')
            ->with('success', 'Genre updated successfully.');
    }
    public function destroy($id)
    {
        $genre = Genre::find($id);
        $genre->delete();

        return redirect()->route('admin.genres.index')
            ->with('success', 'Genre deleted successfully.');
    }
    public function index(Request $request)
    {
        $search = $request->input('search');
        $genres = Genre::when($search, function ($query, $search) {
            return $query->whereRaw('LOWER(name) LIKE ?',[ '%' . strtolower($search) . '%'] );
        })->orderBy('tmdb_id')->paginate(5);

        // Send data to the view
        return view('genre-index', compact('genres'));

    }
}

