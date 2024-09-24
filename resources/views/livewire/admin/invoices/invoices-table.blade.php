<div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">

            <div class="w-full relative text-slate-500">
                <input wire:model.live="search" type="text" class="form-control w-full box pr-10"
                    placeholder="Keresés a számlák között név, számlaszám, dátum alapján...">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    icon-name="search" class="lucide lucide-search w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0"
                    data-lucide="search">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </div>

        </div>

        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12">
            <table class="table table-report -mt-2" style=" z-index: 10;">
                <thead>
                    <tr>
                        <th class="text-left whitespace-nowrap">SZÁMLASZÁM</th>
                        <th class="text-left whitespace-nowrap">NÉV</th>
                        <th class="text-left whitespace-nowrap">DÁTUM</th>
                        <th class="text-left whitespace-nowrap">FIZETETT ÖSSZEG</th>
                        <th class="text-center whitespace-nowrap"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $item)
                        <tr wire:key="user-{{ $item->id }}" class="intro-x">
                            <td>{{ $item->invoice_number }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->payed_at)->format('Y-m-d') }}</td>
                            <td>{{ $item->amount }} Ft </td>
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
            </table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
            <div class="col mt-3">
                {{ $invoices->links() }}
            </div>

            <div class="col text-right text-muted">
                {{ __('messages.search-results', [
                    'firstItem' => $invoices->firstItem(),
                    'lastItem' => $invoices->lastItem(),
                    'total' => $invoices->total(),
                ]) }}

            </div>

            <!-- END: Pagination -->
        </div>
    </div>
</div>
