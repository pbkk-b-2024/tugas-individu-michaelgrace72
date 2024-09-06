<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagIndex extends Controller
{
    public $search='';

    public function index(Request $request)
    {
        $search = $request->input('search');
        $tags = Tag::when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })->paginate(5);

        // Send data to the view
        return view('tag-index', compact('tags'));

    }
}
