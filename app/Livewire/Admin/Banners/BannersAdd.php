<?php

namespace App\Livewire\Admin\Banners;

use App\Models\User;
use App\Models\Banner;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use App\Livewire\Admin\Banners\BannersTable;

#[Layout('layouts.adminapp')]
class BannersAdd extends Component
{
    use WithFileUploads;

    public $user_id         = null;
    public $user            = null;
    public $error_msg       = null;

    #[Validate('nullable')]
    public $invoice_number  = null;
    #[Validate('nullable')]
    public $payment_date;
    #[Validate('nullable')]
    public $link;

    public $from_date       = null;
    public $to_date         = null;

    #[Validate('required|boolean')]
    public $is_active       = true;
    public $chance          = 0;
    #[Validate('nullable')]
    public $amount_payed = null;
    public $positions       = [];
    public $selected_positions;
    public $search_user;
    public $users;
    public $selected_user;
    public $selectedPositions;

    // banner images - 	normal_image and mobile_image
    #[Validate('nullable')]
    public $normal_image    = null;
    #[Validate('nullable')]
    public $mobile_image    = null;

    public function mount()
    {
        $this->positions = Banner::POSITIONS;
        $this->selectedPositions = $this->positions;
        foreach ($this->selectedPositions as $key => $value) {
            //dd($key);
            foreach ($value['positions'] as $key_p => $value_p) {
                // dd($key_p);
            }
        }
    }

    public function selectUser($id)
    {
        $this->selected_user = User::find($id);
        if ($this->selected_user != null) {
            $this->users = null;
            $this->search_user = null;
        }
    }

    public function clearSelectedUser()
    {
        $this->selected_user = null;
        $this->users = null;
        $this->search_user = null;
    }

    public function updatedSearchUser()
    {
        if (strlen($this->search_user) < 2) {
            $this->users = null;
            return;
        }
        $this->users = User::query()
            ->where('role', 'company')
            ->where('full_name', 'like', '%' . $this->search_user . '%')
            ->orWhere('email', 'like', '%' . $this->search_user . '%')
            ->limit(8)->get();
    }

    public function checkIfSubmitable()
    {

        // if selected_user == null return false
        // if mobile_image == null and normal_image == null return false as one image upload is necessary
        // if all positions are false return false

        if ($this->selected_user == null) {
            return false;
        }
        if ($this->mobile_image == null && $this->normal_image == null) {
            return false;
        }
        return true;
        // now check if all positions are false
        $selectedPositions = $this->selectedPositions;
        foreach ($selectedPositions as $key => $value) {
            foreach ($value['positions'] as $key_p => $value_p) {
                if ($value_p['value'] == true && $value['change'] != null) {
                    return true;
                }
            }
        }
        return false;
    }

    public function save()
    {
        // check if both images are null
        if ($this->mobile_image == null && $this->normal_image == null) {
            $this->error_msg = 'Legalább egy kép feltöltése kötelező!';
            return;
        }
        // check if $this->selectedPositions is all false and values are null where it is true.
        // if so return with error message
        $selectedPositions = $this->selectedPositions;
        $check = [];
        foreach ($selectedPositions as $key => $value) {
            if ((int)$value['chance'] != 0) {
                foreach ($value['positions'] as $key_p => $value_p) {
                    if ($value_p['value'] == true) {
                        $check[] = false;
                    } else {
                        $check[] = true;
                    }
                }
            }
        }
        // if $check only true values return with error message
        if (!in_array(false, $check)) {
            $this->error_msg = 'Legalább egy pozíció kiválasztása kötelező és az esély nem lehet nulla!';
            return;
        }

        // we create a new banner:
        $normal_image = null;
        $mobile_image = null;
        if ($this->normal_image != null) {
            $this->normal_image->store('public');
            $normal_image = $this->normal_image->hashName();
        }
        if ($this->mobile_image != null) {
            $this->mobile_image->store('public');
            $mobile_image = $this->mobile_image->hashName();
        }
        $banner = Banner::create([
            'user_id'           => $this->selected_user->id,
            'invoice_number'    => $this->invoice_number,
            'link'              => $this->link,
            'payment_date'      => $this->payment_date,
            'normal_image'      => $normal_image,
            'mobile_image'      => $mobile_image,
            'is_active'         => $this->is_active,
            'chance'            => null,
            'amount_payed'      => $this->amount_payed,
            'data'              => $selectedPositions,
        ]);
        // we store the positions in banner_positions table:

        foreach ($selectedPositions as $key => $value) {
            foreach ($value['positions'] as $key_p => $value_p) {
                if ($value_p['value'] == true && (int)$value['chance'] != 0) {
                    $position_name = $key_p;
                    $chance = (int)$value['chance'];
                    $this_position = $key;
                    $order = null;
                    $banner_id = $banner->id;
                    $banner->positions()->create([
                        'position_name' => $position_name,
                        'chance' => $chance,
                        'this_position' => $this_position,
                        'order' => $order,
                        'banner_id' => $banner_id,
                    ]);
                }
            }
        }

        // return back to banners page
        $this->redirect(BannersTable::class, navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.banners.banners-add', [
            'submitable' => $this->checkIfSubmitable(),
        ]);
    }
}
