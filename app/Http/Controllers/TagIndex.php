<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Str;

class TagIndex extends Controller
{
    public $search='';

    public function create()
    {
        return view('tag-create');
    }
    public function store(Request $request)
    {

        Tag::create([
            'tag_name' => $request->tag_name,
            'slug' => Str::slug($request->tag_name),
        ]);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag created successfully.');
    }
    public function edit($id)
    {
        $tag = Tag::find($id);
        return view('tag-edit', compact('tag'));
    }
    public function update(Request $request, $id)
    {
        $tag = Tag::find($id);
        $tag->update([
            'tag_name' => $request->tag_name,
            'slug' => Str::slug($request->tag_name),
        ]);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag updated successfully.');
    }
    public function delete($id)
    {
        $tag = Tag::find($id);
        $tag->delete();

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag deleted successfully.');
    }
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tags = Tag::when($search, function ($query, $search) {
            return $query->whereRaw('LOWER(tag_name) LIKE ?',[ '%' . strtolower($search) . '%'] );
        })->orderBy('id')->paginate(5);

        // Send data to the view
        return view('tag-index', compact('tags'));

    }
}
