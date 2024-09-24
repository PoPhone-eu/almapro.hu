<div class="intro-y box p-5 mt-5">
    <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
        <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                icon-name="chevron-down" data-lucide="chevron-down" class="lucide lucide-chevron-down w-4 h-4 mr-2">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg> Termék adatai
        </div>
    </div>

    <div class="mt-5">

        <div class="mt-5">
            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                <div class="form-label xl:w-64 xl:!mr-10">
                    <div class="text-left">
                        <div class="flex items-center">
                            <div class="font-medium">Termék megnevezése</div>
                            <div
                                class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                                Kötelező</div>
                        </div>
                        <div class="leading-relaxed text-slate-500 text-xs mt-3"> Min. 25 karakter,
                            amely a termék típusát, márkáját és az olyan információkat tartalmazza, mint a szín, az
                            anyag vagy a típus.
                        </div>
                    </div>
                </div>
                <div class="w-full mt-3 xl:mt-0 flex-1">
                    {{ $product->name }}
                    <div class="form-help text-right"></div>
                </div>
            </div>

            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                <div class="form-label xl:w-64 xl:!mr-10">
                    <div class="text-left">
                        <div class="flex items-center">
                            <div class="font-medium">Termék ára</div>
                        </div>
                    </div>
                </div>
                <div class="w-full mt-3 xl:mt-0 flex-1">
                    {{ $product->price }} forint
                    <div class="form-help text-right"></div>
                </div>
            </div>

            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                <div class="form-label xl:w-64 xl:!mr-10">
                    <div class="text-left">
                        <div class="flex items-center">
                            <div class="font-medium">Akkumulátor</div>
                        </div>
                    </div>
                </div>
                <div class="w-full mt-3 xl:mt-0 flex-1">
                    {{ $product->battery == null ? 'N/A' : $product->battery . ' %' }}
                    <div class="form-help text-right"></div>
                </div>
            </div>

            @if ($product->deleted_at == null)
                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                    <div class="form-label xl:w-64 xl:!mr-10">
                        <div class="text-left">
                            <div class="flex items-center">
                                <div class="font-medium">Státusz</div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-3 xl:mt-0 flex-1">
                        {{ $product->is_sold == null ? 'Nincs eladva' : 'Eladva' }}
                        @if ($product->is_sold != null)
                            <br> <small>{{ \Carbon\Carbon::parse($product->is_sold)->format('Y-m-d') }}</small>
                        @endif
                        <div class="form-help text-right"></div>
                    </div>
                </div>
            @else
                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                    <div class="form-label xl:w-64 xl:!mr-10">
                        <div class="text-left">
                            <div class="flex items-center">
                                <div class="font-medium">Státusz</div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-3 xl:mt-0 flex-1">
                        Törölve - {{ \Carbon\Carbon::parse($product->deleted_at)->format('Y-m-d') }}
                        <div class="form-help text-right"></div>
                    </div>
                </div>
            @endif

            @if (isset($product->data['attributes']) && $product->data['attributes'] != null)
                <div class=" mt-5">
                    @foreach ($product->data['attributes'] as $key => $value)
                        <div wire:key="attr-{{ $key }}"
                            class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                            <div class="form-label xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">{{ $value['attr_display_name'] }}</div>
                                        <div
                                            class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full mt-3 xl:mt-0 flex-1">
                                {{ $value['value'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class=" mt-5">
                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                    <div class="form-label xl:w-64 xl:!mr-10">
                        <div class="text-left">
                            <div class="flex items-center">
                                <div class="font-medium">Termékleírás</div>
                                <div
                                    class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                                </div>
                            </div>
                            <div class="leading-relaxed text-slate-500 text-xs mt-3">
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-3 xl:mt-0 flex-1">
                        <div class="editor">
                            {!! $product->description !!}
                        </div>
                        <div class="form-help text-right"></div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>
