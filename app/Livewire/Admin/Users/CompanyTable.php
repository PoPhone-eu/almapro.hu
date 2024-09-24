<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Hash;

class CompanyTable extends Component
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

    public $companyuser_id    = null;
    public $companyuser       = null;

    public $old_name = null;

    public $old_given_name = null;

    public $old_email = null;
    public $modal_title = null;


    #[On('submit')]
    public function submit()
    {
        if ($this->companyuser == null) {
            $this->validateNewCompanyuser();
            $this->createCompanyuser();
        } else {
            $this->validateUpdateCompanyuser();
            $this->updateCompanyuser();
        }

        $this->cancelSubmit();
    }

    private function createCompanyuser()
    {
        $companyuser = new User();
        $companyuser->name = $this->newname;
        $companyuser->given_name = $this->given_newname;
        $companyuser->full_name = $this->newname . ' ' . $this->given_newname;
        $companyuser->email = $this->newemail;
        $companyuser->role = 'company';
        $companyuser->password = Hash::make($this->password);
        $companyuser->save();
    }

    public function validateNewCompanyuser()
    {
        $this->validate([
            'newname'       => 'required',
            'given_newname' => 'required',
            'password'      => 'required',
            'newemail'      => 'required|email|unique:users,email'
        ]);
    }

    public function validateUpdateCompanyuser()
    {
        $this->validate([
            'newname'       => 'required',
            'given_newname' => 'required',
            'newemail'      => 'required|email|unique:users,email,' . $this->companyuser->id,
        ]);
    }

    public function updateCompanyuser()
    {
        $this->companyuser->name = $this->newname;
        $this->companyuser->given_name = $this->given_newname;
        $this->companyuser->full_name = $this->newname . ' ' . $this->given_newname;
        $this->companyuser->email = $this->newemail;
        $this->companyuser->update();
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
        $this->companyuser_id   = null;
        $this->companyuser      = null;
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
        $this->companyuser_id         = null;
        $this->companyuser            = null;
        $this->password         = null;
        $this->old_name         = null;
        $this->old_given_name   = null;
        $this->old_email        = null;
        $this->modal_title      = 'Új kereskedő felvétele';
        $this->dispatch('open-admin-modal');
    }

    #[On('open-admin-modal-edit')]
    public function selectedCompanyuser($companyuser_id)
    {
        $this->companyuser_id       = $companyuser_id;
        $this->companyuser          = User::find($companyuser_id);
        $this->newname              = $this->companyuser->name;
        $this->given_newname        = $this->companyuser->given_name;
        $this->newemail             = $this->companyuser->email;
        $this->modal_title          = 'Kereskedő módosítása';
        $this->dispatch('open-admin-modal');
    }

    public function deleteuser($companyuser_id)
    {
        $this->companyuser = User::find($companyuser_id);
        $this->companyuser->delete();
    }

    #[Layout('layouts.adminapp')]
    public function render()
    {
        return view('livewire.admin.users.company-table', [
            'users' => User::search($this->search)->where('role', 'company')->orderBy('name')->paginate($this->perPage)
        ]);
    }
}
