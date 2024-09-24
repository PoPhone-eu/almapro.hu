<div>
    <div>
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="text-lg font-medium mr-auto mt-5">
                Termékek listája ({{ $user->name }} {{ $user->given_name }})
            </h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                <a {{-- href="/addproduct/{{ $user_id }}" wire:navigate role="button" --}} @click="$dispatch('open-attr-modal-this')"
                    class="btn btn-primary shadow-md mr-2">Új termék
                    felvitele</a>
                <div class="dropdown">
                </div>
                <div class="hidden md:block mx-auto text-slate-500"></div>
                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                </div>
            </div>
            <!-- BEGIN: Data List -->
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                <table class="table table-report -mt-2">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">KÉPEK</th>
                            <th class="whitespace-nowrap">TERMÉK NEVE</th>
                            <th class="whitespace-nowrap">JELLEMZŐK</th>
                            <th class="whitespace-nowrap">FELTÖLTVE</th>
                            <th class="whitespace-nowrap">ELADVA</th>
                            <th class="whitespace-nowrap"></th>
                            <th class="text-center whitespace-nowrap">MŰVELETEK</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $item)
                            <tr class="intro-x">
                                <td class="w-40">
                                    <div class="flex">
                                        @if (isset($item->data['gallery']))
                                            @foreach ($item->getMedia('gallery') as $key => $value)
                                                <div class="w-10 h-10 image-fit zoom-in -ml-5">
                                                    <img class="rounded-full" src="{{ $value->getUrl() }}">
                                                </div>
                                            @endforeach
                                        @endisset
                                        @if (isset($item->data['mainimage']))
                                            <div class="w-10 h-10 image-fit zoom-in">
                                                <img class="rounded-full"
                                                    src="{{ $item->getMedia('mainimage')->first()?->getUrl() }}">
                                            </div>
                                        @endisset
                            </div>
                        </td>
                        <td>
                            <label class="font-medium whitespace-nowrap">{{ $item->name }}</label>
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">
                                {{ \App\Models\Product::TYPES[$item->type] }}</div>
                        </td>
                        <td class="text-left">
                            Ár: {{ $item->price }} Ft <br>
                            @foreach ($item->data['attributes'] as $key => $value)
                                @if (isset($value['attr_display_name']))
                                    {{ $value['attr_display_name'] }}: {{ $value['value'] }} <br>
                                @endif
                            @endforeach
                        </td>
                        <td class="text-left">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                        </td>
                        <td class="text-left">
                            {{ $item->is_sold ? 'Eladva' : 'Nincs eladva' }}
                            @if ($item->is_sold == true && $item->sold_at != null)
                                : {{ \Carbon\Carbon::parse($item->sold_at)->format('Y-m-d') }}
                            @endif
                        </td>
                        <td class="text-left">
                            {{ $item->deleted_at != null ? 'Törölt tétel' : 'Aktív' }}
                            @if ($item->deleted_at != null)
                                <br>
                                <small>{{ \Carbon\Carbon::parse($item->deleted_at)->format('Y-m-d') }}</small>
                            @endif
                        </td>
                        <td class="table-report__action w-56">
                            <div class="flex">
                                <a class="flex items-center mr-3" href="/userproduct/{{ $item->slug }}"
                                    wire:navigate> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        icon-name="check-square" data-lucide="check-square"
                                        class="lucide lucide-check-square w-4 h-4 mr-1">
                                        <polyline points="9 11 12 14 22 4"></polyline>
                                        <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path>
                                    </svg> Megnéz </a>
                                <a class="flex items-center text-danger" href="javascript:;"
                                    wire:confirm.prompt="Biztos, hogy törölni akarod? \n A megerősítéshez írd be hogy CONFIRM és nyomj egy entert.|CONFIRM"
                                    wire:click="deleteProduct({{ $item->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        icon-name="trash-2" data-lucide="trash-2"
                                        class="lucide lucide-trash-2 w-4 h-4 mr-1">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path
                                            d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2">
                                        </path>
                                        <line x1="10" y1="11" x2="10" y2="17">
                                        </line>
                                        <line x1="14" y1="11" x2="14" y2="17">
                                        </line>
                                    </svg> Töröl </a>
                                @if ($item->deleted_at != null)
                                    <a class="flex items-center text-danger" href="javascript:;"
                                        wire:confirm="Biztos, hogy visszaállítod?"
                                        wire:click="restoreProduct({{ $item->id }})" tooltip
                                        title="Visszaállítás">
                                        @include('partials.icons.restore') </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- END: Data List -->
    <!-- BEGIN: Pagination -->
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
        <div class="col mt-3">
            {{ $products->links() }}
        </div>

        <div class="col text-right text-muted">
            {{ __('messages.search-results', [
                'firstItem' => $products->firstItem(),
                'lastItem' => $products->lastItem(),
                'total' => $products->total(),
            ]) }}

        </div>

        <!-- END: Pagination -->
    </div>
    <!-- END: Pagination -->
</div>

</div>
<x-admin-user-modal title="{{ $modal_title }}" name="admin-modal">
<x-slot:body>
    <form wire:submit="save">

        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <label
                class="text-red-600">{{ isset($error_msg['attr_name']) ? $error_msg['attr_name'] : '' }}</label>
            <br>

            <label class="font-medium text-gray-800">Terméktípus*:</label>
            <select wire:model.live="attr_type">
                <option value="">Válassz...</option>
                @foreach (\App\Models\Product::ATRR_TYPES as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>

            <div>
                <label class="font-medium text-gray-800">Termékcsoport*:</label>
                <select wire:model.live="category_id">
                    <option value="">Válassz...</option>
                    @foreach ($categories as $key => $value)
                        <option value="{{ $value->id }}">{{ $value->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="font-medium text-gray-800">Termék*:</label>
                <select wire:model.live="subcategory_id">
                    <option value="">Válassz...</option>
                    @foreach ($subcategories as $key => $value)
                        <option value="{{ $value->id }}">{{ $value->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>


        </div>
        <div class="bg-gray-200 px-4 py-3 text-right">
            <button type="button" @click="$dispatch('cancelSubmit')"
                class="btn btn-sm btn-dark py-2 px-4 mr-2 text-white"><i class="fas fa-times"></i>
                Mégse</button>
            <button type="submit" @click="$dispatch('submit')"
                class="btn btn-sm btn-success py-2 px-4 mr-2 text-white"><i class="fas fa-plus"></i>
                Tovább</button>
        </div>
    </form>

</x-slot>
</x-admin-user-modal>
</div>
