@if ($featured_products->count() > 0)
    @foreach ($featured_products as $product)
        @php
            $owner_name = '';
            $owner_invoice_city = '';
            $this_owner = \App\Models\User::find($product->user_id);
            $battery = $product->battery;
            if ($this_owner != null) {
                $owner_name = $this_owner->name;
                $owner_info = \App\Models\UserInfo::where('user_id', $product->user_id)->first();
                if ($owner_info != null) {
                    $owner_invoice_city = $owner_info->invoice_city;
                }
            }
        @endphp
        <a href="/showproduct/{{ $product->slug }}" wire:key="featured_{{ $product->id }}" wire:navigate>
            <div class="category-grid-item">
                <div class="category-grid-prod-image"{{--  id="this{{ $product->id }}" --}} style="position: relative;">
                    <img src="{{ $product->getMedia('gallery')->first()?->getUrl() }}" />
                    <div class="featured-label">KIEMELT</div>
                </div>
                <div class="category-grid-prod-data">
                    <p class="category-grid-price-tag">{{ number_format($product->price) }} Ft</p>
                    <p class="category-grid-name-tag">{{ Str::limit($product->name, 40) }}</p>
                    @if (isset($product->data['attributes']) && $product->data['attributes'] != null)
                        @foreach ($product->data['attributes'] as $key => $value)
                            @if (isset($value['attr_display_name']))
                                @if ($value['attr_display_name'] == 'Akkumulátor')
                                    @php
                                        $battery = $value['value'];
                                    @endphp
                                @endif
                                @if ($loop->iteration == 2)
                                @break
                            @endif
                            <label class="category-grid-attributes"> {{ $value['value'] }}
                            </label>
                        @endif
                    @endforeach
                @endif
                <div style="display: flex; flex-direction: row; width: 100%;font-size: 17px;"> <img
                        src="/img/menuicons/termek-oldali-szem.svg" style="width:15px;margin-right: 5px;"> Feltöltő:
                    {{ $owner_name }}
                </div>
                <div style="display: flex; flex-direction: row; width: 100%;font-size: 15px;">
                    @if ($battery != null)
                        <span class="akku-title">{{ $battery }}%
                            akku</span>
                    @endif
                    <span class="city-title"> {{ $owner_invoice_city }}</span>
                    @include('livewire.front.menus.partials.favorite-span')
                </div>
            </div>

        </div>
    </a>
@endforeach
@endif
