<div class="w-full">
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
        <a @click="$dispatch('open-attr-modal-this')" class="save-button">Hirdetés feladása</a>
        <a href="/payment"{{--  wire:navigate --}} class="save-button">Egyenleg feltöltése (Egyenlegem:
            {{ getUserPoints(auth()->user()->id) }})</a>
    </div>

    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
        <h2 class="text-lg font-medium mr-auto mt-5">
            Hírdetett termékeim listája
        </h2>
    </div>
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center m-4">
        <div class="w-full  m-4">
            <input wire:model.live="search" type="text" class="product-search-input"
                placeholder="Keresés a termékek között név alapján...">
        </div>
    </div>
    <table class="w-full table table-report -mt-2">
        <thead>
            <tr>
                <th class="text-left whitespace-nowrap">KÉP</th>
                <th class="text-left whitespace-nowrap">TERMÉK NEVE</th>
                {{--   <th class="text-left whitespace-nowrap">JELLEMZŐK</th> --}}
                <th class="text-left whitespace-nowrap">
                    {{ auth()->user()->role == 'company' ? 'BOLTOK' : 'FELTÖLTVE' }}
                </th>
                <th class="text-left whitespace-nowrap">ÁR</th>
                <th class="text-center whitespace-nowrap"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $item)
                <tr class="intro-x">
                    <td class="w-40 h-10">

                        @if (isset($item->data['gallery']))
                            <div class="w-8 image-fit">
                                <a href="{{ $item->getMedia('gallery')->first()?->getUrl() }}"
                                    data-lightbox="{{ $item->name }}" data-title="{{ $item->name }}"> <img
                                        src="{{ $item->getMedia('gallery')->first()?->getUrl() }}"> </a>
                            </div>
                        @endisset

                </td>
                <td>
                    <label class="font-medium whitespace-nowrap">{{ $item->name }}
                        @if ($item->is_featured == true)
                            <span style="color:red;"><b>(KIEMELVE)</b></span>
                        @endif
                    </label>
                    <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">
                        {{ \App\Models\Product::TYPES[$item->type] }}</div>
                </td>
                {{--  <td class="text-left">
                    @foreach ($item->data['attributes'] as $key => $value)
                        @if (isset($value['attr_display_name']))
                            {{ $value['attr_display_name'] }}: {{ $value['value'] }} <br>
                        @endif
                    @endforeach
                </td> --}}
                @if ($item->shops->count() > 0)
                    <td class="text-left">
                        @foreach ($item->shops as $shop)
                            {{ $shop->shop_name }} <br>
                        @endforeach
                    </td>
                @else
                    <td class="text-left">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                    </td>
                @endif

                <td class="text-left">
                    {{ number_format($item->price) }} Ft
                </td>
                <td class="table-report__action w-56">
                    <div class="flex justify-center items-center">
                        @if ($item->is_sold == false)
                            <a class="flex items-center delete-button" href="javascript:;"
                                wire:confirm="Biztos, hogy kiemeled? \n A kiemelés/újra kiemelés pontokba kerül!"
                                wire:click="makeFeatured('{{ $item->slug }}')">
                                Kiemelés </a>
                            <a class="flex items-center mr-3 edit-button"
                                href="{{ route('myproducts.edit', $item->slug) }}" wire:navigate>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" icon-name="check-square"
                                    color="orange" data-lucide="check-square"
                                    class="lucide lucide-check-square w-4 h-4 mr-1">
                                    <polyline points="9 11 12 14 22 4"></polyline>
                                    <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path>
                                </svg> Módosít </a>
                        @else
                            <span class="flex items-center"> <strong>ELADVA</strong></span>
                        @endif
                        <a class="flex items-center delete-button" href="javascript:;"
                            wire:confirm.prompt="Biztos, hogy törölni akarod? \n A megerősítéshez írd be hogy CONFIRM és nyomj egy entert.|CONFIRM"
                            wire:click="deleteProduct('{{ $item->slug }}')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" icon-name="trash-2" color="red"
                                data-lucide="trash-2" class="lucide lucide-trash-2 w-4 h-4 mr-1">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2">
                                </path>
                                <line x1="10" y1="11" x2="10" y2="17">
                                </line>
                                <line x1="14" y1="11" x2="14" y2="17">
                                </line>
                            </svg> Töröl </a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
    <!-- BEGIN: Pagination -->
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center"
        style="margin-bottom: 8px;">
        <div class="col mt-3">
            {{ $products->links() }}
        </div>
        <!-- END: Pagination -->
    </div>
    <!-- END: Pagination -->
</table>


<x-admin-user-modal title="{{ $modal_title }}" name="admin-modal">
    <x-slot:body>
        <form wire:submit="save">

            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 flex flex-col">
                <label
                    class="text-red-600">{{ isset($error_msg['attr_name']) ? $error_msg['attr_name'] : '' }}</label>
                <br>

                <label class="font-medium text-gray-800">Terméktípus*:</label>
                <select wire:model.live="attr_type">
                    <option value="">Válassz...</option>
                    @foreach ($termektipus as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>


                <label
                    class="font-medium {{ $attr_type == 'Samsung' || $attr_type == 'Android' || $attr_type == 'egyeb' ? 'text-gray-400' : 'text-gray-800' }}">Termékkategória*:</label>
                <select wire:model.live="category_id"
                    class="{{ $attr_type == 'Samsung' || $attr_type == 'Android' || $attr_type == 'egyeb' ? 'text-gray-400' : 'text-gray-800' }}"
                    {{ $attr_type == null || $attr_type == 'Samsung' || $attr_type == 'Android' || $attr_type == 'egyeb' ? 'disabled' : '' }}>
                    <option value="">Válassz...</option>
                    @foreach ($categories as $key => $value)
                        <option value="{{ $value->id }}">{{ $value->category_name }}</option>
                    @endforeach
                </select>

                <label
                    class="font-medium {{ $attr_type == 'Samsung' || $attr_type == 'Android' || $attr_type == 'egyeb' ? 'text-gray-400' : 'text-gray-800' }}">Termék*:</label>
                <select wire:model.live="subcategory_id"
                    class="{{ $attr_type == 'Samsung' || $attr_type == 'Android' || $attr_type == 'egyeb' ? 'text-gray-400' : 'text-gray-800' }}"
                    {{ $category_id == null || $attr_type == 'Samsung' || $attr_type == 'Android' || $attr_type == 'egyeb' ? 'disabled' : '' }}>
                    <option value="">Válassz...</option>
                    @foreach ($subcategories as $key => $value)
                        <option value="{{ $value->id }}">{{ $value->category_name }}</option>
                    @endforeach
                </select>


            </div>
            <div class="bg-gray-200 px-4 py-3 text-right" style="background: #bb539a">
                <button type="button" wire:click="cancelSubmit"
                    class="rounded-lg px-4 py-2 bg-gray-200 hover:bg-gray-300 duration-300 save-button"><i
                        class="fas fa-times"></i>
                    Mégse</button>
                <button type="submit" @click="$dispatch('submit')"
                    class="rounded-lg px-4 py-2 bg-green-700 text-green-100 hover:bg-green-800 duration-300 save-button"><i
                        class="fas fa-plus"></i>
                    Tovább</button>
            </div>

        </form>

    </x-slot>
</x-admin-user-modal>
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('featuresuccess', (event) => {
            remaining_points = event.remaining_points;
            alert('Kiemelés sikeres! Maradt ' + remaining_points + ' pontod!');
        });
    });
</script>

</div>
