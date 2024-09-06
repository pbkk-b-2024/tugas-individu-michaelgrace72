<?php

namespace App\Livewire;
use App\Models\Cast;
use Livewire\Component;

class CastIndex extends Component
{
    public $search='';
    public function index()
    {
        $casts= Cast::when($this->search, function($query){
            $query->where('title','like','%'.$this->search.'%');})->paginate(5);
        return view('cast-index', compact('casts'));
    }
}
