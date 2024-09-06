<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Series;

class SeriesIndex extends Component
{
    public $search='';
    public function render()
    {
        $series= Series::when($this->search, function($query){
            $query->where('title','like','%'.$this->search.'%');})->paginate(5);   
        return view('livewire.series-index', compact('series'));
    }
}
