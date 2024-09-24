<div class="w-full">
    <p style="margin-bottom:20px;color: grey w-full">Ezen az oldalon hozzá tudod adni a boltjaidat, melyeket a hirdetett
        termékekhez
        tudsz kapcsolni.
        Opcionális...
    </p>
    <a wire:click="addshop" class="save-button">Bolt
        hozzáadása</a>
    <div class="shop-grid-4">
        @foreach ($shops as $shop)
            <div class="shop-card">
                <div class="shop-card-item shop-name">{{ $shop->shop_name }}</div>
                <div class="shop-card-item shop-address">{{ $shop->shop_address }}</div>
                <div class="shop-card-item shop-tel">
                    <div class="telefon-icon"><img src="/img/telefon.svg"></div>
                    <div class="telefon-number">{{ $shop->shop_telephone }}</div>
                </div>

                <div class="flex justify-center items-center">
                    <a wire:click="editshop({{ $shop->id }})"
                        class="flex items-center mr-3 edit-button">Szerkeszt</a>
                    <a wire:click="deleteshop({{ $shop->id }})" wire:confirm="Biztos, hogy törlöd?"
                        class="ml-3 flex items-center delete-button">Töröl</a>
                </div>
            </div>
        @endforeach
    </div>

    <x-admin-user-modal title="{{ $modal_title }}" name="admin-modal">
        <x-slot:body>
            <form wire:submit="submit">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <label>Bolt neve:</label>
                    <input type="text" wire:model.blur="shop_name" class="user-input">
                    <br>
                    <label>Bolt címe:</label>
                    <input type="text" wire:model.blur="shop_address" class="user-input">
                    <br>
                    <label>Bolt telefonszáma:</label>
                    <input type="text" wire:model.blur="shop_telephone" class="user-input">
                    <br>

                </div>
                <div class="bg-gray-200 px-4 py-3 text-right" style="background: #bb539a">
                    <button type="button" wire:click="cancelSubmit"
                        class="rounded-lg px-4 py-2 bg-gray-200 hover:bg-gray-300 duration-300 save-button"><i
                            class="fas fa-times"></i>
                        Mégse</button>
                    <button type="submit" @click="$dispatch('submit')"
                        class="rounded-lg px-4 py-2 bg-green-700 text-green-100 hover:bg-green-800 duration-300 save-button"><i
                            class="fas fa-plus"></i>
                        Mentés</button>
                </div>
            </form>
        </x-slot>
    </x-admin-user-modal>
</div>
