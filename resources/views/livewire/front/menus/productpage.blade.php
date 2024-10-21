<div class="product-page-content">
    <style>

    </style>
    <div class="product-name">
        <p>{{ $product->name }}</p>
    </div>

    @auth
        @if (auth()->user()->id == $product->user_id)
            <div class="product-edit">
                <a href="{{ route('myproducts.edit', $product->slug) }}" wire:navigate role="button"
                    class="base-button">Szerkesztés</a>
            </div>
        @endif
    @endauth

    @include('livewire.front.menus.partials.productpage-slider')

    <div class="product-data-row">
        <div class="description">
            <div class="product-data-title">Termékjellemzők</div>

            @if ($product->battery != null)
                <div class="description-text">
                    <div class="form-inline items-start flex-col xl:flex-row pt-5 first:mt-0 first:pt-0">
                        <div class="form-label
                            xl:w-64 xl:!mr-10">
                            <div class="text-left">
                                <div class="flex items
                                    -center">
                                    <div class="font-medium"><strong>Akkumulátor:</strong>
                                        {{ $product->battery }} %</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="description-text">
                @if ($product->device_state != null)
                    <div class="form-inline items-start flex-col xl:flex-row pt-5 first:mt-0 first:pt-0">
                        <div class="form-label xl:w-64 xl:!mr-10">
                            <div class="text-left">
                                <div class="flex items-center">
                                    <div class="font-medium"><strong>Eszköz állapota:</strong>
                                        {{ \App\Models\Product::DEVICE_STATES[$product->device_state] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if (isset($product->data['attributes']) && $product->data['attributes'] != null)
                    <div class="mt-3">
                        @foreach ($product->data['attributes'] as $key => $value)
                            <div wire:key="attr-{{ $key }}"
                                class="form-inline items-start flex-col xl:flex-row pt-5 first:mt-0 first:pt-0">
                                <div class="form-label xl:w-64 xl:!mr-10">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium"><strong>{{ $value['attr_display_name'] }}:</strong>
                                                {{ $value['value'] }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                @if ($product->keret != null)
                    <div class="form-inline items-start flex-col xl:flex-row pt-5 first:mt-0 first:pt-0">
                        <div class="form-label xl:w-64 xl:!mr-10">
                            <div class="text-left">
                                <div class="flex items-center">
                                    <div class="font-medium"><strong>Keret állapota:</strong>
                                        {{ \App\Models\Product::DEVICE_STATUS[$product->keret] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($product->hatlap != null)
                    <div class="form-inline items-start flex-col xl:flex-row pt-5 first:mt-0 first:pt-0">
                        <div class="form-label xl:w-64 xl:!mr-10">
                            <div class="text-left">
                                <div class="flex items-center">
                                    <div class="font-medium"><strong>Hátlap állapota:</strong>
                                        {{ \App\Models\Product::DEVICE_STATUS[$product->hatlap] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($product->kijelzo != null)
                    <div class="form-inline items-start flex-col xl:flex-row pt-5 first:mt-0 first:pt-0">
                        <div class="form-label xl:w-64 xl:!mr-10">
                            <div class="text-left">
                                <div class="flex items-center">
                                    <div class="font-medium"><strong>Kijelző állapota:</strong>
                                        {{ \App\Models\Product::DEVICE_STATUS[$product->kijelzo] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($product->fedlap != null)
                    <div class="form-inline items-start flex-col xl:flex-row pt-5 first:mt-0 first:pt-0">
                        <div class="form-label xl:w-64 xl:!mr-10">
                            <div class="text-left">
                                <div class="flex items-center">
                                    <div class="font-medium"><strong>Fedlap állapota:</strong>
                                        {{ \App\Models\Product::DEVICE_STATUS[$product->fedlap] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($product->haz != null)
                    <div class="form-inline items-start flex-col xl:flex-row pt-5 first:mt-0 first:pt-0">
                        <div class="form-label xl:w-64 xl:!mr-10">
                            <div class="text-left">
                                <div class="flex items-center">
                                    <div class="font-medium"><strong>Ház állapota:</strong>
                                        {{ \App\Models\Product::DEVICE_STATUS[$product->haz] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
        <div class="description">
            <div class="product-data-title">Leírás</div>
            <div class="description-text">{!! nl2br(e($product->description)) !!}</div>

        </div>
    </div>

    <div class="w-full">
        <livewire:front.ratings.user-rating-table :seller_id="$seller_id" :product_id="$product_id" />
    </div>

    <div class="w-full">
        <div class="title-name">
            <p>Mások ezt nézik most</p>
        </div>
    </div>


    <div class="{{ $others_view_these->count() == 0 ? 'profile-content' : 'category-container' }}">
        @if ($others_view_these->count() == 0)
            <div class="flex w-full">
                <p class="category-grid-name-tag">Nincs találat</p>
            </div>
        @endif
        @foreach ($others_view_these as $item)
            <a href="/showproduct/{{ $item->slug }}" wire:navigate>
                <div class="category-grid-item">
                    <div class="category-grid-prod-image"{{--  id="this{{ $item->id }}"  --}}>
                        <img src="{{ $item->getMedia('gallery')->first()?->getUrl() }}" />
                    </div>
                    <div class="category-grid-prod-data">
                        <p class="category-grid-price-tag">{{ number_format($item->price) }} Ft</p>
                        <p class="category-grid-name-tag">{{ Str::limit($item->name, 40) }}</p>
                        @if (isset($item->data['attributes']) && $item->data['attributes'] != null)
                            @foreach ($item->data['attributes'] as $key => $value)
                                @if (isset($value['attr_display_name']))
                                    <label class="category-grid-attributes"> {{ $value['value'] }}
                                        @if ($loop->last)
                                        @else
                                            |
                                        @endif
                                    </label>
                                @endif
                                @if ($loop->iteration == 3)
                                @break
                            @endif
                        @endforeach
                    @endif
                </div>
                <button class="base-button category-grid-button mt-3">Megnézem</button>
            </div>
        </a>
    @endforeach

</div>


<div class="w-full">
    <div class="title-name-back">
        <p>Termékhez ajánlott kiegészítők</p>
    </div>
</div>

<div class="{{ $kiegeszitok->count() == 0 ? 'profile-content' : 'category-container' }}">
    @if ($kiegeszitok->count() == 0)
        <div class="flex w-full">
            <p class="category-grid-name-tag">Nincs találat</p>
        </div>
    @endif
    @foreach ($kiegeszitok as $item)
        <a href="/showproduct/{{ $item->slug }}" wire:navigate>
            <div class="category-grid-item">
                <div class="category-grid-prod-image">
                    <img src="{{ $item->getMedia('gallery')->first()?->getUrl() }}" />
                </div>
                <div class="category-grid-prod-data">
                    <p class="category-grid-price-tag">{{ number_format($item->price) }} Ft</p>
                    <p class="category-grid-name-tag">{{ Str::limit($item->name, 40) }}</p>
                    @foreach ($item->data['attributes'] as $key => $value)
                        @if (isset($value['attr_display_name']))
                            <label class="category-grid-attributes"> {{ $value['value'] }}
                                @if ($loop->last)
                                @else
                                    |
                                @endif
                            </label>
                        @endif
                        @if ($loop->iteration == 3)
                        @break
                    @endif
                @endforeach
            </div>
            <button class="base-button category-grid-button mt-3">Megnézem</button>
        </div>
    </a>
@endforeach

</div>


<x-admin-user-modal title="{{ $title }}" name="admin-modal">
<x-slot:body>

    <form wire:submit="submit">

        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            @if ($is_order == false)
                <label style="margin: 12px;">
                    {{ $selected_product?->name }}
                </label>
                <br>
                <div>
                    <textarea wire:model="msg_body" id="" style="width: 100%" rows="10"></textarea>
                </div>
            @else
                <label style="margin: 12px;font-size: 1.1rem">
                    <strong> {{ $selected_product?->name }}</strong>
                </label>
                <br>
                {{ $msg_body }}
            @endif
        </div>
        <div class="bg-gray-200 px-4 py-3 text-right" style="background: #bb539a">
            <button type="button" wire:click="cancelSubmit"
                class="rounded-lg px-4 py-2 bg-gray-200 hover:bg-gray-300 duration-300 save-button"><i
                    class="fas fa-times"></i>
                Mégse</button>

            @if ($is_order == false)
                <button type="submit" @click="$dispatch('submit')" class="save-button"><i
                        class="fas fa-plus"></i>
                    Elküld</button>
            @else
                <button type="button" wire:click="submitorder()" class=" save-button"><i
                        class="fas fa-plus"></i>
                    Rendelés elküldése</button>
            @endif

        </div>
    </form>


</x-slot>
</x-admin-user-modal>
<script>
    document.addEventListener("livewire:navigated", () => {
        // Add data-scroll-x to body:
        document.body.setAttribute("data-scroll-x", window.scrollX);
    })
</script>
</div>
