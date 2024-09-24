<?php

namespace App\Livewire\Front\Profile;

use Livewire\Component;
use App\Models\UserInfo;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Livewire\Forms\UserDataForm;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Forms\UserInvoiceDataForm;

class MyProfileData extends Component
{
    use WithFileUploads;
    public $user;
    public UserDataForm $dataform;
    public UserInvoiceDataForm $invoicedataform;

    #[Rule('nullable|image')]
    public $avatar;

    #[Rule('required')]
    public $invoice_address;
    #[Rule('required')]
    public $invoice_postcode;
    #[Rule('required')]
    public $invoice_city;
    #[Rule('required')]
    public $invoice_country = 'Magyarország';


    public function mount()
    {
        $this->user = auth()->user();
        $this->user->updated_at = now();
        $this->user->save();

        $this->dataform->setUser($this->user);
        $user_infos = UserInfo::where('user_id', $this->user->id)->first();
        if ($user_infos == null) {
            // create new UserInfo for user:
            $user_infos = UserInfo::create([
                'user_id' => $this->user->id,
                'invoice_address' => '',
                'invoice_postcode' => '',
                'invoice_city' => '',
                'invoice_country' => '',
                'company_tax_number' => '',
                'company_name' => '',
            ]);
        }
        $this->invoicedataform->setInvoiceData($user_infos);
    }

    public function save()
    {
        $this->dataform->validate();
        $this->dataform->update();
        if ($this->avatar != null) {
            if ($this->user->avatar != null) {
                Storage::disk('public')->delete($this->user->avatar);
            }
            $this->avatar->store('public');
            $this->user->update([
                'avatar' => $this->avatar->hashName(),
            ]);
            $this->avatar = null;
        }
    }

    public function clearProfile()
    {
        $this->avatar = null;
    }

    public function saveInvoiceData()
    {
        $this->invoicedataform->validate();
        $this->invoicedataform->update();
    }

    public function render()
    {
        return view('livewire.front.profile.my-profile-data', [
            'useravatar' => $this->user->avatar,
        ]);
    }
}
