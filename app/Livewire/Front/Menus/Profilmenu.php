<?php

namespace App\Livewire\Front\Menus;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;

#[Layout('layouts.adminapp')]
class Profilmenu extends Component
{
    #[On('changeit')]
    public function render()
    {
        return view('livewire.front.menus.profilmenu');
    }
}
