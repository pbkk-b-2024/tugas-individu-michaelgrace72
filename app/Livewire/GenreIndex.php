<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Genre;

class GenreIndex extends Component
{
    public $search='';
    public function render()
    {
        $genres= genre::when($this->search, function($query){
            $query->where('title','like','%'.$this->search.'%');})->paginate(5);
        return view('livewire.genre-index', compact('genres'));
    }
}
