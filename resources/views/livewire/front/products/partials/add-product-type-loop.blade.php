@foreach ($productattributes as $item)
    <div wire:key="productattributes-{{ $item->id }}" class="form-inline flex-col xl:flex-row mt-5 pt-5">
        <div class="form-label xl:w-64 xl:!mr-10">
            <div class="text-left">
                <div class="flex items-center">
                    <div class="font-medium text-bold">{{ $item->attr_display_name }}</div>
                    <div
                        class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                        Kötelező</div>
                </div>
            </div>
        </div>
        <div class="w-full mt-3 xl:mt-0 flex-1">
            <select x-data="{ value: 0 }" x-model="value" x-on:change="$wire.setThisData(value)"
                class="form-select user-input" style="width: 300px;" required>
                <option onclick="removeThisData('{{ $item->id }}')" {{-- wire:click.live="removeThisData({{ $item->id }})" --}} value="">
                    Válassz...
                </option>
                @foreach ($item->values as $itemvalue)
                    <option wire:key="itemvalue-{{ $itemvalue->id }}"
                        wire:click.live="setThisData({{ $itemvalue->id }})" value="{{ $itemvalue->id }}">
                        {{ $itemvalue->value }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
@endforeach
<script>
    function removeThisData(attr_id) {
        Livewire.dispatch('removeThisData', {
            attr_id: attr_id
        });
    }
</script>
