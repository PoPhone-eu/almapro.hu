<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

class UsersTable extends Component
{
    #[Layout('layouts.adminapp')]
    public function render()
    {
        return view('livewire.admin.users.users-table');
    }
}