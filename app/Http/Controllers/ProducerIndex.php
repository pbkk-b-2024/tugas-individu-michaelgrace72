<?php

namespace App\Http\Controllers;

use App\Models\Producer;
use Illuminate\Http\Request;
use illuminate\Support\Str;
use Http;

class ProducerIndex extends Controller
{
    public $search='';
    public $TMDBID ='';

    public function index(Request $request)
    {
        $search = $request->input('search');
        $producers = Producer::when($search, function ($query, $search) {
            return $query->whereRaw('LOWER(name) LIKE ?',[ '%' . strtolower($search) . '%']);
        })->orderBy('id')->paginate(5);


        // Send data to the view
        return view('producer-index', compact('producers'));
    }
    public function create()
    {
        return view('producer-create');
    }
    public function store(Request $request){

        $api_key = env('TMDB_API_KEY');
        $input = $request->input('TMDBID');
        try {
            //code...
            $response = Http::get('https://api.themoviedb.org/3/person/'.$input.'?api_key='.$api_key);

            $existingCast = Producer::where('tmdb_id', $input)->first();
            if ($existingCast) {
                return redirect()->route('admin.producers.index')
                    ->with('error', 'Producer already exists.');
            }
            $newCast = $response->json();
            Producer::create([
                'tmdb_id' => $newCast['id'],
                'name' => $newCast['name'],
                'slug' => Str::slug($newCast['name']),
                'role' => $newCast['known_for_department'],
                'poster_path' => $newCast['profile_path'],
            ]);
            return redirect()->route('admin.producers.index')
                ->with('success', 'Producer created successfully.');

            } catch (\Throwable $th) {
                //throw $th;
                return redirect()->route('admin.producers.index')
                    ->with('error', 'Producer not found.');
            }
 
    }
    public function edit($id)
    {
        $producer = Producer::findOrFail($id);
        return view('producer-edit', compact('producer'));
    }
    public function update(Request $request, $id)
    {
        $producers = Producer::findOrFail($id);

        $producers->update([
        'name' => $request->input('name'),
        'tmdb_id' => $request->input('tmdb_id'),
        'poster_path' => $request->input('poster_path'),
        'slug' => Str::slug($request->input('name')), // Generate slug dynamically
        'role' => $request->input('role'),
        ]);
        return redirect()->route('admin.producers.index');
    }
    public function delete($id){
        Producer::destroy($id);
        return redirect()->route('admin.producers.index')->with('success', 'Producer deleted successfully');
    }
}
