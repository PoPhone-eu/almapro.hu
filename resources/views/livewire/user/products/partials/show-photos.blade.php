<div class="intro-y box p-5">
    <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
        <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                icon-name="chevron-down" data-lucide="chevron-down" class="lucide lucide-chevron-down w-4 h-4 mr-2">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg> Fotó(k) Feltöltése
        </div>
        <div class="mt-5">
            <div class="flex items-center text-slate-500">
                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" icon-name="lightbulb" data-lucide="lightbulb"
                        class="lucide lucide-lightbulb w-5 h-5 text-warning">
                        <line x1="9" y1="18" x2="15" y2="18"></line>
                        <line x1="10" y1="22" x2="14" y2="22"></line>
                        <path
                            d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0018 8 6 6 0 006 8c0 1 .23 2.23 1.5 3.5A4.61 4.61 0 018.91 14">
                        </path>
                    </svg></span>
                <div class="ml-2"> </div>
            </div>
            <div class="form-inline items-start flex-col xl:flex-row mt-10">
                <div class="form-label w-full xl:w-64 xl:!mr-10">
                    <div class="text-left">
                        <div class="flex items-center">
                            <div class="font-medium">Kiemelt kép</div>
                            <div
                                class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="w-full mt-3 xl:mt-0 flex-1 border-2 border-dashed dark:border-darkmode-400 rounded-md pt-4 mb-10">
                    <div class="grid grid-cols-10 gap-5 pl-4 pr-5">
                        <div class="leading-relaxed col-span-10 md:col-span-2 h-28 relative {{-- image-fit --}}">
                            <img data-action="zoom" class="rounded-md h-28"
                                src="{{ $product->getMedia('mainimage')->first()?->getUrl() }}">
                        </div>

                    </div>
                </div>
            </div>

            @if (isset($product->data['gallery']))
                <div class="form-inline items-start flex-col xl:flex-row mt-10">
                    <div class="form-label w-full xl:w-64 xl:!mr-10">
                        <div class="text-left">
                            <div class="flex items-center">
                                <div class="font-medium">További képek</div>
                                <div
                                    class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="w-full mt-3 xl:mt-0 flex-1 border-2 border-dashed dark:border-darkmode-400 rounded-md pt-4">
                        <div class="grid grid-cols-10 gap-5 pl-4 pr-5">

                            @foreach ($product->getMedia('gallery') as $key => $value)
                                <div class="col-span-5 md:col-span-2 h-28 relative image-fit">
                                    <img data-action="zoom" class="rounded-md h-28" src="{{ $value->getUrl() }}">
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            @endif


        </div>
    </div>
</div>
