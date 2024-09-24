    @auth
        <div class="profile-menu">
            <a href="/profiledata" wire:navigate class="profile-button font-semibold mr-3">Adataim</a>
            @if (auth()->user()->role == 'company')
                @php
                    $count_new_orders = \App\Models\CustomerOrder::where('seller_id', auth()->user()->id)
                        ->where('order_status', 'new')
                        ->count();
                @endphp
                <a href="/shops" wire:navigate class="profile-button font-semibold mr-3">Boltjaim</a>
                <a href="/customer-orders" wire:navigate class="profile-button font-semibold mr-3">Rendelések
                    ({{ $count_new_orders }})</a>
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
            @if (auth()->user()->role != 'person')
                <a href="{{ route('myproducts.index') }}" wire:navigate
                    class="profile-button font-semibold mr-3">Hirdetés</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf <button type="submit" onclick="event.preventDefault();  this.closest('form').submit();"
                    class="profile-button font-semibold mr-3 cursor-pointer">
                    Kilépés </button>
            </form>
        </div>
    @else
        <p>Nincs jogosultságod. <a href="/login" wire:navigate> Lépj be vagy regisztrálj.</a></p>
    @endauth
    <script>
        document.addEventListener("livewire:navigated", () => {
            // Add data-scroll-x to body:
            document.body.setAttribute("data-scroll-x", window.scrollX);
        })
    </script>
