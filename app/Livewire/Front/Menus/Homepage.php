<?php

namespace App\Livewire\Front\Menus;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use App\Services\BannerRotationService;

class Homepage extends Component
{
    use WithPagination;

    public $perPage = 16;

    public function loadMore()
    {
        $this->perPage += 16;
    }

    public function render()
    {

        //dd($bannertesz);
        return view(
            'livewire.front.menus.homepage',
            [
                'products' => Product::where('is_featured', false)->where('is_sold', false)->orderBy('created_at', 'desc')->paginate($this->perPage),
                'featured_products' => Product::where('is_featured', true)->where('is_sold', false)
                    // where today is between featured_from and featured_to dates:
                    ->whereDate('featured_from', '<=', now())->whereDate('featured_to', '>=', now())
                    ->orderBy('featured_from', 'desc')->get(),
                'banners' => BannerRotationService::getRandomBanners('top', 'home', 5)
            ]
        );
    }
}
