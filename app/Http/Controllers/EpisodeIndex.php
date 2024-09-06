<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use Illuminate\Http\Request;

class EpisodeIndex extends Controller
{
    //
    public $search='';
    public function index(Request $request)
    {
       $search = $request->input('search');
        $episodes = Episode::when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })->paginate(5);

        // Send data to the view
        return view('episode-index', compact('episodes'));


    }
}
