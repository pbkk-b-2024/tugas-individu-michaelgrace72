<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;

class SeasonIndex extends Controller
{
    public $search='';

    public function index(Request $request)
    {
        $search = $request->input('search');
        $seasons = Season::when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })->paginate(5);

        // Send data to the view
        return view('season-index', compact('seasons'));

    }
}
