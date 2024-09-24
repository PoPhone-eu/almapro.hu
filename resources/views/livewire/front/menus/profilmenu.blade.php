<div class="profile-menu">
    @auth
        <a href="/profiledata" wire:navigate class="profile-button font-semibold mr-3">Adataim</a>
        @if (auth()->user()->role == 'company')
            @php
                $count_new_orders = \App\Models\CustomerOrder::where('seller_id', auth()->user()->id)
                    ->where('order_status', 'new')
                    ->count();
            @endphp
            <a href="/shops" wire:navigate class="profile-button font-semibold mr-3">Boltjaim</a>
            <a href="/customer-orders" wire:navigate class="profile-button font-semibold mr-3">Rendelések
                ({{ $count_new_orders }})
            </a>
        @endif
        @if (auth()->user()->role != 'company')
            <a href="/myorders" wire:navigate class="profile-button font-semibold mr-3">Rendeléseim</a>
        @endif
        @php
            $count_notseen_messages = \App\Models\InternalMessage::where('sent_to_id', auth()->user()->id)
                ->where('seen', false)
                ->where('archived_by_receiver', false)
                ->count();
        @endphp
        <a href="{{ route('messages.index') }}" wire:navigate class="profile-button font-semibold mr-3">Üzenetek
            ({{ $count_notseen_messages }})
        </a>

        <a href="{{ route('myproducts.index') }}" wire:navigate class="profile-button font-semibold mr-3">Hirdetés</a>
        <a href="{{ route('myinvoices.index') }}" wire:navigate class="profile-button font-semibold mr-3">Számláim</a>
        <a href="{{ route('imei.index') }}" wire:navigate class="profile-button font-semibold mr-3">Telefon lekérdezés</a>
        <a href="/myfavorites" wire:navigate class="profile-button font-semibold mr-3">Kedvencek</a>
        <a href="/payment" wire:navigate class="profile-button font-semibold mr-3">Egyenlegfeltöltés</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" onclick="event.preventDefault();  this.closest('form').submit();"
                class="profile-button font-semibold mr-3 cursor-pointer">
                Kilépés </button>
        </form>
    @else
        <p>Nincs jogosultságod. <a href="/login" wire:navigate> Lépj be vagy regisztrálj.</a></p>
    @endauth
</div>
