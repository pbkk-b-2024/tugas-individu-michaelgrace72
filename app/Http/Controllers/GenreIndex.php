<?php

namespace App\Http\Controllers;


use App\Models\Genre;
use App\Models\User;
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
            $response = Http::get('https://api.themoviedb.org/3/genre/movie/'.$input.'?api_key='.$api_key);
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
    // API Request
    public function showall(){
        $genres = Genre::all();
        return response()->json($genres);
    }
    public function show($id){
        $genre = Genre::find($id);
        return response()->json($genre);
    }
    public function storeapi(Request $request){
        $user = auth()->user();
        if($user->role != 'admin'){
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $input = $request->input('TMDBID');
        $api_key = env('TMDB_API_KEY');
        if($existingGenre = Genre::where('tmdb_id', $input)->first()){
            return response()->json(['error' => 'Genre already exists.'], 400);
        }
        try {
            $response = Http::get('https://api.themoviedb.org/3/genre/'.$input.'?api_key='.$api_key);
            $newGenre = $response->json();
            Genre::create([
                'tmdb_id' => $newGenre['id'],
                'name' => $newGenre['name'],
                'slug' => Str::slug($newGenre['name']),
            ]);
            return response()->json(['message' => 'Genre created successfully.'], 201);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => 'Genre not found.'], 404);
        }
    }
    public function updateapi(Request $request, $id){
        $user = auth()->user();
        if($user->role != 'admin'){
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $genre = Genre::find($id);
        $input = $request->input('TMDBID');
        $api_key = env('TMDB_API_KEY');
        try {
            $response = Http::get('https://api.themoviedb.org/3/genre/'.$input.'?api_key='.$api_key);
            $newGenre = $response->json();
            $genre->update([
                'tmdb_id' => $newGenre['id'],
                'name' => $newGenre['name'],
                'slug' => Str::slug($newGenre['name']),
            ]);
            return response()->json(['message' => 'Genre updated successfully.'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => 'Genre not found.'], 404);
        }
    }
    public function deleteapi($id){
        $user = auth()->user();
        if($user->role != 'admin'){
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $genre = Genre::find($id);
        $genre->delete();
        return response()->json(['message' => 'Genre deleted successfully.'], 200);
    }
}

