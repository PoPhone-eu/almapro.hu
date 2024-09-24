<div class="w-full ">
    <table class="w-full table table-report -mt-2">
        <thead>
            <tr>
                <th class="text-left whitespace-nowrap">TERMÉK</th>
                <th class="text-left whitespace-nowrap pr-3">MEGRENDELŐ</th>
                <th class="text-left whitespace-nowrap">KAPCSOLAT</th>
                <th class="text-left whitespace-nowrap">ÁR</th>
                <th class="text-center whitespace-nowrap">STÁTUSZ</th>
                <th class="text-left whitespace-nowrap pr-3">
                    DÁTUM
                </th>
                <th class="text-center whitespace-nowrap">MŰVELET</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $item)
                <tr class="intro-x">
                    <td class="w-40 h-10">
                        @php
                            $product = \App\Models\Product::find($item->product_id);
                        @endphp
                        {{--  @if (isset($product->data['mainimage']))
                            <div class="w-8 image-fit">
                                <a href="{{ $product->getMedia('mainimage')->first()?->getUrl() }}"
                                    data-lightbox="{{ $product->name }}" data-title="{{ $product->name }}"> <img
                                        src="{{ $product->getMedia('mainimage')->first()?->getUrl() }}"> </a>
                            </div>
                        @endisset --}}
                        {{ $item->product_name }}
                    </td>
                    <td>
                        <label class="font-medium whitespace-nowrap">
                            {{ $item->customer_name }}
                        </label>
                    </td>
                    <td class="flex flex-col">
                        <label class="font-medium whitespace-nowrap">
                            Email: {{ $item->customer_email }}
                        </label>
                        <label class="font-medium whitespace-nowrap">
                            Telefon: {{ $item->customer_phone == null ? 'Nincs megadva' : $item->customer_phone }}
                        </label>
                    </td>
                    <td class="text-left">
                        @if ($product)
                            {{ number_format($product->price) }} Ft
                        @else
                            Törölt termék
                        @endif
                    </td>
                    <td class="text-center">
                        <label class="status-{{ $item->order_status }}">
                            {{ \App\Models\CustomerOrder::STATUS[$item->order_status] }}</label>
                    </td>
                    <td class="text-left">
                        {{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}
                    </td>
                    <td class="table-report__action w-56">
                        <div class="flex justify-center items-center">

                            @if ($product)
                                <select onchange="changeOrderStatus({{ $item->id }})"
                                    class="form-select flex items-center mr-3 edit-button"
                                    style="text-align-last:center;" id="thisstatus-{{ $item->id }}">
                                    @foreach (\App\Models\CustomerOrder::STATUS as $key => $status)
                                        <option value="{{ $key }}" {{--  wire:click="changeCustomerOrderStatus({{ $item->id }},{{ $key }})" --}}
                                            {{ $item->order_status == $key ? 'selected' : '' }}>
                                            {{ $status }}</option>
                                    @endforeach
                                </select>
                            @else
                                Törölt termék
                            @endif

                            {{--  <a class="flex items-center delete-button" href="javascript:;"
                            wire:confirm="Biztos, hogy törölni akarod?"
                            wire:click="deleteCustomerOrder({{ $item->id }})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" icon-name="trash-2" color="red"
                                data-lucide="trash-2" class="lucide lucide-trash-2 w-4 h-4 mr-1">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2">
                                </path>
                                <line x1="10" y1="11" x2="10" y2="17">
                                </line>
                                <line x1="14" y1="11" x2="14" y2="17">
                                </line>
                            </svg> Töröl </a> --}}
                        </div>
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
    <script>
        function changeOrderStatus(id) {
            var status = document.getElementById('thisstatus-' + id).value;
            Livewire.dispatch('changeCustomerOrderStatus', {
                id: id,
                status: status
            });
        }
    </script>
</div>
