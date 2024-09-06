<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Season;

class SeasonIndex extends Component
{
    public $search='';
    public function render()
    {
        $seasons= Season::when($this->search, function($query){
            $query->where('title','like','%'.$this->search.'%');})->paginate(5);
        return view('livewire.season-index', compact('seasons'));
    }
}
