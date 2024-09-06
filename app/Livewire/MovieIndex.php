<?php

namespace App\Livewire;



use Livewire\Component;
use App\Models\Movie;
use Livewire\WithPagination;
use Psy\CodeCleaner\FunctionContextPass;
use Request;

class MovieIndex extends Component
{
    use WithPagination;
    protected $paginationtheme = 'bootstrap';  
    
    public function render(Request $request)
    {
        $search = $request->input('search');
        $movies = Movie::when($search, function($query, $search){
            $query->where('title','like','%'.$this->search.'%');})->paginate(5);
        return view('livewire.movie-index', compact('movies'));
    }
    
}
