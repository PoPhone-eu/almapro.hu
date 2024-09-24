<?php

namespace App\Livewire\Front\Menus;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\CustomerOrder;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;

class CustomerOrdersTable extends Component
{
    use WithPagination;

    public function deleteCustomerOrder($id)
    {
        $order = CustomerOrder::find($id);
        $order->delete();
        $this->js("alert('Sikeresen törölted a rendelést!');");
    }

    #[On('changeCustomerOrderStatus')]
    public function changeCustomerOrderStatus($id, $status)
    {
        $order = CustomerOrder::find($id);
        $order->order_status = $status;
        $order->save();
        $product = Product::find($order->product_id);
        if ($status == 'completed') {
            $product->is_sold = true;
        } else {
            $product->is_sold = false;
        }
        $product->save();
        $this->dispatch('reloadit');
        $this->js("alert('Sikeresen megváltoztattad a rendelés státuszát!');");
    }

    public function render()
    {
        return view('livewire.front.menus.customer-orders-table', [
            'orders' => CustomerOrder::where('seller_id', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(10)
        ]);
    }
}
