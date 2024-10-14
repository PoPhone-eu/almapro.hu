<div class="contact third p-5">
    <div class="flex flex-row justify-between  items-center">
        <div class="product-data-title">Vedd fel a kapcsolatot</div>
        <div class="flex flex-row">
            @auth
                @if ($product->isFavorite(auth()->user()->id) == false)
                    <img style="cursor:pointer" wire:click="addFavorite('{{ $product_id }}')"
                        wire:confirm="Biztosan hozzáadod a kedvenceidhez?" src="/img/menuicons/kedvencek-ikon.svg"
                        width="30px" alt="Kedvenc">
                @endif
            @else
                <a href="/myfavorites" wire:navigate>
                    <img src="/img/menuicons/kedvencek-ikon.svg" width="30px" alt="Kedvenc">
                </a>
            @endauth

            <a href="/profiloldal/{{ $product->user_id }}" wire:navigate><img
                    src="/img/menuicons/termek-oldali-szem.svg" style="width:30px;margin-left: 6px;"></a>
        </div>
    </div>

    <div class="flex flex-row justify-between contact-row">
        <a href="/profiloldal/{{ $product->user_id }}" wire:navigate>
            <div class="product-data-user flex flex-row justify-between">

                @if ($user->avatar == 'avatar.png' || $user->avatar == null)
                    <img src="/avatars/avatar.png" class="avatar">
                @else
                    <img src="/storage/{{ $user->avatar }}" class="avatar">
                @endif
                <div class="flex flex-col">
                    <p class="text-bold">{{ $user->full_name }}</p>
                    <div class="flex flex-row">
                        <div class='rating-container'>
                            <div class='rating-stars'>
                                @php
                                    $this_rating = getApprovedRating($user->id);
                                    $this_rating = getRatingPercentage($this_rating);
                                @endphp
                                <span class='rating' style="width: {{ round($this_rating, 1) }}%"></span>
                            </div>

                        </div>
                        ({{ countRating($user->id) }})
                        <svg width='0' height='0'>
                            <defs>
                                <clipPath id='svgStars' clipPathUnits = 'objectBoundingBox'>
                                    <polygon
                                        points=".80 .073 .738 .118 .762 .19 .70 .145 .638 .19 .662 .118 .60 .073 .538 .118 .562 .19 .50 .145 .438 .19 .462 .118 .40 .073 .338 .118 .362 .19 .30 .145 .238 .19 .262 .118 .20 .073 .138 .118 .162 .19 .10 .145 .038 .19 .062 .118 0 .073 .076 .073 .10 0 .124 .073 .276 .073 .30 0 .324 .073 .476 .073 .50 0 .524 .073 .676 .073 .70 0 .724 .073 .876 .073 .90 0 .924 .073 1 .073 .938 .118 .962 .19 .90 .145 .838 .19 .862 .118 " />
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                </div>

            </div>
        </a>

        <div class="product-price flex flex-col text-right">
            <p class="product-price-tag">{{ number_format($product->price) }} Ft</p>
            <div class="text-right">
                <img src="/img/naptar.png" style="float:left; margin-top:4px;">
                <label style="float:right;">
                    {{ \Carbon\Carbon::parse($product->created_at)->format('Y-m-d') }}</label>
            </div>
        </div>
    </div>


    <div class="flex flex-row justify-between contact-row-info">
        <div class="text-color-main">
            <p>Utoljára online: {{ $last_online }}</p>

            <div class="flex flex-col">
                <p class="mt-5 underline">Szállítás</p>
                @if ($product->local_pickup == true)
                    <span><strong>- Helyszínen átvehető</strong></span>
                @endif
                @if ($product->delivery == true)
                    <span><strong>- Postai kiküldés. Költsége:</strong>
                        {{ number_format($product->delivery_price) }} Ft</span>
                @endif

                @if ($product->shops()->count() > 0)
                    <p class="mt-5 underline">Bolt(ok):</p>
                    @foreach ($product->shops as $shop)
                        <span><strong>{{ $shop->shop_name }}</strong><br>Cím: {{ $shop->shop_address }}<br>Tel.:
                            {{ $shop->shop_telephone }}</span>
                    @endforeach
                @endif

                @auth
                    <a role="button" onclick="window.location.href='tel:{{ $seller->phone }}'" {{-- href="tel:{{ $seller->phone }}" --}}
                        class="base-button-pink"
                        style="{{ $product->user_id == auth()->user()->id ? 'display:none' : '' }}">{{ $seller->phone }}</a>

                    <a role="button" wire:click="compose({{ $product->id }})" class="base-button-pink"
                        {{ $product->user_id == auth()->user()->id ? 'disabled' : '' }}>Üzenet</a>
                @else
                    <a role="button" href="{{ route('login') }}" wire:navigate class="base-button-pink">Hívás</a>
                    <a role="button" href="{{ route('login') }}" wire:navigate class="base-button-pink">Üzenet</a>
                @endauth
            </div>


        </div>

        <div class="flex flex-col">
            @if ($product->url != null)
                <a href="{{ $product->url }}" target="_blank" class="profile-button font-semibold text-center"
                    style="margin-bottom: 10px;">Irány a
                    bolt</a>
            @endif
            @auth
                <button wire:click="compose({{ $product->id }})" class="base-button"
                    {{ $product->user_id == auth()->user()->id ? 'disabled' : '' }}>Ajánlatot teszek</button>

                @if ($user->role == 'company')
                    <button wire:click="sendOrder({{ $product->id }})" class="base-button mt-5"
                        {{ $product->user_id == auth()->user()->id ? 'disabled' : '' }}>Rendelés leadása</button>
                @endif
            @else
                <a role="button" href="{{ route('login') }}" wire:navigate class="base-button">Ajánlatot
                    teszek</a>
            @endauth

        </div>

    </div>

</div>
