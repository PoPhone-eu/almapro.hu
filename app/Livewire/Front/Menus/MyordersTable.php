<?php

namespace App\Livewire\Front\Menus;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\CustomerOrder;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;

#[Layout('layouts.adminapp')]
class MyordersTable extends Component
{
    public function render()
    {
        return view(
            'livewire.front.menus.myorders-table',
            [
                'orders' => CustomerOrder::where('customer_id', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(10)
            ]
        );
    }
}
