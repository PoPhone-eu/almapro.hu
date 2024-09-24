<?php

namespace App\Livewire\Admin\Product\Products;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;

#[Layout('layouts.adminapp')]
class AddProductTypeLoop extends Component
{

    public function render()
    {
        return view('livewire.admin.product.products.add-product-type-loop');
    }
}
