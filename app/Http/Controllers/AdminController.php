<?php

namespace App\Http\Controllers;

use App\Models\Cast;
use App\Models\Movie;
use App\Models\Series;
use Illuminate\Http\Request;
use App\Models\User;
class AdminController extends Controller
{
    //
    public function index()
    {
        $users = User::all();
        $movies = Movie::all();
        $series = Series::all();
        $casts = Cast::all();
        return view('admin.index', compact('users', 'movies', 'series', 'casts'));
    }
}
