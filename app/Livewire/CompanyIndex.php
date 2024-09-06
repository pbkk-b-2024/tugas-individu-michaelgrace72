<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Company;

class CompanyIndex extends Component
{
    public $search='';
    public function render()
    {
        $companies= Company::when($this->search, function($query){
            $query->where('title','like','%'.$this->search.'%');})->paginate(5);
        return view('livewire.company-index', compact('companies'));
    }
}
