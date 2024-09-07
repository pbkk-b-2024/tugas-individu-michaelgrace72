<?php

namespace App\Http\Controllers;

use App\Models\Producer;
use Illuminate\Http\Request;

class ProducerIndex extends Controller
{
    public $search='';

    public function index(Request $request)
    {
        $search = $request->input('search');
        $producers = Producer::when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })->paginate(5);

        // Send data to the view
        return view('producer-index', compact('producers'));
    }
}
