<?php

namespace App\Livewire\Modals;

use LivewireUI\Modal\ModalComponent;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Hash;

class CreateAdminModal extends ModalComponent
{
    #[Rule('required', message: 'Családnév megadása kötelező')]
    public $newname = null;

    #[Rule('required', message: 'Keresztnév megadása kötelező')]
    public $given_newname = null;

    #[Rule('required', message: 'Jelszó megadása kötelező')]
    public $password = null;

    #[Rule('required', message: 'Emailcím megadása kötelező')]
    #[Rule('unique:users,email', message: 'A megadott emailcím már létezik')]
    public $newemail = null;

    #[On('cancelSubmit')]
    public function cancelSubmit()
    {
        $this->newname          = null;
        $this->given_newname    = null;
        $this->newemail         = null;
        $this->password         = null;
    }

    public function render()
    {
        return view('livewire.modals.create-admin-modal');
    }
}
