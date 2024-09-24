<?php

namespace App\Livewire\Admin\Users;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Banner;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use App\Models\BannerPosition;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use App\Services\BannerRotationService;

class AdminUsersTable extends Component
{
    use WithPagination;

    public $perPage = 15;
    public $search = '';

    #[Rule('required', message: 'Családnév megadása kötelező')]
    public $newname = null;

    #[Rule('required', message: 'Keresztnév megadása kötelező')]
    public $given_newname = null;

    #[Rule('required', message: 'Jelszó megadása kötelező')]
    public $password = null;

    #[Rule('required', message: 'Emailcím megadása kötelező')]
    #[Rule('unique:users,email', message: 'A megadott emailcím már létezik')]
    public $newemail = null;

    public $admin_id    = null;
    public $admin       = null;

    public $old_name = null;

    public $old_given_name = null;

    public $old_email = null;
    public $modal_title = null;

    #[On('submit')]
    public function submit()
    {
        if ($this->admin == null) {
            $this->validatenewAdmin();
            $this->createAdmin();
        } else {
            $this->validateupdateAdmin();
            $this->updateadmin();
        }

        $this->cancelSubmit();
    }

    private function createAdmin()
    {
        $admin = new User();
        $admin->name = $this->newname;
        $admin->given_name = $this->given_newname;
        $admin->full_name = $this->newname . ' ' . $this->given_newname;
        $admin->email = $this->newemail;
        $admin->role = 'admin';
        $admin->password = Hash::make($this->password);
        $admin->save();
    }

    public function validatenewAdmin()
    {
        $this->validate([
            'newname'       => 'required',
            'given_newname' => 'required',
            'password'      => 'required',
            'newemail'      => 'required|email|unique:users,email'
        ]);
    }

    public function validateupdateAdmin()
    {
        $this->validate([
            'newname'       => 'required',
            'given_newname' => 'required',
            'newemail'      => 'required|email|unique:users,email,' . $this->admin->id,
        ]);
    }

    public function updateadmin()
    {
        $this->admin->name = $this->newname;
        $this->admin->given_name = $this->given_newname;
        $this->admin->full_name = $this->newname . ' ' . $this->given_newname;
        $this->admin->email = $this->newemail;
        $this->admin->update();
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
        $this->admin_id         = null;
        $this->admin            = null;
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
        $this->admin_id         = null;
        $this->admin            = null;
        $this->password         = null;
        $this->old_name         = null;
        $this->old_given_name   = null;
        $this->old_email        = null;
        $this->modal_title      = 'Új adminisztrátor felvétele';
        $this->dispatch('open-admin-modal');
    }

    #[On('open-admin-modal-edit')]
    public function selectedAdmin($admin_id)
    {
        $this->admin_id             = $admin_id;
        $this->admin                = User::find($admin_id);
        $this->newname             = $this->admin->name;
        $this->given_newname       = $this->admin->given_name;
        $this->newemail            = $this->admin->email;
        $this->modal_title      = 'Adminisztrátor módosítása';
        $this->dispatch('open-admin-modal');
    }

    public function deleteUser($user_id)
    {
        $user = User::find($user_id);
        $user->delete();
        session()->flash('success', 'A felhasználó sikeresen törölve lett.');
    }

    #[Layout('layouts.adminapp')]
    public function render()
    {
        /*      for ($i = 0; $i < 30; $i++) {
            $banner = new Banner();
            $banner->invoice_id = rand(100000, 999999);
            $banner->from_date = Carbon::now();
            $banner->normal_image = 'tesztbanner.jpg';
            $banner->mobile_image = 'tesztbanner.jpg';
            $banner->is_active = true;
            $banner->user_id = 3;
            $banner->save();
            $bannerposition = new BannerPosition();
            $bannerposition->banner_id = $banner->id;
            $bannerposition->position_name = 'home';
            $bannerposition->this_position = 'top';
            $bannerposition->chance = rand(1, 100);
            $banner->positions()->save($bannerposition);
        } */

        /* $banners = BannerRotationService::getRandomBanners('home', 'top');
        dd($banners); */

        return view('livewire.admin.users.admin-users-table', [
            'users' => User::query()
                ->when($this->search != null, function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->where('role', 'admin')->paginate(10),
        ]);
    }
}
