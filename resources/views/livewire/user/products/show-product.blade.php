<div>
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
        <h2 class="text-lg font-medium mr-auto mt-5">
            Termék: {{ $product->name }}
        </h2>
        <br>
        <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
            <a class="btn btn-sm btn-primary-soft mr-1 mb-2" href="/userproducts/{{ $user->id }}" wire:navigate>
                @include('partials.icons.back-icon')</a>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row items-center border-b border-slate-200/60 dark:border-darkmode-400">
        <h2 class="text-lg font-medium mr-auto mt-5">
            Eladó neve: {{ $user->name }} {{ $user->given_name }}
        </h2>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-2">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                <div class="form-label xl:w-64 xl:!mr-10">
                    <div class="text-left">
                        <div class="flex items-center">
                            <div class="font-medium">Termékkategória</div>
                        </div>
                    </div>
                </div>
                <div class="w-full mt-3 xl:mt-0 flex-1">

                    {{ \App\Models\Product::TYPES[$product->type] }} ->
                    {{-- {{ \App\Models\Product::TYPES[$attr_type] }} -> --}}
                    {{ \App\Models\Category::find($product->category_id)?->category_name }} ->
                    {{ \App\Models\Category::find($product->subcategory_id)?->category_name }}
                </div>
            </div>

        </div>
    </div>


    @include('livewire/user/products/partials/show-product-data-section')


</div>
