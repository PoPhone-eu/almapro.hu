<?php

namespace App\Livewire\Front\Menus;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

class Searchresult extends Component
{
    use WithPagination;

    public $perPage = 16;
    public $search;

    public function mount($search)
    {
        $this->search = $search;
    }

    public function loadMore()
    {
        $this->perPage += 16;
    }

    public function render()
    {
        return view('livewire.front.menus.searchresult', [
            'products' => Product::where('is_featured', false)->where('is_sold', false)
                ->where('name', 'like', '%' . $this->search . '%')->paginate($this->perPage)
        ]);
    }
}
