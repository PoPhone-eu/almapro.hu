<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;

class UserDataForm extends Form
{
    use WithFileUploads;
    #[Rule('required')]
    public $name;
    #[Rule('required')]
    public $given_name;
    #[Rule('required')]
    public $email;
    #[Rule('nullable')]
    public $phone;
    #[Rule('nullable')]
    public $newpassword;
    public ?User $user;

    public function setUser(User $user)
    {
        $this->user = $user;
        $this->name = $this->user->name;
        $this->given_name = $this->user->given_name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->newpassword = null;
    }

    public function update()
    {
        $this->user->update([
            'name' => $this->name,
            'given_name' => $this->given_name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);



        if ($this->newpassword) {
            $this->user->update([
                'password' => bcrypt($this->newpassword),
            ]);
        }
        $this->setUser($this->user);
    }
}
