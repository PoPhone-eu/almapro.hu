<div class="category-page-content" style="margin-top:20px;">
    {{--  @if ($products->count() == 0)
        @include('livewire.front.menus.partials.sidebar')
        <div class="category-container-small  w-full">
            <p class="category-grid-name-tag">Nincs találat</p>
        </div>
    @else --}}
    @include('livewire.front.menus.partials.sidebar')

    <div class="category-container-small  w-full">
        @include('livewire.front.menus.partials.featured_products')
        @include('livewire.front.menus.partials.grid-product')
    </div>
    {{-- @endif --}}
    {{-- xxx: {{ $selected_category_id }} --}}
</div>
