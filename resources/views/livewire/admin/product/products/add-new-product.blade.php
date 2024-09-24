<div>
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
        <h2 class="text-lg font-medium mr-auto mt-5">
            Új termék felvitele ({{ $user->name }} {{ $user->given_name }})
        </h2>
        <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
            <a class="btn btn-sm btn-primary-soft mr-1 mb-2" href="/userproducts/{{ $user->id }}" wire:navigate>
                @include('partials.icons.back-icon')</a>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                <div class="form-label xl:w-64 xl:!mr-10">
                    <div class="text-left">
                        <div class="flex items-center">
                            <div class="font-medium">Termékkategória</div>
                            <div
                                class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                            </div>
                        </div>
                        <div class="leading-relaxed text-slate-500 text-xs mt-3">
                            <div></div>

                        </div>
                    </div>
                </div>
                <div class="w-full mt-3 xl:mt-0 flex-1">

                    {{ \App\Models\Product::TYPES[$attr_type] }} ->
                    {{ \App\Models\Category::find($category_id)?->category_name }} ->
                    {{ \App\Models\Category::find($subcategory_id)?->category_name }}
                </div>
            </div>

        </div>
    </div>

    @if ($shops->count() > 0)
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                    <div class="form-label xl:w-64 xl:!mr-10">
                        <div>
                            <label>Boltok, ahol a termék megtekinthető</label>
                            @foreach ($shops as $shop)
                                <div class="form-check mt-2">
                                    <input id="checkbox-switch-1" class="form-check-input" type="checkbox"
                                        wire:model.live="productshops" value="{{ $shop->id }}">
                                    <label class="form-check-label"
                                        for="checkbox-switch-1">{{ $shop->shop_name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="mt-5">
        <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
            <div class="form-label xl:w-64 xl:!mr-10">
                <div class="text-left">
                    <div class="flex items-center">
                        <div class="font-medium">Szállítási opciók</div>
                        <div
                            class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                        </div>
                    </div>
                    <div class="leading-relaxed text-slate-500 text-xs mt-3">Legalább az egyik kötelező
                    </div>
                </div>
            </div>
            <div class="w-full mt-3 xl:mt-0 flex-1">
                <input wire:model.live="local_pickup" id="local_pickup" type="checkbox" class="form-check-input">
                <label class="form-check-label" for="local_pickup">helyszínen átvehető</label>
            </div>
            <div class="w-full mt-3 xl:mt-0 flex-1">
                @error('delivery_price')
                    <span class="error">{{ $message }}</span>
                @enderror
                <input wire:model.live="delivery" id="delivery" type="checkbox" class="form-check-input">
                <label class="form-check-label" for="delivery">postai kiküldés</label>
                <input wire:model.live="delivery_price" id="delivery_price" type="text" class="form-control"
                    style="width: 180px;border: 1px solid green; margin-left: 8px;" placeholder="Szállítás költsége">
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            @include('livewire.admin.product.products.partials.add-product-data-section')
        </div>
    </div>

</div>
