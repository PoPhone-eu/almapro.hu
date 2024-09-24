        @php
            $getRoute = null;
            $banners = [];
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

            if ($getRoute != null) {
                $banners = \App\Services\BannerRotationService::getRandomBanners('top', $getRoute);
            }
        @endphp

        @include('livewire.front.menus.partials.banners')
