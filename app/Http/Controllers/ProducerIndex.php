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

    // API Request
    public function showall(){
        $producers = Producer::all();
        return response()->json($producers);
    }
    public function show($id){
        $producer = Producer::find($id);
        return response()->json($producer);
    }
    public function storeapi(Request $request){
        $user = auth()->user();
        if(!$user->hasRole('admin')){
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $input = $request->input('TMDBID');
        $existingProducer = Producer::where('tmdb_id', $input)->first();
        if ($existingProducer) {
            return response()->json(['message' => 'Producer already exists.'], 400);
        }
        $api_key = env('TMDB_API_KEY');
        try {
            $response = Http::get('https://api.themoviedb.org/3/person/'.$input.'?api_key='.$api_key);
            $newProducer = $response->json();
            Producer::create([
                'tmdb_id' => $newProducer['id'],
                'name' => $newProducer['name'],
                'slug' => Str::slug($newProducer['name']),
                'role' => $newProducer['known_for_department'],
                'poster_path' => $newProducer['profile_path'],
            ]);
            return response()->json(['message' => 'Producer created successfully', $newProducer], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Producer not found'], 404);
        }
    }
    public function updateapi(Request $request, $id)
    {
        $user = auth()->user();
        if (!$user->hasRole('admin')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $input = $request->input('TMDBID');
        $api_key = env('TMDB_API_KEY');
        if ($existingProducer = Producer::where('tmdb_id', $input)->first()) {
            return response()->json(['message' => 'Producer already exists.'], 400);
        }
        try {
            $response = Http::get('https://api.themoviedb.org/3/person/'.$input.'?api_key='.$api_key);
            $newProducer = $response->json();
            $producer = Producer::findOrFail($id);
            $producer->update([
                'tmdb_id' => $newProducer['id'],
                'name' => $newProducer['name'],
                'slug' => Str::slug($newProducer['name']),
                'role' => $newProducer['known_for_department'],
                'poster_path' => $newProducer['profile_path'],
            ]);
            return response()->json(['message' => 'Producer updated successfully.', $newProducer], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Producer not found.'], 404);
        }
    }
    public function deleteapi($id){
        $user = auth()->user();
        if (!$user->hasRole('admin')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $producer = Producer::find($id);
        $producer->delete();
        return response()->json(['message' => 'Producer deleted successfully.'], 200);
    }
}
