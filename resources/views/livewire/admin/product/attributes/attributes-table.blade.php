<div>
    <h2 class="text-lg font-medium mr-auto mt-5">
        Termékek tulajdonságai
    </h2>

    <!-- BEGIN: Data List -->
    <div class="grid grid-cols-12 gap-6 mt-5" x-data="{ isOpen: false }">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <button @click="$dispatch('open-attr-modal-this')" class="btn btn-primary shadow-md mr-2">Új tulajdonság
                felvitele</button>
            <button @click="isOpen = !isOpen" @keydown.escape="isOpen = false" class="dropdown-toggle btn px-2 box">
                <span class="w-5 h-5 flex items-center justify-center"> <svg xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus"
                        class="lucide lucide-plus w-4 h-4" data-lucide="plus">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg> </span>
            </button>
            <div x-cloak x-show="isOpen" @click.away="isOpen = false" class="dropdown-menu w-40 show"
                style="margin-top: 50px">
                <ul class="dropdown-content"> Szűrés
                    <li>
                        <a x-on:click="$wire.set('search', '')" class="dropdown-item" href="javascript:;"> - Szűrő
                            törlése </a>
                    </li>
                    @foreach (\App\Models\Product::ATRR_TYPES as $key => $value)
                        <li>
                            <a x-on:click="$wire.set('search', '{{ $value }}')" class="dropdown-item"
                                href="javascript:;"> -
                                {{ $value }} </a>
                        </li>
                    @endforeach

                </ul>
            </div>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <div class="w-56 relative text-slate-500">
                    <input wire:model.live="search" type="text" class="form-control w-56 box pr-10"
                        placeholder="Keresés...">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" icon-name="search"
                        class="lucide lucide-search w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0"
                        data-lucide="search">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>
            </div>

        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">TULAJDONSÁG NEVE</th>
                        <th class="whitespace-nowrap">MEGJELENÍTVE</th>
                        <th class="whitespace-nowrap">TERMÉKKATEGÓRIA</th>
                        <th class="whitespace-nowrap" style="width: 380px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attributes as $item)
                        <tr wire:key="item-{{ $item->id }}" class="intro-x">
                            @php
                                $subcategory = null;
                                $maincategory = null;
                                if ($item->category_id != null) {
                                    $category = \App\Models\Category::find($item->category_id);
                                    if ($category->category_id != null) {
                                        $maincategory = \App\Models\Category::find($category->category_id);
                                        $subcategory = $category;
                                    } else {
                                        $subcategory = $category;
                                    }
                                }
                            @endphp
                            <td>
                                <a href="" class="font-medium whitespace-nowrap">{{ $item->attr_name }}</a>
                            </td>
                            <td class="">{{ $item->attr_display_name }}</td>
                            <td class="">
                                @if ($maincategory != null)
                                    {{ \App\Models\Product::ATRR_TYPES[$item->type] }} ->
                                    {{ $maincategory?->category_name }}
                                    ->
                                    {{ $subcategory?->category_name }}
                                @elseif($subcategory != null)
                                    {{ \App\Models\Product::ATRR_TYPES[$item->type] }} ->
                                    {{ $subcategory?->category_name }}
                                @else
                                    {{ \App\Models\Product::ATRR_TYPES[$item->type] }}
                                @endif
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <a role="button" href="/attrvalues/{{ $item->id }}" wire:navigate
                                        class="btn btn-sm btn-primary flex items-center mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" icon-name="plus"
                                            class="lucide lucide-plus w-4 h-4" data-lucide="plus">
                                            <line x1="12" y1="5" x2="12" y2="19">
                                            </line>
                                            <line x1="5" y1="12" x2="19" y2="12">
                                            </line>
                                        </svg> Értékei </a>
                                    <button class="btn btn-sm btn-success flex items-center mr-3 text-white"
                                        @click="$dispatch('open-attr-modal-edit', { attr_id: {{ $item->id }}} ); setTimeout(() => { setfocus(); }, 50);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            icon-name="check-square" data-lucide="check-square"
                                            class="lucide lucide-check-square w-4 h-4 mr-1">
                                            <polyline points="9 11 12 14 22 4"></polyline>
                                            <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path>
                                        </svg> Szerkeszt </button>

                                    <button class="btn btn-sm btn-danger flex items-center mr-3"
                                        @click=" confirm('Biztos, hogy törlöd') ? @this.deleteAttribute({{ $item->id }}) : false">
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
                                        </svg> Töröl </button>

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
                {{ $attributes->links() }}
            </div>

            <div class="col text-right text-muted">
                {{ __('messages.search-results', [
                    'firstItem' => $attributes->firstItem(),
                    'lastItem' => $attributes->lastItem(),
                    'total' => $attributes->total(),
                ]) }}

            </div>

            <!-- END: Pagination -->
        </div>
        <!-- END: Pagination -->
    </div>

    <x-admin-user-modal title="{{ $modal_title }}" name="admin-modal">
        <x-slot:body>
            <form wire:submit="save">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <label
                        class="text-red-600">{{ isset($error_msg['attr_name']) ? $error_msg['attr_name'] : '' }}</label>
                    @if ($attribute_id == null)
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
                                    <option value="{{ $value->id }}">{{ $value->category_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-5">
                            <label class="font-medium text-gray-800">Termék*:</label>
                            <select wire:model.live="subcategory_id">
                                <option value="">Válassz...</option>
                                @foreach ($subcategories as $key => $value)
                                    <option value="{{ $value->id }}">{{ $value->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <label class="font-medium text-gray-800">Tulajdonság neve*</label>
                    <input wire:model.live="attr_name" type="text" autocomplete="off" autofocus id="attr_name"
                        class="w-full outline-none rounded bg-gray-100 p-2 mt-2 mb-3" required />
                    <label class="font-medium text-gray-800">Megjelenített név*:</label>
                    <input wire:model="attr_display_name" type="text" autocomplete="off"
                        class="w-full outline-none rounded bg-gray-100 p-2 mt-2 mb-3" required />

                </div>
                <div class="bg-gray-200 px-4 py-3 text-right">
                    <button type="button" @click="$dispatch('cancelSubmit')"
                        class="btn btn-sm btn-dark py-2 px-4 mr-2 text-white"><i class="fas fa-times"></i>
                        Mégse</button>
                    <button type="submit" @click="$dispatch('submit')"
                        class="btn btn-sm btn-success py-2 px-4 mr-2 text-white"><i class="fas fa-plus"></i>
                        Mentés</button>
                </div>
            </form>

        </x-slot>
    </x-admin-user-modal>

</div>
