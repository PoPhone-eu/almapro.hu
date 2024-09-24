<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Hash;

class PrivateUsersTable extends Component
{
    use WithPagination;
    public $perPage = 30;
    public $search = '';
    public $error_msg = [];

    #[Rule('required', message: 'Családnév megadása kötelező')]
    public $newname = null;

    #[Rule('required', message: 'Keresztnév megadása kötelező')]
    public $given_newname = null;

    #[Rule('required', message: 'Jelszó megadása kötelező')]
    public $password = null;

    #[Rule('required', message: 'Emailcím megadása kötelező')]
    #[Rule('unique:users,email', message: 'A megadott emailcím már létezik')]
    public $newemail = null;

    public $privateuser_id    = null;
    public $privateuser       = null;

    public $old_name = null;

    public $old_given_name = null;

    public $old_email = null;
    public $modal_title = null;


    #[On('submit')]
    public function submit()
    {
        if ($this->privateuser == null) {
            $this->validateNewprivateuser();
            $this->createprivateuser();
        } else {
            $this->validateUpdateprivateuser();
            $this->updateprivateuser();
        }

        $this->cancelSubmit();
    }

    private function createprivateuser()
    {
        $privateuser = new User();
        $privateuser->name = $this->newname;
        $privateuser->given_name = $this->given_newname;
        $privateuser->full_name = $this->newname . ' ' . $this->given_newname;
        $privateuser->email = $this->newemail;
        $privateuser->role = 'private';
        $privateuser->password = Hash::make($this->password);
        $privateuser->save();
    }

    public function validateNewprivateuser()
    {
        $this->validate([
            'newname'       => 'required',
            'given_newname' => 'required',
            'password'      => 'required',
            'newemail'      => 'required|email|unique:users,email'
        ]);
    }

    public function validateUpdateprivateuser()
    {
        $this->validate([
            'newname'       => 'required',
            'given_newname' => 'required',
            'newemail'      => 'required|email|unique:users,email,' . $this->privateuser->id,
        ]);
    }

    public function updateprivateuser()
    {
        $this->privateuser->name = $this->newname;
        $this->privateuser->given_name = $this->given_newname;
        $this->privateuser->full_name = $this->newname . ' ' . $this->given_newname;
        $this->privateuser->email = $this->newemail;
        $this->privateuser->update();
    }

    public function validateUpdate()
    {
        if ($this->old_name == null || $this->old_given_name == null || $this->old_email == null) {
            return false;
        }
        return true;
    }

    #[On('cancelSubmit')]
    public function cancelSubmit()
    {
        $this->newname          = null;
        $this->given_newname    = null;
        $this->newemail         = null;
        $this->privateuser_id   = null;
        $this->privateuser      = null;
        $this->password         = null;
        $this->old_name         = null;
        $this->old_given_name   = null;
        $this->old_email        = null;
        $this->modal_title      = null;
        $this->dispatch('close-modal');
    }

    #[On('open-admin-modal-this')]
    public function openModal()
    {
        $this->newname          = null;
        $this->given_newname    = null;
        $this->newemail         = null;
        $this->privateuser_id         = null;
        $this->privateuser            = null;
        $this->password         = null;
        $this->old_name         = null;
        $this->old_given_name   = null;
        $this->old_email        = null;
        $this->modal_title      = 'Új magánszemélyes eladó felvitele';
        $this->dispatch('open-admin-modal');
    }

    #[On('open-admin-modal-edit')]
    public function selectedprivateuser($privateuser_id)
    {
        $this->privateuser_id       = $privateuser_id;
        $this->privateuser          = User::find($privateuser_id);
        $this->newname              = $this->privateuser->name;
        $this->given_newname        = $this->privateuser->given_name;
        $this->newemail             = $this->privateuser->email;
        $this->modal_title          = 'Magánszemélyes eladó módosítása';
        $this->dispatch('open-admin-modal');
    }

    public function deleteuser($privateuser_id)
    {
        $this->privateuser = User::find($privateuser_id);
        $this->privateuser->delete();
    }

    #[Layout('layouts.adminapp')]
    public function render()
    {
        return view(
            'livewire.admin.users.private-users-table',
            [
                'users' => User::search($this->search)->where('role', 'private')->orderBy('name')->paginate($this->perPage)
            ]
        );
    }
}
