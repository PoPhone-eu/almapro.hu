<div class="w-full text-black">
    <table class="w-full table table-report -mt-2">
        <thead>
            <tr>
                <th class="text-left whitespace-nowrap">TERMÉKKÉP</th>
                <th class="text-left whitespace-nowrap pr-3">ELADÓ</th>
                <th class="text-left whitespace-nowrap">ÁR</th>
                <th class="text-center whitespace-nowrap">STÁTUSZ</th>
                <th class="text-left whitespace-nowrap pr-3">
                    DÁTUM
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $item)
                <tr class="intro-x">
                    <td class="w-40 h-10">
                        @php
                            $product = \App\Models\Product::find($item->product_id);
                        @endphp
                        @if (isset($product->data['mainimage']))
                            <div class="w-8 image-fit">
                                <a href="/storage/{{ $product->data['mainimage'] }}"
                                    data-lightbox="{{ $product->name }}" data-title="{{ $product->name }}"> <img
                                        src="/storage/{{ $product->data['mainimage'] }}"> </a>
                            </div>
                        @endisset

                </td>
                <td>
                    <label class="font-medium whitespace-nowrap">
                        {{ $item->seller_name }}
                    </label>
                </td>
                <td class="text-left"> {{ number_format($product->price) }} Ft
                </td>
                <td class="text-center">
                    <label class="status-{{ $item->order_status }}">
                        {{ \App\Models\CustomerOrder::STATUS[$item->order_status] }}</label>
                </td>
                <td class="text-left">
                    {{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}
                </td>
            </tr>
        @endforeach
    </tbody>
    <!-- BEGIN: Pagination -->
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center"
        style="margin-bottom: 8px;">
        <div class="col mt-3">
            {{ $orders->links() }}
        </div>
        <!-- END: Pagination -->
    </div>
</table>
</div>
