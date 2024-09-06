<?php

namespace App\Http\Controllers;

use App\Models\Cast;
use Illuminate\Http\Request;

class CastIndex extends Controller
{
    //
    public $search='';
    public function index(Request $request)
    {
        $search = $request->input('search');
        $casts = Cast::when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })->paginate(5);

        // Send data to the view
        return view('cast-index', compact('casts'));

    }
}

