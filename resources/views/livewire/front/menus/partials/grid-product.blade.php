@foreach ($products as $item)
    @php
        $owner_name = '';
        $owner_invoice_city = '';
        $this_owner = \App\Models\User::find($item->user_id);
        $battery = $item->battery;
        if ($this_owner != null) {
            $owner_name = $this_owner->name;
            $owner_info = \App\Models\UserInfo::where('user_id', $item->user_id)->first();
            if ($owner_info != null) {
                $owner_invoice_city = $owner_info->invoice_city;
            }
        }
    @endphp
    <a href="/showproduct/{{ $item->slug }}" wire:navigate>
        <div class="category-grid-item">
            <div class="category-grid-prod-image">
                <img src="{{ $item->getMedia('mainimage')->first()?->getUrl() }}" />
            </div>
            <div class="category-grid-prod-data">
                <p class="category-grid-price-tag">{{ number_format($item->price) }} Ft</p>
                <p class="category-grid-name-tag">{{ Str::limit($item->name, 40) }}</p>
                @if (isset($item->data['attributes']) && $item->data['attributes'] != null)
                    @foreach ($item->data['attributes'] as $key => $value)
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
                    src="/img/menuicons/termek-oldali-szem.svg" style="width:15px;margin-right: 5px;">Feltöltő:
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
