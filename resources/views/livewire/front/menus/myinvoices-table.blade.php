<div class="w-full">

    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
        <h2 class="text-lg font-medium mr-auto mt-5">
            Számláim
        </h2>
    </div>
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center m-4">
        <div class="w-full  m-4">
            <input wire:model.live="search" type="text" class="product-search-input"
                placeholder="Keresés a számlák között számlaszám/dátum alapján...">
        </div>
    </div>
    <table class="w-full table table-report -mt-2">
        <thead>
            <tr>
                <th class="text-left whitespace-nowrap">SZÁMLASZÁM</th>
                <th class="text-left whitespace-nowrap">DÁTUM</th>
                <th class="text-left whitespace-nowrap">FIZETETT ÖSSZEG</th>
                <th class="text-center whitespace-nowrap"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $item)
                <tr class="intro-x">
                    <td class="w-40 h-10">{{ $item->invoice_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->payed_at)->format('Y-m-d') }}</td>
                    <td class="text-left">{{ $item->amount }} Ft</td>
                    <td class="table-report__action w-56">
                        <div class="flex justify-center items-center">
                            <a class="flex items-center delete-button" href="javascript:;"
                                wire:click="downloadInvoice('{{ $item->invoice_number }}')">
                                Letölt </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <!-- BEGIN: Pagination -->
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center"
            style="margin-bottom: 8px;">
            <div class="col mt-3">
                {{ $invoices->links() }}
            </div>
            <!-- END: Pagination -->
        </div>
        <!-- END: Pagination -->
    </table>

</div>
