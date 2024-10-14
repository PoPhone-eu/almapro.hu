    <div class="logo-div">
        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobile-menu">
            <button id="close-menu" class="mobile-close-button" onclick="closemobilemenu()">
                &times;
            </button>
            <div class="p-4 mt-5">
                <a href="/iphone" wire:navigate class="menu-text p-2">
                    <img class="menu-icon" src="{{ asset('img/menuicons/iphone.svg') }}?rnd=1" alt="iPhone">
                    iPhone
                </a>
                <a href="/ipad" wire:navigate class="menu-text p-2">
                    <img class="menu-icon" src="{{ asset('img/menuicons/ipad.svg') }}?rnd=1" alt="iPad">
                    iPad
                </a>
                <a href="/applewatch" wire:navigate class="menu-text p-2">
                    <img class="menu-icon" src="{{ asset('img/apple-watch-menu-icon.svg') }}?rnd=1" alt="Apple Watch">
                    Apple Watch
                </a>
                <a href="/macbook" wire:navigate class="menu-text p-2">
                    <img class="menu-icon" src="{{ asset('img/menuicons/macbook.svg') }}?rnd=1" alt="MacBook">
                    MacBook
                </a>
                <a href="/imac" wire:navigate class="menu-text p-2">
                    <img class="menu-icon" src="{{ asset('img/menuicons/imac.svg') }}?rnd=1" alt="iMac">
                    iMac
                </a>
                <a href="/others" wire:navigate class="menu-text p-2">
                    <img class="menu-icon" src="{{ asset('img/menuicons/kiegeszitok.svg') }}?rnd=1" alt="Kiegészítők">
                    Kiegészítők
                </a>
                <a href="/samsung" wire:navigate class="menu-text p-2">
                    <img class="menu-icon" src="{{ asset('img/menuicons/samsung.svg') }}?rnd=1" alt="Samsung">
                    Samsung
                </a>
                <a href="/android" wire:navigate class="menu-text p-2">
                    <img class="menu-icon" src="{{ asset('img/menuicons/android.svg') }}?rnd=1" alt="Android">
                    Android
                </a>
                <a href="/egyeb" wire:navigate class="menu-text p-2">
                    <img class="menu-icon" src="{{ asset('img/menuicons/egyeb.svg') }}?rnd=1" alt="Egyéb">
                    Egyéb
                </a>
                @auth
                    <a href="/profiledata" wire:navigate class="menu-text p-2">
                        <img class="menu-icon menu-icon-login" src="{{ asset('img/menuicons/fiokom.svg') }}" alt="Fiókom">
                        Fiókom
                    </a>
                @else
                    <a href="{{ route('login') }}" wire:navigate class="menu-text p-2">
                        <img class="menu-icon menu-icon-login" src="{{ asset('img/menuicons/fiokom.svg') }}"
                            alt="Belépés">
                        Belépés
                    </a>
                @endauth

            </div>
        </div>
        <div class="left-div">
            <a href="javascript:void(0)" onclick="showMobileMenu()"><img class="left-logo" id="hamburger-menu"
                    src="{{ asset('img/hamburger.svg') }}?rnd=1"></a>
        </div>
        <div class="middle-div">
            <a href="/" wire:navigate>@include('partials.logo')</a>
        </div>
        <div class="right-div flex flex-row">
            <div class="right-buttons" style="justify-content: center;">

                @auth
                    @php
                        $count_unseen = \App\Models\InternalMessage::where('sent_to_id', auth()->user()->id)
                            ->where('seen', false)
                            ->where('archived_by_receiver', false)
                            ->count();
                    @endphp
                    <a href="/profiledata" wire:navigate class="tooltip relative" data-tooltip="Fiókom"> <img
                            class="hir-feladas-img" src="{{ asset('img/menuicons/fiokom.svg') }}?rnd=2"> <span
                            class="countlabel" {{ $count_unseen == 0 ? 'hidden' : '' }}>{{ $count_unseen }}<span></a>
                @else
                    <a href="{{ route('login') }}" wire:navigate class="tooltip" data-tooltip="Belépés"> <img
                            class="hir-feladas-img" src="{{ asset('img/menuicons/fiokom.svg') }}?rnd=2"></a>
                @endauth
            </div>
            <div class="right-buttons ml-3">
                <a href="/myproducts" wire:navigate role="button" class="base-button"
                    style="padding: 8px 20px;">Hirdetés feladás</a>
            </div>

        </div>
    </div>

    <div class="menu-div">
        <ul>
            <li>
                <a href="/iphone" wire:navigate class="menu-text">
                    <img class="menu-icon" src="{{ asset('img/menuicons/iphone.svg') }}?rnd=1" alt="iPhone">
                    iPhone
                </a>
            </li>
            <li>
                <a href="/ipad" wire:navigate class="menu-text">
                    <img class="menu-icon" src="{{ asset('img/menuicons/ipad.svg') }}?rnd=1" alt="iPad">
                    iPad
                </a>
            </li>
            <li>
                <a href="/applewatch" wire:navigate class="menu-text">
                    <img class="menu-icon" src="{{ asset('img/apple-watch-menu-icon.svg') }}?rnd=1"
                        alt="Apple Watch">
                    Apple Watch
                </a>
            </li>
            <li>
                <a href="/macbook" wire:navigate class="menu-text">
                    <img class="menu-icon" src="{{ asset('img/menuicons/macbook.svg') }}?rnd=1" alt="MacBook">
                    MacBook
                </a>
            </li>
            <li>
                <a href="/imac" wire:navigate class="menu-text">
                    <img class="menu-icon" src="{{ asset('img/menuicons/imac.svg') }}?rnd=1" alt="iMac">
                    iMac
                </a>
            </li>
            <li>
                <a href="/others" wire:navigate class="menu-text">
                    <img class="menu-icon" src="{{ asset('img/menuicons/kiegeszitok.svg') }}?rnd=1"
                        alt="Kiegészítők">
                    Kiegészítők
                </a>
            </li>
            <li>
                <a href="/samsung" wire:navigate class="menu-text">
                    <img class="menu-icon" src="{{ asset('img/menuicons/samsung.svg') }}?rnd=1" alt="Samsung">
                    Samsung
                </a>
            </li>
            <li>
                <a href="/android" wire:navigate class="menu-text">
                    <img class="menu-icon" src="{{ asset('img/menuicons/android.svg') }}?rnd=1" alt="Android">
                    Android
                </a>
            </li>
            <li>
                <a href="/egyeb" wire:navigate class="menu-text">
                    <img class="menu-icon" src="{{ asset('img/menuicons/egyeb.svg') }}?rnd=1" alt="Egyéb">
                    Egyéb
                </a>
            </li>
        </ul>

        <!-- Search bar HTML -->
        <livewire:front.menus.searchbar />

        <!-- Breadcrump HTML -->
        {{--  <div class="search-container-row">
            <span>Termékek / akármi / Akármi</span>
        </div> --}}

        <script>
            function closeMobileMenu() {
                const mobileMenu = document.getElementById('mobile-menu');
                mobileMenu.classList.remove('mobile-menu-show');
            }

            function showMobileMenu() {
                const mobileMenu = document.getElementById('mobile-menu');
                mobileMenu.classList.add('mobile-menu-show');
            }

            function closemobilemenu() {
                const mobileMenu = document.getElementById('mobile-menu');
                mobileMenu.classList.remove('mobile-menu-show');
            }
        </script>
    </div>
