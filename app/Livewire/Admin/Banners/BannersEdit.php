<?php

namespace App\Livewire\Admin\Banners;

use App\Models\User;
use App\Models\Banner;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use App\Models\BannerPosition;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.adminapp')]
class BannersEdit extends Component
{
    use WithFileUploads;
    public $banner_id;
    public $banner;
    public $positions;
    public $selectedPositions;
    public $bannerPositions;
    public $selected_user;
    public $error_msg;
    #[Validate('nullable')]
    public $is_active;
    #[Validate('nullable')]
    public $invoice_number;
    #[Validate('nullable')]
    public $payment_date;
    #[Validate('nullable')]
    public $amount_payed;

    #[Validate('nullable')]
    public $normal_image;
    #[Validate('nullable')]
    public $mobile_image;
    #[Validate('nullable')]
    public $link;


    public function mount($banner_id)
    {
        $this->banner_id = $banner_id;
        $this->banner = Banner::find($banner_id);
        $this->selected_user = User::find($this->banner->user_id);
        $this->positions = Banner::POSITIONS;
        $this->selectedPositions = $this->banner->data;
        $this->is_active = $this->banner->is_active;
        $this->invoice_number = $this->banner->invoice_number;
        $this->payment_date = $this->banner->payment_date;
        $this->amount_payed = $this->banner->amount_payed;
        $this->link = $this->banner->link;
    }

    public function deleteNormalImage()
    {
        Storage::disk('public')->delete($this->banner->normal_image);
        $this->banner->normal_image = null;
        $this->banner->save();
    }

    public function deleteMobileImage()
    {
        Storage::disk('public')->delete($this->banner->mobile_image);
        $this->banner->mobile_image = null;
        $this->banner->save();
    }

    public function save()
    {
        // check if both images are null
        /* if ($this->banner->normal_image == null && $this->banner->mobile_image == null) {
            if ($this->mobile_image == null && $this->normal_image == null) {
                $this->error_msg = 'Legalább egy kép feltöltése kötelező!';
                return;
            }
        } */

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

        // we check if new images were added...
        $normal_image = null;
        $mobile_image = null;
        if ($this->normal_image != null && $this->banner->normal_image != $this->normal_image) {
            // we delete the old image if exists:
            if ($this->banner->normal_image != null) {
                Storage::disk('public')->delete($this->banner->normal_image);
            }
            $this->normal_image->store('public');
            $normal_image = $this->normal_image->hashName();
            $this->banner->normal_image = $normal_image;
            $this->banner->save();
        }
        if (
            $this->mobile_image != null && $this->banner->mobile_image != $this->mobile_image
        ) {
            // we delete the old image if exists:
            if ($this->banner->mobile_image != null) {
                Storage::disk('public')->delete($this->banner->mobile_image);
            }
            $this->mobile_image->store('public');
            $mobile_image = $this->mobile_image->hashName();
            $this->banner->mobile_image = $mobile_image;
            $this->banner->save();
        }
        // we update the banner data rows:
        $this->banner->invoice_number = $this->invoice_number;
        $this->banner->payment_date = $this->payment_date;
        $this->banner->is_active = $this->is_active;
        $this->banner->amount_payed = $this->amount_payed;
        $this->banner->link = $this->link;
        $this->banner->save();

        // we update the positions in banner_positions table:

        foreach ($selectedPositions as $key => $value) {
            foreach ($value['positions'] as $key_p => $value_p) {
                // $value_p['value'] == false then we check if it is already save and if yes we delete that row:
                if ($value_p['value'] == false) {
                    $position_name = $key_p;
                    $banner_id = $this->banner->id;
                    $this_position = $key;
                    $this->banner->positions()->where('position_name', $position_name)->where('this_position', $this_position)->where('banner_id', $banner_id)->delete();
                }
                if ($value_p['value'] == true) {
                    $position_name = $key_p;
                    $chance = (int)$value['chance'];
                    $this_position = $key;
                    $chance = (int)$value['chance'];
                    $banner_id = $this->banner->id;
                    // update or create:
                    BannerPosition::updateOrCreate(
                        ['banner_id' => $this->banner->id, 'position_name' => $position_name, 'this_position' => $this_position],
                        [
                            'position_name' => $position_name,
                            'this_position' => $this_position,
                            'banner_id' => $banner_id,
                            'chance' => $chance,
                            'banner_id' => $banner_id,
                        ]
                    );
                }
            }
        }
        $this->banner->data = $selectedPositions;
        $this->banner->save();

        // return back to banners page
        $this->redirect(BannersTable::class, navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.banners.banners-edit');
    }
}
