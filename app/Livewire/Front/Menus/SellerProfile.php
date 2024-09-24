<?php

namespace App\Livewire\Front\Menus;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;

class SellerProfile extends Component
{
    use WithPagination;
    public $product_id = null;
    public $seller_id;
    public $seller;
    public $user_id;
    public $user;

    public function mount($seller_id)
    {
        $this->seller_id = $seller_id;
        $this->seller = User::find($seller_id);
        $this->user_id = $seller_id;
        $this->product_id = null;
    }
    public function render()
    {
        return view('livewire.front.menus.seller-profile', [
            'products' => $this->seller->products()->paginate(10),
        ]);
    }
}
