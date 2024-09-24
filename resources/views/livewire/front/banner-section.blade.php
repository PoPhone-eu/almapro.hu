<div class="main-slider" wire:key="{{ $banner_id_index }}" wire:ignore>
    @if (count($banners) != 0)
        <div class="slider-container">
            <div class="banner-slider">
                <div class="splide" {{-- id="bannerspide_{{ $banner_id_index }}" --}} {{-- role="group" --}} aria-label="bannerspide">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach ($banners as $banner)
                                <li class="splide__slide">
                                    @if ($banner['link'] != null)
                                        <a href="{{ $banner['link'] }}" target="_blank">
                                            <img src="/storage/{{ $banner['normal_image'] }}"
                                                style="border-radius: 20px;">
                                        </a>
                                    @else
                                        <img src="/storage/{{ $banner['normal_image'] }}" style="border-radius: 20px;">
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="slider-container-mobile">
            <div class="banner-slider">
                <div class="splide" {{-- id="bannerspide_{{ $banner_id_index }}" --}} {{-- role="group" --}} aria-label="bannerspide">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach ($banners as $banner)
                                @php
                                    $image = $banner['normal_image'];
                                    if ($banner['mobile_image'] != null) {
                                        $image = $banner['mobile_image'];
                                    }
                                @endphp
                                <li class="splide__slide">
                                    @if ($banner['link'] != null)
                                        <a href="{{ $banner['link'] }}" target="_blank">
                                            <img src="/storage/{{ $image }}" style="border-radius: 20px;">
                                        </a>
                                    @else
                                        <img src="/storage/{{ $image }}" style="border-radius: 20px;">
                                    @endif

                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{--      @section('footer-scripts') --}}
        {{-- <script>
            document.addEventListener('livewire:navigated', () => {
                /*  document.addEventListener('DOMContentLoaded', function() { */
                index = '{{ $banner_id_index }}';
                banner_id_index2 = 'bannerspide_{{ $banner_id_index }}';
                var splideCheck = document.getElementById(banner_id_index2);
                console.log('bannerspide: ' + banner_id_index2);
                if (splideCheck) {
                    banner_id_index = '#bannerspide_{{ $banner_id_index }}';
                    /* var bannerspide =  */
                    new Splide(banner_id_index, {
                        type: 'loop',
                        perPage: 1,
                        arrows: false,
                        direction: 'ltr',
                        autoWidth: false,
                        perMove: 1,
                        pagination: false,
                        lazyLoad: 'nearby',
                        autoplay: true,
                        interval: 3000,
                        gap: '10px',
                        dragMinThreshold: {
                            mouse: 0,
                            touch: 10,
                        },
                    }).mount();

                }

            });
        </script> --}}
        {{--  @endsection --}}
    @endif
</div>
