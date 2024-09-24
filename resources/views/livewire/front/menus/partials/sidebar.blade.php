        <div class="category-sidebar">
            <div class="sidebar-title">{{ $title }}</div>
            <!-- Back button -->

            @if (count($navigation_stack) > 0)
                <div style="padding: 5px;"> <button class="back-button" wire:click="back">
                        Vissza</button>
                </div>
            @endif

            <div class="sidebar"
                style="{{ $sidebarStyle }};{{ count($subfilters) != 0 && count($subfilters) != 0 ? 'display:none' : '' }}">
                @foreach ($sidebar_items as $item)
                    <span class="w-full sidebar-button category-grid-button" wire:key="selected_{{ $item->id }}"
                        wire:click="set_selected_category_id({{ $item->id }})">{{ $product_type }} -
                        {{ $item->category_name }}</span>
                @endforeach
            </div>

            <div style="width: 100%;{{ count($subfilters) == 0 && count($subfilters) == 0 ? 'display:none' : '' }}">
                <div class="filter-title">Hirdetések szűrése</div>
            </div>

            {{--  <div class="sidebar filters" style="{{ count($filters) == 0 ? 'display:none' : '' }}">
                @foreach ($filters as $item)
                    <span class="w-full sidebar-button category-grid-button"
                        wire:key="filter_{{ $item->id }}">{{ $item->attr_display_name }}</span>
                    @php
                        $filter_cat = \App\Models\Category::find($item->category_id);
                    @endphp
                    <span
                        class="filter-cat">{{ $filter_cat != null ? '/' . $filter_cat->category_name . '/' : '' }}</span>
                    <ul>
                        @foreach ($item->values as $value)
                            <li class="filter-value">
                                <input type="checkbox"
                                    wire:click="set_selected_filter_id('{{ $value->product_attribute_id }}', '{{ $value->value }}')">
                                {{ $value->value }}
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </div> --}}

            <div class="sidebar subfilters" style="{{ count($subfilters) == 0 ? 'display:none' : '' }}">
                @foreach ($subfilters as $item)
                    @php
                        $attr_display_name = $item->attr_display_name;
                        if ($attr_display_name == 'szin') {
                            $attr_display_name = 'Szín';
                        } elseif ($attr_display_name == 'meret') {
                            $attr_display_name = 'Méret';
                        } elseif ($attr_display_name == 'allapot') {
                            $attr_display_name = 'Állapot';
                        } elseif ($attr_display_name == 'hattertar') {
                            $attr_display_name = 'Háttértár';
                        }
                    @endphp
                    <span class="w-full sidebar-button category-grid-button"
                        wire:key="subfilter_{{ $item->id }}">{{ $attr_display_name }}</span>
                    @php
                        $subfilter_cat = \App\Models\Category::find($item->category_id);
                    @endphp
                    <span
                        class="filter-cat">{{ $subfilter_cat != null ? '/' . $subfilter_cat->category_name . '/' : '' }}</span>
                    <ul>
                        @foreach ($item->values as $value)
                            <li class="filter-value">
                                <input type="checkbox"
                                    wire:click="set_selected_filter_id('{{ $value->product_attribute_id }}', '{{ $value->value }}')">
                                {{ $value->value }}
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
        </div>
