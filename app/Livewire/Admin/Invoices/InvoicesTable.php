<?php

namespace App\Livewire\Admin\Invoices;

use Livewire\Component;
use App\Models\UserPayment;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;

#[Layout('layouts.adminapp')]
class InvoicesTable extends Component
{
    use WithPagination;

    public $search = '';

    public function downloadInvoice($invoice_number)
    {
        $invoice = UserPayment::where('invoice_number', $invoice_number)->first();
        $path = storage_path('app/public/invoices/pdf/' . $invoice->invoice_number . '.pdf');
        return response()->download($path);
    }


    public function render()
    {
        $search = $this->search;
        return view(
            'livewire.admin.invoices.invoices-table',
            [
                'invoices' => UserPayment::query()->where('invoice_number', '!=', null)
                    ->when($this->search != '', function ($query) use ($search) {
                        $query->where('invoice_number', $search)
                            ->orWhere('payed_at', $search)
                            ->orWhere('full_name', 'like', '%' . $search . '%');
                    })
                    ->orderBy('payed_at', 'desc')->paginate(30)
            ]
        );
    }
}