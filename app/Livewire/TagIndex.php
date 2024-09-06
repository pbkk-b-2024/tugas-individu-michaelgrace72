<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tag;

class TagIndex extends Component
{
    public $search='';
    
    public function render()
    {
        $tags= Tag::when($this->search, function($query){
            $query->where('title','like','%'.$this->search.'%');})->paginate(5);
        return view('livewire.tag-index');
    }
}
