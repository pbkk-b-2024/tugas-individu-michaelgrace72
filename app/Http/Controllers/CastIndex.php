<?php

namespace App\Http\Controllers;

use App\Models\Cast;
use App\Models\User;
use Http;
use Illuminate\Http\Request;
use illuminate\support\Str;
use Livewire\Attributes;

class CastIndex extends Controller
{
    //
    public $search='';
    public $TMDBID ='';

    public function create(){
        return view('cast-create');
    }
    public function generateCast(Request $request){
        $input = $request->input('TMDBID');
        $api_key = env('TMDB_API_KEY');
        try {
            //code...
            $response = Http::get('https://api.themoviedb.org/3/person/'.$input.'?api_key='.$api_key);

            $existingCast = Cast::where('tmdb_id', $input)->first();
            if ($existingCast) {
                return redirect()->route('admin.casts.index')
                    ->with('error', 'Cast already exists.');
            }
            $newCast = $response->json();
            Cast::create([
                'tmdb_id' => $newCast['id'],
                'name' => $newCast['name'],
                'slug' => Str::slug($newCast['name']),
                'birthday' => $newCast['birthday'],
                'poster_path' => $newCast['profile_path'],
            ]);
            return redirect()->route('admin.casts.index')
                ->with('success', 'Cast created successfully.');

            } catch (\Throwable $th) {
                //throw $th;
                return redirect()->route('admin.casts.index')
                    ->with('error', 'Cast not found.');
            }
    }
    public function edit($id){
        $cast = Cast::find($id);
        return view('cast-edit', compact('cast'));
    }
    public function update(Request $request, $id){
        $cast = Cast::find($id);
        $cast->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'poster_path' => $request->poster_path,
        ]);

        return redirect()->route('admin.casts.index')
            ->with('success', 'Cast updated successfully.');
    }
    public function destroy($id){
        $cast = Cast::find($id);
        $cast->delete();

        return redirect()->route('admin.casts.index')
            ->with('success', 'Cast deleted successfully.');
    }
    
    public function index(Request $request)
    {
        $search = $request->input('search');
        $casts = Cast::when($search, function ($query, $search) {
            return $query->whereRaw('LOWER(name) LIKE ?', [ strtolower("%{$search}%")]);
        })->orderBy('id')->paginate(5);

        // Send data to the view
        return view('cast-index', compact('casts'));

    }
    // APi request
    public function showall(){
        $casts = Cast::all();
        return response()->json($casts);
    }
    public function show($id){
        $cast = Cast::find($id);
        return response()->json($cast);
    }
    public function storeapi(Request $request)
    {
        $user = auth()->user();
        if ($user->role != 'admin') {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $input = $request->input('TMDBID');
        $api_key = env('TMDB_API_KEY');
        if ($existingCast = Cast::where('tmdb_id', $input)->first()) {
            return response()->json(['message' => 'Cast already exists.'], 400);
        }
        try {
            $response = Http::get('https://api.themoviedb.org/3/person/'.$input.'?api_key='.$api_key);
            $newCast = $response->json();
            Cast::create([
                'tmdb_id' => $newCast['id'],
                'name' => $newCast['name'],
                'slug' => Str::slug($newCast['name']),
                'birthday' => $newCast['birthday'],
                'poster_path' => $newCast['profile_path'],
            ]);
            return response()->json(['message' => 'Cast created successfully.', $newCast], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Cast not found.'], 404);
        }
    }
    public function updateapi(Request $request, $id)
    {
        $user = auth()->user();
        if ($user->role != 'admin') {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $input = $request->input('TMDBID');
        $api_key = env('TMDB_API_KEY');
        if ($existingCast = Cast::where('tmdb_id', $input)->first()) {
            return response()->json(['message' => 'Cast already exists.'], 400);
        }
        try {
            $response = Http::get('https://api.themoviedb.org/3/person/'.$input.'?api_key='.$api_key);
            $newCast = $response->json();
            $cast = Cast::findOrFail($id);
            $cast->update([
                'tmdb_id' => $newCast['id'],
                'name' => $newCast['name'],
                'slug' => Str::slug($newCast['name']),
                'birthday' => $newCast['birthday'],
                'poster_path' => $newCast['profile_path'],
            ]);
            return response()->json(['message' => 'Cast updated successfully.' ], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Cast not found.'], 404);
        }
    }
    public function deleteapi($id)
    {
        $user = auth()->user();
        if ($user->role != 'admin') {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $cast = Cast::find($id);
        $cast->delete();
        return response()->json(['message' => 'Cast deleted successfully.', $cast], 200);
    }

}