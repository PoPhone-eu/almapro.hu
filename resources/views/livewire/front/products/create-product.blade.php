<div class="w-full">
    <div class="new-product-name">
        <p>
            Új hírdetés feladása
        </p>
        <label><strong>Termékkategória: {{ \App\Models\Product::TYPES[$attr_type] }}
                @if ($attr_type != 'Samsung' || $attr_type != 'Android' || $attr_type != 'egyeb')
                    ->
                    {{ \App\Models\Category::find($category_id)?->category_name }} ->
                    {{ \App\Models\Category::find($subcategory_id)?->category_name }}
                @endif
            </strong></label>
    </div>

    <form wire:submit="submit">
        @if (auth()->user()->is_owner == true)
            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                <div class="form-label xl:w-64 xl:!mr-10">
                    <div class="text-left">
                        <div class="flex items-center">
                            <div class="font-medium text-bold">Termék url</div>
                            <div
                                class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                            </div>
                        </div>
                        <div class="leading-relaxed text-slate-500 text-xs mt-3">
                        </div>
                    </div>
                </div>
                <div class="w-full mt-3 xl:mt-0 flex-1">
                    @error('url')
                        <span class="error">{{ $message }}</span>
                    @enderror
                    @if ($url_error != null)
                        <span class="error">{{ $url_error }}</span>
                    @endif
                </div>
                <div class="w-full mt-3 xl:mt-0 flex-1">

                    <input wire:model.blur="url" id="url" type="text" class="form-control w-full user-input"
                        placeholder="Termék url">
                </div>
            </div>
        @endif

        <div class="new-product-card">
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

                <input wire:model.live="product_name" id="product_name" type="text"
                    class="form-control w-full user-input" placeholder="Termék megnevezése" required>
                <div class="form-help text-right">Karakterszám {{ $product_name_lenght }}/{{ $max_char }}
                </div>
            </div>
        </div>

        <div class="new-product-card">
            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                <div class="form-label xl:w-64 xl:!mr-10">
                    <div class="text-left">
                        <div class="flex items-center">
                            <div class="font-medium text-bold">Hirdetési ár</div>
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

                    <input wire:model.live="price" id="price" type="number" placeholder="Hirdetési ár"
                        class="form-control user-input" style="width: 250px;">
                </div>
            </div>
        </div>

        @if ($attr_type != 'egyeb' || $attr_type != 'Others')
            <div class="new-product-card">
                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                    <div class="form-label xl:w-64 xl:!mr-10">
                        <div class="text-left">
                            <div class="flex items-center">
                                <div class="font-medium text-bold">Akkumulátor (%)</div>
                                <div
                                    class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                                    Kötelező</div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-3 xl:mt-0 flex-1">
                        @error('battery')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full mt-3 xl:mt-0 flex-1">

                        <input wire:model.blur="battery" id="battery" type="number" step="1" min="0"
                            max="100" class="form-control user-input" style="width: 250px;" required
                            oninput="validateInput(this)">
                    </div>
                </div>
            </div>
        @endif


        <div class="new-product-card">
            <div class="product-loop-grid">
                @include('livewire.front.products.partials.add-product-type-loop')
            </div>
        </div>

        <div class="new-product-card">
            @include('livewire.front.products.partials.add-product-editor')
        </div>

        @if ($shops->count() > 0)
            <div class="new-product-card text-left">
                <label class="text-bold">Boltok, ahol a termék megtekinthető. Opcionális.</label>
                @foreach ($shops as $shop)
                    <div class="form-check mt-2">
                        <input id="checkbox-switch-1" class="form-check-input" type="checkbox"
                            wire:model.live="productshops" value="{{ $shop->id }}">
                        <label class="form-check-label" for="checkbox-switch-1">{{ $shop->shop_name }}</label>
                    </div>
                @endforeach

            </div>
        @endif

        <div class="product-data-grid">
            <div class="new-product-card">
                <label class="text-bold">Szállítási opciók</label>
                <div class="text-xs text-slate-500">Legalább az egyik kötelező</div>
                <div class="w-full mt-3 xl:mt-0 flex-1">
                    <input wire:model.live="local_pickup" value="1" id="local_pickup" type="checkbox"
                        class="form-check-input">
                    <label class="form-check-label" for="local_pickup">helyszínen átvehető</label>
                </div>
                <div class="w-full mt-3 xl:mt-0 flex-1">
                    <input wire:model.live="delivery" value="1" id="delivery" type="checkbox"
                        class="form-check-input">
                    <label class="form-check-label" for="delivery">postai kiküldés</label>
                    <input wire:model.live="delivery_price" id="delivery_price" type="number"
                        class="form-control user-input"
                        style="width: 190px;border: 1px solid green; margin-left: 8px;"
                        placeholder="Szállítás költsége FT">
                </div>
                <div class="w-full mt-3 xl:mt-0 flex-1">
                    @error('delivery_price')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>


            </div>

            <div class="new-product-card">
                <label class="text-bold">Kiemelt kép</label>
                <div class="text-xs text-slate-500">Kötelező. A kép formátuma .jpg .jpeg .png.</div>
                <div class="form-inline items-start flex-col xl:flex-row">
                    <div class="form-label w-full xl:w-64 xl:!mr-10">
                        <div class="text-left">
                            <div class="text-slate-500 text-xs">
                                <div class="mt-2">Válassz olyan termékfotót, ami vonzóbbá teszi a terméket a
                                    vásárlók
                                    számára.</div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="w-full mt-3 xl:mt-0 flex-1 border-2 border-dashed dark:border-darkmode-400 rounded-md pt-4">
                        <div class="grid grid-cols-10 gap-5 pl-4 pr-5">
                            <div class="col-span-5 md:col-span-2 h-28 image-fit cursor-pointer relative p-5">
                                @if ($mainimage && str_contains($mainimage->getMimeType(), 'image') !== false)
                                    <img class="rounded-md w-24 h-24 m-4" src="{{ $mainimage->temporaryUrl() }}">
                                    <div
                                        class="w-5 h-5 flex items-center justify-center absolute rounded-full text-red-600 bg-danger left-0 top-0 -mr-2 -mt-2">
                                        <svg wire:click="clearMainimage" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" icon-name="x" data-lucide="x"
                                            class="lucide lucide-x w-4 h-4">
                                            <line x1="18" y1="6" x2="6" y2="18">
                                            </line>
                                            <line x1="6" y1="6" x2="18" y2="18">
                                            </line>
                                        </svg>
                                    </div>
                                @endif
                                <input type="file" wire:model.live="mainimage" style="margin: 5px;" required>
                                @error('mainimage')
                                    <span class="error">{{ $message }}</span>
                                @enderror

                                @if ($mainimage == null)
                                    <br><span class="error">Kiemelt képet kötelező megadni</span>
                                @endif
                            </div>

                        </div>
                        <div class="px-4 pb-4 mt-5 flex items-center justify-center cursor-pointer relative"
                            style="margin-top:40px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" icon-name="image" data-lucide="image"
                                class="lucide lucide-image w-4 h-4 mr-2">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2">
                                </rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg> <span class="text-primary mr-1">Maximum méret:</span> 3Mb
                            <input id="horizontal-form-1" type="file"
                                class="w-full h-full top-0 left-0 absolute opacity-0">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="new-product-card">
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
                    {{ $mainimage == null ? 'disabled' : '' }}> <br>
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

        <div class="new-product-card mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2 ">
                <button class="save-button w-full" type="submit" id="submit">Mentés</button>
            </div>
        </div>


        <div class="w-full mt-3 xl:mt-0 flex-1">
            @error('delivery_price')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="w-full mt-3 xl:mt-0 flex-1">
            @error('mainimage')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="w-full mt-3 xl:mt-0 flex-1">
            @error('photos')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="w-full mt-3 xl:mt-0 flex-1">
            @error('product_name')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
    </form>

    <script>
        // Prevent input of anything but digits (no decimals or letters)
        function isInteger(event) {
            const charCode = event.which ? event.which : event.keyCode;

            // Allow backspace, delete, arrow keys
            if (charCode === 8 || charCode === 46 || charCode >= 37 && charCode <= 40) {
                return true;
            }

            // Prevent if not a digit (charCode for 0-9 is 48-57)
            if (charCode < 48 || charCode > 57) {
                return false;
            }

            return true;
        }

        function validateInput(input) {
            // Remove any decimal points (if somehow entered)
            if (input.value.includes('.')) {
                input.value = input.value.split('.')[0];
            }

            // Prevent entering numbers longer than 3 digits
            if (input.value.length > 3) {
                input.value = input.value.slice(0, 3);
            }

            // Prevent value larger than 100
            if (input.value > 100) {
                input.value = 100;
            }

            // Ensure value is not negative (min is already set to 0)
            if (input.value < 0) {
                input.value = 0;
            }
        }
    </script>
</div>