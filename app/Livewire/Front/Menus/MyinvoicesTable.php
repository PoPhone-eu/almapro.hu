<?php

namespace App\Livewire\Front\Menus;

use Livewire\Component;
use App\Models\UserPayment;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;

class MyinvoicesTable extends Component
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
        return view('livewire.front.menus.myinvoices-table', [
            'invoices' => UserPayment::where('user_id', auth()->user()->id)->where('invoice_number', '!=', null)
                ->when($this->search != '', function ($query) use ($search) {
                    $query->where('invoice_number', $search)
                        ->orWhere('payed_at', $search);
                })
                ->orderBy('payed_at', 'desc')->paginate(20)
        ]);
    }
}
