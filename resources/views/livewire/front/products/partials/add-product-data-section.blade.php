<div class="intro-y box p-5">
    <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
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

            <div class="form-inline items-start flex-col xl:flex-row new-product-card">
                <div class="form-label w-full xl:w-64 xl:!mr-10">
                    <div class="text-left">
                        <div class="flex items-center">
                            <div class="font-medium text-bold">További képek</div>
                            <div
                                class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                                Opcionális</div>
                        </div>
                        <div class="leading-relaxed text-slate-500 text-xs mt-3">
                            <div>A képek formátuma .jpg .jpeg .png.</div>
                            <div class="mt-2">Válassz olyan termékfotókat, melyek vonzóbbá teszik a terméket a
                                vásárlók
                                számára.</div>
                        </div>
                    </div>
                </div>
                <div class="w-full mt-3 xl:mt-0 flex-1 border-2 border-dashed dark:border-darkmode-400 rounded-md pt-4">
                    <input type="file" wire:model="photos" style="margin-bottom: 10px;"
                        {{ $mainimage == null ? 'disabled' : '' }}>
                    {{ $mainimage == null ? 'Adj hozzá egy kiemelt képet...' : '' }}
                    @error('photos')
                        <span class="error">{{ $message }}</span>
                    @enderror
                    <div class="grid grid-cols-10 gap-5 pl-4 pr-5">
                        @if ($photos)
                            @foreach ($photos as $key => $value)
                                <div class="col-span-5 md:col-span-2 h-28 image-fit cursor-pointer relative p-5">


                                    <img class="rounded-md w-24 h-24 m-4" src="{{ $value->temporaryUrl() }}">
                                    <div
                                        class="w-5 h-5 flex items-center justify-center absolute rounded-full text-red-600 bg-danger left-0 top-0 -mr-2 -mt-2  cursor-pointer">
                                        <svg wire:click="deletePhoto('{{ $key }}')"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" icon-name="x"
                                            data-lucide="x" class="lucide lucide-x w-4 h-4">
                                            <line x1="18" y1="6" x2="6" y2="18">
                                            </line>
                                            <line x1="6" y1="6" x2="18" y2="18">
                                            </line>
                                        </svg>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="px-4 pb-4 mt-5 flex items-center justify-center cursor-pointer relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" icon-name="image" data-lucide="image"
                            class="lucide lucide-image w-4 h-4 mr-2">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2">
                            </rect>
                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                            <polyline points="21 15 16 10 5 21"></polyline>
                        </svg> <span class="text-primary mr-1">Maximum méret/kép:</span> 3Mb
                        <input id="horizontal-form-1" type="file"
                            class="w-full h-full top-0 left-0 absolute opacity-0">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="intro-y box p-5 mt-5">
    <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
        <div
            class="font-medium text-bold text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                icon-name="chevron-down" data-lucide="chevron-down" class="lucide lucide-chevron-down w-4 h-4 mr-2">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg> Termék adatai
        </div>
    </div>

    <div class="mt-5">
        <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
            <div class="form-label xl:w-64 xl:!mr-10">
                <div class="text-left">
                    <div class="flex items-center">
                        <div class="font-medium text-bold">Termék megnevezése</div>
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
                @error('product_name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="w-full mt-3 xl:mt-0 flex-1">

                <input wire:model.live="product_name" id="product_name" type="text" class="form-control"
                    placeholder="Termék megnevezése" required>
                <div class="form-help text-right">Karakterszám {{ $product_name_lenght }}/{{ $max_char }}
                </div>
            </div>
        </div>

        <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
            <div class="form-label xl:w-64 xl:!mr-10">
                <div class="text-left">
                    <div class="flex items-center">
                        <div class="font-medium text-bold">Eladási ár (bruttó forint)</div>
                        <div
                            class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                            Kötelező</div>
                    </div>
                </div>
            </div>
            <div class="w-full mt-3 xl:mt-0 flex-1">
                @error('price')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="w-full mt-3 xl:mt-0 flex-1">

                <input wire:model.live="price" id="price" type="number" placeholder="Eladási ár"
                    class="form-control">
            </div>
        </div>

        <div class="product-loop-grid">
            @include('livewire.front.products.partials.add-product-type-loop')
        </div>

    </div>
</div>
