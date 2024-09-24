<?php

namespace App\Services;

/**
 * Az ősszes számlázási funkció kezelése
 *
 * SzamlazasService Class
 *
 * @author   Laszlo Katai <kapcsolat@webakademia.online>
 * @link     https://webakademia.online/
 */

use Carbon\Carbon;
use App\Models\Country;
use App\Models\Service;
use App\Models\UserPayment;
use App\Models\PaymentMethod;
use Packages\SzamlaAgent\Log;
// SzamlaAgent
use App\Models\CompanySetting;
use App\Models\CustomerInvoice;
use App\Models\User;
use App\Models\UserInfo;
use Packages\SzamlaAgent\Buyer;
use Packages\SzamlaAgent\Seller;
use Packages\SzamlaAgent\TaxPayer;
use Packages\SzamlaAgent\SzamlaAgentAPI;
use Packages\SzamlaAgent\Item\InvoiceItem;
use Packages\SzamlaAgent\Document\Invoice\Invoice;
use Packages\SzamlaAgent\Document\Invoice\ReverseInvoice;


class SzamlazasService
{
    public static function createInvoice($user_payment_id)
    {
        $user_payment = UserPayment::find($user_payment_id);
        $countryCode            = 'hu';
        $user = User::find($user_payment->user_id);
        $user_info = UserInfo::where('user_id', $user_payment->user_id)->first();

        /**
         * New SzamlaAgent
         *
         * Creating new API connection
         * a létrejött bizonylatot PDF formátumban (1 példányban)
         */
        $api = '97039xbwy2gws4iv7yn4xk8cniuird56tyamat6gy3';
        $agent = SzamlaAgentAPI::create($api, true, Log::LOG_LEVEL_OFF);

        if ($user_info->company_name != null) {
            $customer_name = $user_info->company_name;
        } else {
            $customer_name = $user->full_name;
        }
        /**
         * Creating E-Invoice
         * Currency: HUF, Language: HU, Payment method: credit card
         */
        $invoice = new Invoice(Invoice::INVOICE_TYPE_P_INVOICE);
        // Eladó létrehozása
        $seller = new Seller('MBH', '00000000000000000');
        // Eladó válasz e-mail címe
        $seller->setEmailReplyTo('klp7311@gmail.com');
        // Eladó aláírója
        $seller->setSignatoryName('Katai Laszlo');
        // Eladó e-mail tárgya
        $seller->setEmailSubject('Számla');
        // Eladó e-mail tartalma
        $seller->setEmailContent(null);
        $invoice->setSeller($seller);
        $buyerCountry = $user_info->invoice_country . ' ' . $user_info->invoice_postcode;
        // Vevő létrehozása (név, irányítószám, település, cím)
        $buyer = new Buyer($customer_name, $buyerCountry, $user_info->invoice_city, $user_info->invoice_address);
        // Vevő telefonszáma
        $buyer->setPhone($user_info->company_phone);

        if ($user_info->company_tax_number != null) {
            $tax_number = $user_info->company_tax_number;
        } else {
            $tax_number = null;
        }


        if ($tax_number != null) {
            // Vevő adószáma
            $buyer->setTaxNumber($tax_number);
            $buyer->setTaxPayer(TaxPayer::TAXPAYER_HAS_TAXNUMBER);
        } else {
            $buyer->setTaxPayer(TaxPayer::TAXPAYER_NO_TAXNUMBER);
        }

        //$buyer->setEmail('klp7311@gmail.com');
        $buyer->setEmail($user->email);
        $buyer->setSendEmail(false);

        $invoice->setBuyer($buyer);

        $header = $invoice->getHeader();
        // Számla fizetési módja (bankkártya)
        $header->setPaymentMethod(Invoice::PAYMENT_METHOD_BANKCARD);
        //$header->setPaymentMethod($paymentmethodLang);
        // Számla pénzneme
        $header->setCurrency('HUF');
        // Számla megjegyzés
        // Árfolyam ha nem HUF
        /*  if ($data->currency != 'HUF') {
            $header->setExchangeRate($data->exchange_rate);
            $header->setExchangeBank('MNB');
            if ($country->is_eu == 1 && $data->tax_rate != 0) {
                $header->setEuVat(true);
            }
        } elseif ($country->is_eu == 1 && $data->tax_rate == 0) {
            $header->setEuVat(false);
        } else {
        } */
        // $header->setExchangeRate($data->exchange_rate);
        // Számla nyelve
        $header->setLanguage('hu');
        // Számla kifizetettség (fizetve)
        $header->setFulfillment(Carbon::now()->format('Y-m-d'));

        // Egyedi számlaelőtag használata
        //$header->setPrefix('KOM');

        $header->setPreviewPdf(false);



        // Számla tétel összeállítása alapértelmezett adatokkal
        $itemName = 'Marketing költség';

        // $user_payment->amount is the brutto. Tax is 27%. We need the netto:
        $net_amount = $user_payment->amount / 1.27;


        $unit_price     = round($net_amount, 2);
        $tax = '27';

        // Számla tétel összeállítása egyedi adatokkal
        $item = new InvoiceItem($itemName, $unit_price, 1, 'db', $tax);
        // Tétel nettó értéke
        $NetPrice = $unit_price * 1;

        // Tétel ÁFA értéke
        $VatAmount = $user_payment->amount - $net_amount;

        // Tétel bruttó értéke
        $GrossAmount = $NetPrice + $VatAmount;

        $item->setNetPrice($NetPrice);
        $item->setVatAmount($VatAmount);
        $item->setGrossAmount($GrossAmount);
        // Tétel hozzáadása a számlához
        $invoice->addItem($item);


        // Számla elkészítése
        $result = $agent->generateInvoice($invoice);
        // Agent válasz sikerességének ellenőrzése
        if ($result->isSuccess()) {

            SzamlazasService::getInvoiceAsPdf($result->getDocumentNumber());
            $invoice_number = $result->getDocumentNumber();
            $user_payment->invoice_number = $invoice_number;
            $user_payment->payed_at = Carbon::now()->format('Y-m-d H:i:s');
            $user_payment->update();
            return $invoice_number;
        } else {
            return false;
        }
    }

    public static function getInvoiceData($invoiceNumber)
    {
        $api = '97039xbwy2gws4iv7yn4xk8cniuird56tyamat6gy3';
        $agent = SzamlaAgentAPI::create($api, true, Log::LOG_LEVEL_OFF);
        $result = $agent->getInvoiceData($invoiceNumber);
        $response = $result->getData();
        return $response;
    }

    public static function getInvoiceAsPdf($invoiceNumber)
    {
        $api = '97039xbwy2gws4iv7yn4xk8cniuird56tyamat6gy3';
        $agent = SzamlaAgentAPI::create($api, true, Log::LOG_LEVEL_OFF);
        $result = $agent->getInvoicePdf($invoiceNumber);
        return true;
    }
}
