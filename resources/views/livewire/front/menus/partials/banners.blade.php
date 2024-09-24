<div class="main-slider">
    <div class="slider-container">
        <div class="banner-slider" wire:ignore>
            <div class="splide" role="group" aria-label="Splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($banners as $banner)
                            <li class="splide__slide">
                                <img src="/storage/{{ $banner['normal_image'] }}" style="border-radius: 20px;">
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
