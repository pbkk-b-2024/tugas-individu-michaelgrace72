<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Episode;
class EpisodeIndex extends Component
{
    public $search='';
    public function render()
    {
        $episodes= episode::when($this->search, function($query){
            $query->where('title','like','%'.$this->search.'%');})->paginate(5);
        return view('livewire.episode-index', compact('episodes'));
    }
}
