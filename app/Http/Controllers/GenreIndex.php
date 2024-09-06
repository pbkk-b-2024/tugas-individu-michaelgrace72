<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreIndex extends Controller
{
    //
    public $search='';

    public function index(Request $request)
    {
        $search = $request->input('search');
        $genres = Genre::when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })->paginate(5);

        // Send data to the view
        return view('genre-index', compact('genres'));

    }
}
