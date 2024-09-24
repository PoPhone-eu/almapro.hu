<div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="/add-banner" class="btn btn-primary shadow-md mr-2 mt-2" style="width: 180px;">Új
                banner felvitele</a>
            {{-- <div class="hidden md:block mx-auto text-slate-500"></div> --}}
            <div class="w-full mt-3 ">
                <div class="w-full relative text-slate-500"
                    style="border: 1px solid rgb(190, 190, 190); border-radius: 6px;">
                    <input wire:model.live="search" type="text" class="form-control w-full box pr-10"
                        placeholder="Keresés név, email vagy számlaszám alapján...">
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
        <div class="intro-y col-span-12">
            <table class="table table-report -mt-2" style=" z-index: 10;">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">Létrehozva</th>
                        <th class="whitespace-nowrap">Név</th>
                        <th class="whitespace-nowrap">Státus</th>
                        <th class="whitespace-nowrap">Pozíciók</th>
                        <th class="whitespace-nowrap">Fizetve</th>
                        {{--    <th class="whitespace-nowrap">Esélyszám</th> --}}
                        <th class="text-center whitespace-nowrap">Művelet</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($banners as $item)
                        <tr wire:key="item-{{ $item->id }}" class="intro-x">
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                            <td>
                                <span class="font-medium whitespace-nowrap">{{ $item->user->full_name }}</span>
                            </td>
                            <td>
                                <span class="font-medium whitespace-nowrap">
                                    {{ $item->is_active == true ? 'Aktív' : 'Inaktív' }}
                                </span>
                            </td>
                            <td>
                                @foreach ($item->positions as $position)
                                    <p>{{ $position->this_position }} / {{ $position->position_name }}
                                        ({{ $position->chance }}%)
                                    </p>
                                @endforeach
                            </td>
                            <td>{{ number_format($item->amount_payed) }} Ft</td>
                            {{-- <td>{{ $item->chance }} %</td> --}}
                            <td class="table-report__action">
                                <div class="flex justify-center items-center">
                                    {{-- edit button - route: /edit-banner --}}
                                    <a class="flex items-center text-theme-6" href="/edit-banner/{{ $item->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" icon-name="check-square"
                                            data-lucide="check-square" class="lucide lucide-check-square w-4 h-4 mr-1">
                                            <polyline points="9 11 12 14 22 4"></polyline>
                                            <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path>
                                        </svg> Szerkeszt
                                    </a>
                                    {{-- deleteBanner button --}}

                                    <button class="flex items-center text-theme-6 ml-3"
                                        wire:click="deleteBanner({{ $item->id }})"
                                        wire:confirm="Biztos, hogy törlöd?">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" icon-name="trash-2"
                                            data-lucide="trash-2" class="lucide lucide-trash-2 w-4 h-4 mr-1">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path
                                                d="M17.6 6H6.4l-.6 12.9c-.1 1.1.8 2.1 1.9 2.1h10.6c1.1 0 2-1 1.9-2.1L17.6 6z">
                                            </path>
                                            <path
                                                d="M10 11V9c0-1.1.9-2 2-2s2 .9 2 2v2m-4 4v5c0 .6.4 1 1 1h4c.6 0 1-.4 1-1v-5">
                                            </path>
                                        </svg>
                                        Törlés
                                    </button>
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
                {{ $banners->links() }}
            </div>

            <div class="col text-right text-muted">
                {{ __('messages.search-results', [
                    'firstItem' => $banners->firstItem(),
                    'lastItem' => $banners->lastItem(),
                    'total' => $banners->total(),
                ]) }}

            </div>

            <!-- END: Pagination -->
        </div>
    </div>

</div>
