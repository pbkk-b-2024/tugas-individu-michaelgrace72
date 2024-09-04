<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Movie;
use Livewire\WithPagination;

class MovieIndex extends Component
{
    public $search='';
    public function render()
    {
        $movies = Movie::where('title','like','%'.$this->search.'%')->paginate(5);
        return view('livewire.movie-index', compact('movies'));
    }
}
