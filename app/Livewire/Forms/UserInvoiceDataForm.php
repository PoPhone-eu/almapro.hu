<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\UserInfo;
use Livewire\Attributes\Rule;

class UserInvoiceDataForm extends Form
{
    #[Rule('required')]
    public $invoice_address;
    #[Rule('required')]
    public $invoice_city;
    #[Rule('required')]
    public $invoice_postcode;
    #[Rule('required')]
    public $invoice_country = 'Magyarország';
    #[Rule('nullable')]
    public $company_tax_number;
    #[Rule('nullable')]
    public $company_name;
    public ?UserInfo $UserInfo;

    public function setInvoiceData(UserInfo $UserInfo)
    {
        $this->UserInfo = $UserInfo;
        $this->invoice_address      = $UserInfo->invoice_address;
        $this->invoice_city         = $UserInfo->invoice_city;
        $this->invoice_postcode     = $UserInfo->invoice_postcode;
        $UserInfo->invoice_country == null ? $this->invoice_country = 'Magyarország' : $this->invoice_country = $UserInfo->invoice_country;
        $this->company_tax_number   = $UserInfo->company_tax_number;
        $this->company_name         = $UserInfo->company_name;
    }

    public function update()
    {
        $this->UserInfo->update([
            'invoice_address'      => $this->invoice_address,
            'invoice_city'         => $this->invoice_city,
            'invoice_postcode'     => $this->invoice_postcode,
            'invoice_country'      => $this->invoice_country,
            'company_tax_number'   => $this->company_tax_number,
            'company_name'         => $this->company_name,
        ]);
        $this->setInvoiceData($this->UserInfo);
    }
}
