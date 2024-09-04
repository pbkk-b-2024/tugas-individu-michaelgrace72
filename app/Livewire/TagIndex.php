<?php

namespace App\Livewire;

use Livewire\Component;

class TagIndex extends Component
{
    public $showTagModal = false;
    public function showCreateModal(){
        $this -> showTagModal = true;
    }
    public function render()
    {
        return view('livewire.tag-index');
    }
}
