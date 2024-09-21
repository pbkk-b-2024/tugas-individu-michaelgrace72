<?php

namespace App\Http\Controllers;

use App\Models\Cast;
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
}

