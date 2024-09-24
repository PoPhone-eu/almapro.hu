<div>
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
        <h2 class="text-lg font-medium mr-auto mt-5">
            '{{ $attribute->attr_name }}' értékei
        </h2>
        <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
            <a class="btn btn-sm btn-primary-soft mr-1 mb-2" href="/attributes">
                @include('partials.icons.back-icon')</a>
        </div>
    </div>
    <!-- BEGIN: Data List -->
    <div class="grid grid-cols-12 gap-6 mt-5" x-data="{ isOpen: false }">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <button @click="$dispatch('open-value-modal-this'); setTimeout(() => { setfocus(); }, 20);"
                class="btn btn-primary shadow-md mr-2">Új
                érték
                felvitele</button>
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
                        <th class="whitespace-nowrap" style="width: 70px;">#</th>
                        <th class="whitespace-nowrap">ÉRTÉK/MEGNEVEZÉS</th>
                        <th class="whitespace-nowrap">#RGB</th>
                        <th class="whitespace-nowrap" style="width: 380px;"></th>
                    </tr>
                </thead>
                <tbody wire:sortable="updateOrder" wire:sortable.options="{ animation: 100 }">
                    @foreach ($attr_values as $item)
                        <tr wire:key="item-{{ $item->id }}" class="intro-x" wire:sortable.item="{{ $item->id }}"
                            data-id="{{ $item->id }}">
                            <td>
                                <div style="width: 60px">
                                    <span class="handle" wire:sortable.handle>
                                        @include('partials.icons.move')
                                    </span>
                                </div>

                            </td>
                            <td>
                                <a href="" class="font-medium whitespace-nowrap">{{ $item->value }}</a>
                            </td>
                            <td class="text-center">{{ $item->rgb }}</td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <button class="btn btn-sm btn-success flex items-center mr-3 text-white"
                                        @click="$dispatch('open-value-modal-edit', { value_id: {{ $item->id }}} ); setTimeout(() => { setfocus(); }, 50);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" icon-name="check-square"
                                            data-lucide="check-square" class="lucide lucide-check-square w-4 h-4 mr-1">
                                            <polyline points="9 11 12 14 22 4"></polyline>
                                            <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path>
                                        </svg> Szerkeszt </button>

                                    <button class="btn btn-sm btn-danger flex items-center mr-3"
                                        @click=" confirm('Biztos, hogy törlöd') ? @this.deleteValue({{ $item->id }}) : false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" icon-name="trash-2"
                                            data-lucide="trash-2" class="lucide lucide-trash-2 w-4 h-4 mr-1">
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
                {{ $attr_values->links() }}
            </div>

            <div class="col text-right text-muted">
                {{ __('messages.search-results', [
                    'firstItem' => $attr_values->firstItem(),
                    'lastItem' => $attr_values->lastItem(),
                    'total' => $attr_values->total(),
                ]) }}

            </div>

            <!-- END: Pagination -->
        </div>
        <!-- END: Pagination -->
    </div>

    <x-admin-user-modal title="{{ $modal_title }}" name="admin-modal">
        <x-slot:body>
            <form wire:submit="submit">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <label
                        class="text-red-600">{{ isset($error_msg['new_value']) ? $error_msg['new_value'] : '' }}</label>
                    <br>
                    <label class="font-medium text-gray-800">Érték/megnevezés*</label>
                    <input wire:model.live="new_value" type="text" autocomplete="off" id="new_value" focus
                        class="w-full outline-none rounded bg-gray-100 p-2 mt-2 mb-3" required />
                    <label class="font-medium text-gray-800">RGB (opcionális):</label>
                    <input wire:model="new_rgb" type="text" autocomplete="off"
                        class="w-full outline-none rounded bg-gray-100 p-2 mt-2 mb-3" />
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

    <script>
        function setfocus() {
            document.getElementById("new_value").focus();
        }
    </script>
</div>
