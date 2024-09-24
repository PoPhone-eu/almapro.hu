<?php

namespace App\Livewire\Front\Myfavorites;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;

#[Layout('layouts.adminapp')]
class FavoritesTable extends Component
{
    // removeFavorite
    public function removeFavorite($id)
    {
        $favorite = auth()->user()->favorites()->where('product_id', $id)->first();
        $favorite->delete();
    }

    public function render()
    {
        return view('livewire.front.myfavorites.favorites-table', [
            'myfavorites' => auth()->user()->favorites
        ]);
    }
}
