    <div class="product-page-content" style="z-index: 1000">
        {{-- <style>
            .hand-img {
                width: 90%;
                z-index: 2;
                position: absolute;
                top: -50px;
                left: 8%;
            }

            .hand-section {
                margin: 0;
                z-index: 2;
                width: 100%;
                height: 600px;
                position: relative;
            }

            .category-container {
                grid-template-columns: repeat(auto-fill, minmax(276px, 1fr));
            }
        </style> --}}
        {{-- <div class="hand-section">
            <img src="{{ asset('img/menuicons/hand-cut.png') }}" class="hand-img" style="" />
        </div> --}}


        <div class="category-container">
            @include('livewire.front.menus.partials.featured_products')

            @if ($products->count() == 0)
                <div class="flex w-full">
                    <p class="category-grid-name-tag">Nincs találat</p>
                </div>
            @endif
            @include('livewire.front.menus.partials.grid-product')
            <!-- Check if the loop iteration is a multiple of 24 -->
            {{-- @if (($loop->index + 1) % 24 == 0)
    </div>
    @livewire('front.banner-section', ['getRoute' => 'home', 'banner_id_index' => $item->id])

    <div class="category-container">
        @endif --}}
            {{--   @endforeach --}}


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
