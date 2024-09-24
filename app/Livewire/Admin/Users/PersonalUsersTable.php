<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;
use App\Models\User;

class PersonalUsersTable extends Component
{
    use WithPagination;

    public $perPage = 15;
    public $search = '';

    #[Layout('layouts.adminapp')]
    public function render()
    {
        return view(
            'livewire.admin.users.personal-users-table',
            [
                'users' => User::query()
                    ->when($this->search != null, function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('given_name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                    })
                    ->where('role', 'person')->paginate($this->perPage),
            ]
        );
    }
}
