@extends('layouts.app')
@section('maincontent')
    <livewire:front.menus.profilmenu />
    <div class="profile-content">
        <div class="category-container-small  w-full">
            <div class="w-full">

                <div
                    class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="text-lg font-medium mr-auto mt-5">
                        Egyenlegem: {{ $user_points }} pont (1 point = 1 FT)
                    </h2>
                </div>
            </div>
        </div>
        <div class="mt-3">
            @if (\Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Hiba!</strong> {{ \Session::get('error') }}
                </div>
            @endif
        </div>
        {{-- check if UserInfo has invoice data --}}
        @php
            $invoicedata = \App\Models\UserInfo::where('user_id', auth()->user()->id)->first();
        @endphp
        @if (
            $invoicedata->invoice_address == null ||
                $invoicedata->invoice_city == null ||
                $invoicedata->invoice_postcode == null ||
                $invoicedata->invoice_country == null)
            <p>A számlázási adatokat ki kell tölteni, mielőtt az egyenleget fel tudod tölteni!</p>
        @else
            <form method="post" action="/stripesubmit" class="row">
                @csrf
                <input type="hidden" name="currency" value="huf">
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <div class="payment-title">
                    <h1>Fizetési információk</h1>
                    <h3>A kártyás tranzakciókhoz a Stripe biztonságos fizetést használjuk.</h3>
                    <p>NEM tárolunk semmilyen kártyainformációt!</p>
                </div>
                <div class="form-container">
                    <div class="field-container">
                        <label for="amount">Pontok mennyisége - 1 pont = 1 Ft (minimum mennyiség:
                            {{ $sitesettings->min_points }})</label>
                        <input id="amount" name="amount" type="number" min="{{ $sitesettings->min_points }}"
                            value="{{ $sitesettings->min_points }}" inputmode="numeric" required>
                    </div>
                </div>

                <input type="submit" id="card-button" value="FIZETÉS"
                    class="btn btn-primary flex items-center delete-button">
            </form>
        @endif
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    </div>
@endsection
