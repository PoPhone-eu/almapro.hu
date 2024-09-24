<?php

namespace App\Livewire\Company\Shops;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;

class ShopsTable extends Component
{
    public $user_id;
    #[Rule('required')]
    public $shop_name;
    #[Rule('required')]
    public $shop_address;
    #[Rule('nullable')]
    public $shop_telephone;
    public $shop_id;
    public $modalstatus;
    public $modal_title;

    public function mount()
    {
        $this->user_id = auth()->user()->id;
    }

    public function addshop()
    {
        $this->resetFields();
        $this->modalstatus      = 'new';
        $this->modal_title      = 'Bolt hozzáadása';
        $this->dispatch('open-admin-modal');
    }

    public function editshop($shop_id)
    {
        $this->resetFields();
        $this->modalstatus      = 'edit';
        $this->modal_title      = 'Bolt szerkesztése';
        $this->shop_id          = $shop_id;
        $shop = auth()->user()->shops()->find($shop_id);
        $this->shop_name        = $shop->shop_name;
        $this->shop_address     = $shop->shop_address;
        $this->shop_telephone   = $shop->shop_telephone;
        $this->dispatch('open-admin-modal');
    }

    public function deleteshop($shop_id)
    {
        $this->resetFields();
        $shop = auth()->user()->shops()->find($shop_id);
        $shop->delete();
    }

    #[On('cancelSubmit')]
    public function cancelSubmit()
    {
        $this->resetFields();
        $this->dispatch('close-modal');
    }

    #[On('submit')]
    public function submit()
    {
        $this->validate();
        if ($this->shop_id == null) {
            // save new shop of user:
            $newshop = auth()->user()->shops()->create([
                'shop_name'         => $this->shop_name,
                'shop_address'      => $this->shop_address,
                'shop_telephone'    => $this->shop_telephone,
            ]);
        } else {
            // we update shop fields:
            $shop = auth()->user()->shops()->find($this->shop_id);
            $shop->shop_name        = $this->shop_name;
            $shop->shop_address     = $this->shop_address;
            $shop->shop_telephone   = $this->shop_telephone;
            $shop->save();
        }
        $this->cancelSubmit();
    }

    private function resetFields()
    {
        $this->shop_name        = null;
        $this->shop_address     = null;
        $this->shop_telephone   = null;
        $this->shop_id          = null;
        $this->modalstatus      = null;
        $this->modal_title      = null;
    }

    public function render()
    {
        return view('livewire.company.shops.shops-table', [
            'shops' => auth()->user()->shops()->get()
        ]);
    }
}
