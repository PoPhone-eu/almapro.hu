<div class="w-1/2">
    Fiók adatok:
    <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <form wire:submit="save">
            @if ($useravatar == 'avatar.png' || $useravatar == null)
                <img src="/avatars/avatar.png" class="avatar">
            @else
                <img src="/storage/{{ $useravatar }}" class="avatar">
            @endif
            <label class="font-medium text-gray-800">Profilkép / logo</label>
            <input type="file" wire:model.live="avatar" class="user-input">
            <div>
                @error('dataform.avatar')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            @if ($avatar && str_contains($avatar->getMimeType(), 'image') !== false)
                <div wire:click="clearProfile" class="w-5 h-5 tems-center text-red-600 bg-danger -mr-2 -mt-2">
                    töröl
                </div>
                <img class="rounded-md w-24 h-24 m-4" src="{{ $avatar->temporaryUrl() }}">
            @endif


            <label class="font-medium text-gray-800">Családnév*</label>
            <input wire:model.live="dataform.name" type="text" autocomplete="off" class="user-input">
            <div>
                @error('dataform.name')
                    <span class="error">A családnév megadása kötelező</span>
                @enderror
            </div>

            <label class="font-medium text-gray-800">Keresztnév*:</label>
            <input wire:model.live="dataform.given_name" type="text" autocomplete="off" class="user-input">
            <div>
                @error('dataform.given_name')
                    <span class="error">A keresztnév megadása kötelező</span>
                @enderror
            </div>

            <label class="font-medium text-gray-800">Telefon:</label>
            <input wire:model.live="dataform.phone" type="text" autocomplete="off" class="user-input">
            {{--  <div>
                @error('dataform.email')
                    <span class="error">Érvényes emailcím megadása kötelező</span>
                @enderror
            </div> --}}

            <label class="font-medium text-gray-800">Email*:</label>
            <input wire:model.live="dataform.email" type="text" autocomplete="off" class="user-input">
            <div>
                @error('dataform.email')
                    <span class="error">Érvényes emailcím megadása kötelező</span>
                @enderror
            </div>

            <label class="font-medium text-gray-800">Új jelszó:</label>
            <input wire:model="dataform.newpassword" type="text" autocomplete="off" class="user-input">
            <div>
                @error('dataform.newpassword')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="save-button" onclick="notifySaved()">Frissítés</button>
        </form>
    </div>


    Számlázási adatok:

    <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <form wire:submit="saveInvoiceData">
            <label class="font-medium text-gray-800">Számlázási név/cégnév</label>
            <input wire:model.live="invoicedataform.company_name" type="text" autocomplete="off" class="user-input">
            <div>
                @error('invoicedataform.company_name')
                    <span class="error">A számlázási név/cégnév megadása kötelező</span>
                @enderror
            </div>

            <label class="font-medium text-gray-800">Utca, házszám*</label>
            <input wire:model.live="invoicedataform.invoice_address" type="text" autocomplete="off"
                class="user-input">
            <div>
                @error('invoicedataform.invoice_address')
                    <span class="error">A számlázási cím megadása kötelező</span>
                @enderror
            </div>

            <label class="font-medium text-gray-800">Város*</label>
            <input wire:model.live="invoicedataform.invoice_city" type="text" autocomplete="off" class="user-input">
            <div>
                @error('invoicedataform.invoice_city')
                    <span class="error">A Város megadása kötelező</span>
                @enderror
            </div>

            <label class="font-medium text-gray-800">Irányítószám*</label>
            <input wire:model.live="invoicedataform.invoice_postcode" type="text" autocomplete="off"
                class="user-input">
            <div>
                @error('invoicedataform.invoice_postcode')
                    <span class="error">Az irányítószám megadása kötelező</span>
                @enderror
            </div>

            <label class="font-medium text-gray-800">Ország*</label>
            <input wire:model.live="invoicedataform.invoice_country" type="text" autocomplete="off"
                class="user-input">
            <div>
                @error('invoicedataform.invoice_country')
                    <span class="error">Az ország megadása kötelező</span>
                @enderror
            </div>

            @if (auth()->user()->role != 'private')
                <label class="font-medium text-gray-800">Adószám*</label>
                <input wire:model.live="invoicedataform.company_tax_number" type="text" autocomplete="off"
                    class="user-input">
                <div>
                    @error('invoicedataform.company_tax_number')
                        <span class="error">Az adószám megadása kötelező</span>
                    @enderror
                </div>
            @endif
            <button type="submit" class="save-button" onclick="notifySaved()">Frissítés</button>
        </form>
    </div>

</div>
