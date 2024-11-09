<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class Calendar extends Component
{     public $events = [];

    public function render()
    {
        return view('livewire.calendar');
    }
}
