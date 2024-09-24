{{--    @php
       var_dump($product->data['attributes']);
   @endphp --}}

@foreach ($data['attributes'] as $key => $value)
    @if (isset($value['attr_display_name']))
        <div wire:key="productattributes-{{ $key }}"
            class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
            <div class="form-label xl:w-64 xl:!mr-10">
                <div class="text-left">
                    <div class="flex items-center">
                        <div class="font-medium text-bold">{{ $value['attr_display_name'] }}: {{ $value['value'] }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
