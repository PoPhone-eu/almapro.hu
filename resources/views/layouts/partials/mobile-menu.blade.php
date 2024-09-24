<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar">
        <a href="" class="flex mr-auto">
            <img alt="{{ config('app.name', 'Almapro') }}" class="w-6" src="/dist/images/logo.svg">
        </a>
        <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="bar-chart-2"
                class="w-8 h-8 text-white transform -rotate-90"></i> </a>
    </div>
    <div class="scrollable">
        <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="x-circle"
                class="w-8 h-8 text-white transform -rotate-90"></i> </a>
        <ul class="scrollable__content py-2">


            <li>
                <a href="/admindash" wire:navigate class="menu">
                    <div class="menu__icon"> <i data-lucide="home"></i> </div>
                    <div class="menu__title"> Vezérlőpult </div>
                </a>
            </li>

            <li>
                <a href="/products" wire:navigate class="menu">
                    <div class="menu__icon"> <i data-lucide="box"></i> </div>
                    <div class="menu__title"> Termékek </div>
                </a>
            </li>

            <li>
                <a href="/banners" wire:navigate class="menu">
                    <div class="menu__icon"> <i data-lucide="box"></i> </div>
                    <div class="menu__title"> Bannerek </div>
                </a>
            </li>

            <li class="menu__devider my-6"></li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-lucide="users"></i> </div>
                    <div class="menu__title"> Eladók <i data-lucide="chevron-down" class="menu__sub-icon "></i>
                    </div>
                </a>
                <ul class="">
                    {{--  <li>
                        <a href="/personal" wire:navigate class="menu">
                            <div class="menu__icon"> <i data-lucide="chevron-down"></i> </div>
                            <div class="menu__title"> Regisztrált Vásárlók </div>
                        </a>
                    </li> --}}
                    <li>
                        <a href="/companies" class="menu">
                            <div class="menu__icon"> <i data-lucide="chevron-down"></i> </div>
                            <div class="menu__title"> Kereskedők </div>
                        </a>
                    </li>
                    <li>
                        <a href="/personal" wire:navigate class="menu">
                            <div class="menu__icon"> <i data-lucide="chevron-down"></i> </div>
                            <div class="menu__title"> Magánszemélyek </div>
                        </a>
                    </li>
                    <li>
                        <a href="/invoices-table" wire:navigate class="menu">
                            <div class="menu__icon"> <i data-lucide="chevron-down"></i> </div>
                            <div class="menu__title"> Számlák </div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu__devider my-6"></li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-lucide="users"></i> </div>
                    <div class="menu__title"> Beállítások <i data-lucide="chevron-down" class="menu__sub-icon "></i>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="/attributes" wire:navigate class="menu">
                            <div class="menu__icon"> <i data-lucide="chevron-down"></i> </div>
                            <div class="menu__title"> Termékjellemzők </div>
                        </a>
                    </li>
                    <li>
                        <a href="/categories" wire:navigate class="menu">
                            <div class="menu__icon"> <i data-lucide="chevron-down"></i> </div>
                            <div class="menu__title"> Kategóriák </div>
                        </a>
                    </li>
                    <li>
                        <a href="/sitesettings" wire:navigate class="menu">
                            <div class="menu__icon"> <i data-lucide="chevron-down"></i> </div>
                            <div class="menu__title"> Weboldal beállítások </div>
                        </a>
                    </li>
                    <li>
                        <a href="/apikeys" wire:navigate class="menu">
                            <div class="menu__icon"> <i data-lucide="chevron-down"></i> </div>
                            <div class="menu__title"> API kulcsok </div>
                        </a>
                    </li>
                    <li>
                        <a href="/legaldocuments" wire:navigate class="menu">
                            <div class="menu__icon"> <i data-lucide="chevron-down"></i> </div>
                            <div class="menu__title"> Dokumentumok </div>
                        </a>
                    </li>
                    <li>
                        <a href="/admins" wire:navigate class="menu">
                            <div class="menu__icon"> <i data-lucide="chevron-down"></i> </div>
                            <div class="menu__title"> Adminok </div>
                        </a>
                    </li>
                </ul>
            </li>


        </ul>
    </div>
</div>
