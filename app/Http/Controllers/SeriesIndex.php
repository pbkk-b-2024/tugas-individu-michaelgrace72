<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;

class SeriesIndex extends Controller
{
    public $search='';

    public function index(Request $request)
    {
        $search = $request->input('search');
        $series = Series::when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })->paginate(5);

        // Send data to the view
        return view('series-index', compact('series'));

    }  
}
