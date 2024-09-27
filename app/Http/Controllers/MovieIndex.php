<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Http;
use Str;
class MovieIndex extends Controller
{
    public $search='';
    public $TMDBID ='';
    public function index(Request $request)
    {
        $search = $request->input('search');
        $movies = Movie::when($search, function ($query, $search) {
            return $query->whereRaw('LOWER(title) LIKE ?',[ '%' . strtolower($search) . '%']);
        })->orderBy('id')->paginate(5);

        // Send data to the view
        return view('movie-index', compact('movies'));
    }
    public function create()
    {
        return view('movie-create');
    }
    public function store(Request $request)
    {
        $input = $request->input('TMDBID');
        $api_key = env('TMDB_API_KEY');
        try {
            $response = Http::get('https://api.themoviedb.org/3/movie/'.$input.'?api_key='.$api_key);
            $existingMovie = Movie::where('tmdb_id', $input)->first();
            if ($existingMovie) {
                return redirect()->route('admin.movies.index')
                    ->with('error', 'Movie already exists.');
            }
            $newMovie = $response->json();
            Movie::create([
                'tmdb_id' => $newMovie['id'],
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
            return redirect()->route('admin.movies.index')
                ->with('success', 'Movie created successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('admin.movies.index')
                ->with('error', 'Movie not found');
        }

    }
    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        return view('movie-edit', compact('movie'));
    }
    public function update(Request $request, $id)
    {

        $validated = $request->validate([
        'tmdb_id' => 'required|string',
        'title' => 'required|string|max:255',
        'release_date' => 'required|date',
        'runtime' => 'required|integer',
        'lang' => 'required|string', // Ensure it's a 3-character language code
        'video_format' => 'required|string', // Assuming video format length is within 10 characters
        'slug' => 'required|string|',
        'rating' => 'required|numeric|between:0,10',
        'poster_path' => 'required|string',
        'overview' => 'required|string', 
        ]);

        $movie= Movie::findOrFail($id);
        $movie->update($validated);
        return redirect()->route('admin.movies.index');
    }
    public function delete($id)
    {
        $movie = Movie::find($id);
        $movie->delete();
        return redirect()->route('admin.movies.index')->with('success', 'Movie deleted successfully');
    }

    // API Routes
    public function showall()
    {
        $movies = Movie::all();
        return response()->json($movies);
    }
    public function show($id)
    {
        $movie = Movie::find($id);
        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }
        return response()->json($movie);
    }
    public function storeapi(Request $request)
    {
        $user = auth()->user();
        if (!$user->hasRole('admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $input = $request->input('TMDBID');
        $api_key = env('TMDB_API_KEY');
        try {
            $response = Http::get('https://api.themoviedb.org/3/movie/'.$input.'?api_key='.$api_key);
            $existingMovie = Movie::where('tmdb_id', $input)->first();
            if ($existingMovie) {
                return response()->json(['message' => 'Movie already exists.'], 400);
            }
            $newMovie = $response->json();
            Movie::create([
                'tmdb_id' => $newMovie['id'],
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
            return response()->json(['message' => 'Movie created successfully', $newMovie], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Movie not found'], 404);
        }
    }
    public function updateapi(Request $request, $id)
    {
        $user = auth()->user();
        if (!$user->hasRole('admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $validated = $request->validate([
            'tmdb_id' => 'required|string',
            'title' => 'required|string|max:255',
            'release_date' => 'required|date',
            'runtime' => 'required|integer',
            'lang' => 'required|string', // Ensure it's a 3-character language code
            'video_format' => 'required|string', // Assuming video format length is within 10 characters
            'slug' => 'required|string|',
            'rating' => 'required|numeric|between:0,10',
            'poster_path' => 'required|string',
            'overview' => 'required|string', 
        ]);
        $movie= Movie::findOrFail($id);
        $movie->update($validated);
        return response()->json(['message' => 'Movie updated successfully', $movie], 200);
    }
    public function deleteapi($id)
    {
        $user = auth()->user();
        if (!$user->hasRole('admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $movie = Movie::find($id);
        $movie->delete();
        return response()->json(['message' => 'Movie deleted successfully', $movie], 200);
    }
}
