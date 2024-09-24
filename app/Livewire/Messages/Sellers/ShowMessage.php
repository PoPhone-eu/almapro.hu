<?php

namespace App\Livewire\Messages\Sellers;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;

#[Layout('layouts.app')]
class ShowMessage extends Component
{
    public function render()
    {
        return view('livewire.messages.sellers.show-message');
    }
}
