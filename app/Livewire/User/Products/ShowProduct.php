<?php

namespace App\Livewire\User\Products;

use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;

#[Layout('layouts.adminapp')]
class ShowProduct extends Component
{
    public $user_id;
    public $product_id;
    public $user;
    public $product;

    public function mount($slug)
    {
        $this->product = Product::withTrashed()->where('slug', $slug)->first();
        $this->product_id = $this->product->id;

        $this->user_id = $this->product->user_id;
        $this->user = User::find($this->user_id);
    }

    public function render()
    {
        return view('livewire.user.products.show-product');
    }
}
