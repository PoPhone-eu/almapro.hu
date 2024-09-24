<?php

namespace App\Livewire\Front;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use App\Services\BannerRotationService;

class BannerSection extends Component
{
    public $getRoute;
    public $banner_id_index;
    public $banners;

    public function mount($getRoute = null, $banner_id_index = 001)
    {
        $this->getRoute = $getRoute;
        // random index number
        $this->banner_id_index = rand(1, 1000000);
        //$this->banner_id_index = $banner_id_index;

        $getRoute = null;
        $banners = [];
        if ($this->getRoute == null) {
            if (request()->is('/')) {
                $getRoute = 'home';
            } elseif (request()->is('iphone')) {
                $getRoute = 'iPhone';
            } elseif (request()->is('ipad')) {
                $getRoute = 'iPad';
            } elseif (request()->is('applewatch')) {
                $getRoute = 'Watch';
            } elseif (request()->is('macbook')) {
                $getRoute = 'MacBook';
            } elseif (request()->is('imac')) {
                $getRoute = 'iMac';
            } elseif (request()->is('others')) {
                $getRoute = 'Others';
            } elseif (request()->is('samsung')) {
                $getRoute = 'Samsung';
            } elseif (request()->is('android')) {
                $getRoute = 'Android';
            } elseif (request()->is('egyeb')) {
                $getRoute = 'egyeb';
            }
        } else {
            $getRoute = $this->getRoute;
        }
        $this->banners = BannerRotationService::getRandomBanners('top', $getRoute);
    }

    public function render()
    {
        return view('livewire.front.banner-section');
    }
}
