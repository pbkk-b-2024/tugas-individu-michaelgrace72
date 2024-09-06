<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Producer;
class ProducerIndex extends Component
{
    public $search='';
    public function render()
    {
        $producers=Producer::When($this->search, function($query){
            $query->where('title','like','%'.$this->search.'%');})->paginate(5);
        return view('livewire.producer-index', compact('producers'));
    }
}
