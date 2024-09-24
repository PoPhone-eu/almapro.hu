        <div class="category-container">
            @foreach ($myfavorites as $favorite)
                @php
                    $product = \App\Models\Product::find($favorite->product_id);
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

                <div class="category-grid-item">
                    <a href="/showproduct/{{ $product->slug }}" wire:navigate>
                        <div class="category-grid-prod-image">
                            <img src="{{ $product->getMedia('mainimage')->first()?->getUrl() }}" />
                        </div>
                    </a>
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
                            src="/img/menuicons/termek-oldali-szem.svg"
                            style="width:15px;margin-right: 5px;">Feltöltő:
                        {{ $owner_name }}
                    </div>

                    <div style="display: flex; flex-direction: row; width: 100%;font-size: 15px;">
                        @if ($battery != null)
                            <span class="akku-title">{{ $battery }}%
                                akku</span>
                        @endif
                        <span class="city-title"> {{ $owner_invoice_city }}</span>
                        <span class="favorite-span">
                            <img style="cursor:pointer" wire:click="removeFavorite('{{ $product->id }}')"
                                wire:confirm="Biztos, hogy kiveszed a kedvencekből?"
                                src="/img/menuicons/kedvencek-ikon.svg" width="20px" alt="Kedvenc">
                        </span>
                    </div>
                </div>
            </div>
        @endforeach




    </div>
