@foreach ($productattributes as $item)
    <div wire:key="productattributesproductattributes-{{ $item->id }}"
        class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
        <div class="form-label xl:w-64 xl:!mr-10">
            <div class="text-left">
                <div class="flex items-center">
                    <div class="font-medium">{{ $item->attr_display_name }}</div>
                    <div
                        class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                        Kötelező</div>
                </div>
            </div>
        </div>
        <div class="w-full mt-3 xl:mt-0 flex-1">
            <select {{--  wire:model="selected_attributes.{{ $item->id }}"  --}} class="form-select" required>
                <option wire:click="removeThisData({{ $item->id }})" value="">Válassz...</option>
                @foreach ($item->values as $itemvalue)
                    <option wire:key="itemvalue-{{ $itemvalue->id }}" wire:click="setThisData({{ $itemvalue->id }})"
                        value="{{ $itemvalue->value }}">
                        {{ $itemvalue->value }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
@endforeach
