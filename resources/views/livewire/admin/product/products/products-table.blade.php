<div>
    <div>
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="text-lg font-medium mr-auto mt-5">
                Termékek listája
            </h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
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
                            <th class="whitespace-nowrap">KÉP</th>
                            <th class="whitespace-nowrap">TERMÉK NEVE</th>
                            <th class="whitespace-nowrap">ELADÓ NEVE</th>
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
                                        {{--  @if (isset($item->data['gallery']))
                                            @foreach ($item->data['gallery'] as $key => $value)
                                                <div class="w-10 h-10 image-fit zoom-in -ml-5">
                                                    <img class="rounded-full" src="/storage/{{ $value }}">
                                                </div>
                                            @endforeach
                                        @endisset --}}
                                        @if (isset($item->data['mainimage']))
                                            <div class="w-10 h-10 image-fit zoom-in">
                                                <img class="rounded-full"
                                                    src="{{ $item->getMedia('mainimage')->first()?->getUrl() }}">
                                            </div>
                                        @endisset
                                </div>
                            </td>
                            <td>
                                <a href="/userproduct/{{ $item->slug }}"
                                    class="font-medium whitespace-nowrap">{{ $item->name }}</a>
                                <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">
                                    {{ \App\Models\Product::TYPES[$item->type] }}</div>
                            </td>
                            <td>
                                <label class="font-medium whitespace-nowrap">{{ $item->user->full_name }}</label>
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
                                        </svg> Törlés </a>
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

</div>
