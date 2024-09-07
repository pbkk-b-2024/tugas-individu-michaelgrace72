<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Livewire\WithPagination;
class MovieIndex extends Controller
{
    public $search='';
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

        Movie::create($validated);
        return redirect()->route('admin.movies.index')->with('success', 'Movie created successfully');
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
}
