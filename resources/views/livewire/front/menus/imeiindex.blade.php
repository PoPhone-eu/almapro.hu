<div class="w-1/2">
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
        <h2 class="imei-title mt-5">
            Telefon adatainak lekérdezése IMEI szám alapján.
        </h2>
    </div>

    <div class="flex flex-col sm:flex-row items-center p-2 border-b border-slate-200/60 dark:border-darkmode-400">
        <h2 class="mt-5">
            <strong>
                A lekérdezés {{ $imei_price }} pontban kerül. <br> Egyenleged: {{ $user_points }} pont.
            </strong>
        </h2>
    </div>

    <div class="flex flex-col sm:flex-row items-center p-2 border-b border-slate-200/60 dark:border-darkmode-400">
        <h2 class="text-lg font-medium mr-auto mt-1 mb-5">
            Ilyen szolgáltatást máshol nem találsz!
            Mielőtt vásárolsz le tudod ellenőrizni, hogy a készülék nem-e lopott,
            korlátozott vagy egyéb nem tetsző dolog van -e esetleg vele. <br>Így a
            vásárlásod teljesen biztonságos lesz.
            Nem kell mást tenned csak a megvásárolandó készüléknek kérd el az Imei
            számát. És ezen a felületen csekkold le. <br> A szolgáltatás első
            regisztráció után automatikusan feltöltődik 1000 egység kredittel melyet
            akár erre is felhasználhatsz
        </h2>
    </div>

    <div class="w-1/2" style="display: flex;justify-content: space-around;">
        <h3> <strong>IPhone vagy Samsung? Kérlek válassz:</strong></h3>
        <div class="{{ $IPhone_border }}"
            style="display: flex;flex-direction:column;justify-content: center;cursor: pointer;"
            wire:click="changePhoneType('iPhone')">
            <div> <img src="{{ asset('img/iphone-menu-icon3.png') }}" alt="iPhone" width="120"></div>

            <p style="margin: 0 auto">IPhone</p>

        </div>

        <div class="{{ $Samsung_border }}"
            style="display: flex;flex-direction:column;justify-content: center;cursor: pointer;"
            wire:click="changePhoneType('samsung')">
            <div> <img src="{{ asset('img/samsung.png') }}?rnd=1" alt="Samsung" width="128"></div>
            <p style="margin: 0 auto">Samsung</p>
        </div>
    </div>

    <div class="w-1/2">
        <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <label class="red"><strong>Kérlek írd ide az IMEI számot:*</strong></label>
            <input wire:model.live="imei_number" type="text" autocomplete="off" class="user-input w-full"
                placeholder="{{ $this->phone_type == 'iPhone' ? 'IPhone azonosítója' : 'Samsung telefon azonosítója' }}">
        </div>
        <div>
            <button type="button" wire:click="save" class="save-button">Lekérdezés</button>
        </div>
        <div wire:loading wire:target="save">
            Adatok lekérdezése folyamatban. Ez néhány másodpercig is eltarthat, kérlek legyél türelemmel...
        </div>
    </div>


    <div>
        <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4 w-full">
            @if ($api_result_array != null)
                <div style="display: flex;flex-direction:column;">
                    @foreach ($api_result_array as $key => $value)
                        <div style="display: flex;flex-direction:row;">
                            <div style="width:50%"><strong>{{ $key }}:</strong>
                            </div>
                            <div>{{ $value }}</div>
                        </div>
                    @endforeach
                    <br>
                    <br>
                    <br>
                    <p class="account-title"> Új egyenleged: {{ $user_points }} pont.</p>
                </div>
            @endif
            @if ($api_result_error != null)
                <label class="font-medium text-gray-800">Hibaüzenet:</label>
                <span>{{ $api_result_error }}</span>
            @endif
        </div>
    </div>
</div>
