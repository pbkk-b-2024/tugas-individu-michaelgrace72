<?php

namespace App\Http\Controllers;

use App\Models\Producer;
use Illuminate\Http\Request;
use illuminate\Support\Str;

class ProducerIndex extends Controller
{
    public $search='';

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
        Producer::create([
        'name' => $request->input('name'),
        'tmdb_id' => $request->input('tmdb_id'),
        'poster_path' => $request->input('poster_path'),
        'slug' => Str::slug($request->input('name')), // Generate slug dynamically
        'role' => $request->input('role'),
    ]);
        return redirect()->route('admin.producers.index')->with('success', 'Producer created successfully');
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
