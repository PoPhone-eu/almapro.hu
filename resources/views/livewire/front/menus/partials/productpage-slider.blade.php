<div class="product-slider-row">

    <div class="description productpage-grid-prod-image">
        <a href="{{ $selected_image->getUrl() }}" data-lightbox="{{ $product->name }}"
            data-title="{{ $product->name }}"><img src="{{ $selected_image->getUrl() }}"
                class="productpage-grid-prod-image-img" style="border-radius: 40px;padding: 15px;"></a>
    </div>

    <div class="product-slider p-1 mt-3 mb-2" wire:ignore>
        <div class="splide" id="productsplide" role="group" aria-label="productsplide">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach ($all_images as $image)
                        <li class="splide__slide" wire:key="slide_{{ $image->id }}">
                            <a wire:click="setSelectedImage('{{ $image->id }}')" class="cursor-pointer"><img
                                    src="{{ $image->getUrl() }}"></a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    @include('livewire.front.menus.partials.productpage-contact')

</div>
