<?php

namespace App\Livewire\Front\Menus;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;

#[Layout('layouts.adminapp')]
class Searchbar extends Component
{
    public $search;
    public $searchresult = null;

    public function searchProducts()
    {
        if ($this->search != null) {
            $search = $this->search;
            $this->searchresult = Product::where('is_featured', false)->where('is_sold', false)
                ->where('name', 'like', '%' . $search . '%')->limit(5)->get();
        } else {
            $this->searchresult = null;
        }
    }

    #[On('hideResults')]
    public function hideResults()
    {
        $this->searchresult = null;
        $this->search = null;
    }

    public function routeingToSearchpage()
    {
        // routing to search page with search query: $this->search
        return $this->redirect('/searchresult', ['search' => $this->search]);
    }

    public function render()
    {
        if ($this->search != null) {
            $search = $this->search;
            $this->searchresult = Product::where('is_featured', false)->where('is_sold', false)
                ->where('name', 'like', '%' . $search . '%')->limit(5)->get();
        } else {
            $this->searchresult = null;
        }
        return view('livewire.front.menus.searchbar');
    }
}
