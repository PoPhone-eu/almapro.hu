    <div class="product-page-content">

        <div class="category-container">
            @if ($products->count() > 0)
                @foreach ($products as $item)
                    <a href="/showproduct/{{ $item->slug }}" wire:navigate>
                        <div class="category-grid-item">
                            <div class="category-grid-prod-image"{{--  id="this{{ $item->id }}" --}}>
                                <img src="{{ $item->getMedia('gallery')->first()?->getUrl() }}" />
                            </div>
                            <div class="category-grid-prod-data">
                                <p class="category-grid-price-tag">{{ number_format($item->price) }} Ft</p>
                                <p class="category-grid-name-tag">{{ Str::limit($item->name, 40) }}</p>
                                @if (isset($item->data['attributes']) && $item->data['attributes'] != null)
                                    @foreach ($item->data['attributes'] as $key => $value)
                                        @if (isset($value['attr_display_name']))
                                            <label class="category-grid-attributes"> {{ $value['value'] }} @if ($loop->last)
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
        @endif
        <div x-data="{
            observe() {
                let observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            @this.call('loadMore')
                        }
                    })
                }, {
                    root: null
                })
        
                observer.observe(this.$el)
            }
        }" x-init="observe"></div>
        @if ($products->hasMorePages())
            <button wire:click.prevent="loadMore">További termékek...</button>
        @endif
    </div>
</div>
