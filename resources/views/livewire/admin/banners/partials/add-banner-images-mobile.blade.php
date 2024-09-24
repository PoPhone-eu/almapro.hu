<div class="mt-5">
    <div class="form-inline">
        <label for="mobile_image" class="form-label sm:w-20">Mobile file</label>
        <input id="mobile_image" type="file" wire:model="mobile_image" class="form-control"
            {{ $selected_user == null ? 'disabled' : '' }}>
    </div>


    <div>

        <h2 class="font-medium text-base mr-auto mt-4">
            Megjelenítés helyei
        </h2>

        <div class="flex flex-row justify-between">
            <div class="mt-3"> <label>Kezdőlap</label></div>
            <div class="mt-3 flex flex-row justify-evenly" style="width: 70%;">
                <div style="width: 35%;">
                    <input id="mobile_home_top" class="form-check-input" type="checkbox"
                        wire:model.live="mobile_home_top">
                    <label class="form-check-label" for="mobile_home_top">Felül</label>
                </div>
                <div>
                    <input id="mobile_home_bottom" class="form-check-input" type="checkbox"
                        wire:model.live="mobile_home_bottom">
                    <label class="form-check-label" for="mobile_home_bottom">Alul</label>
                </div>
            </div>
        </div>

        <div class="flex flex-row justify-between">
            <div class="mt-3"> <label>IPhone kategória</label></div>
            <div class="mt-3 flex flex-row justify-evenly" style="width: 70%;">
                <div style="width: 35%;">
                    <input id="mobile_iphone_top" class="form-check-input" type="checkbox"
                        wire:model.live="mobile_iphone_top">
                    <label class="form-check-label" for="mobile_iphone_top">Felül</label>
                </div>
                <div>
                    <input id="mobile_iphone_bottom" class="form-check-input" type="checkbox"
                        wire:model.live="mobile_iphone_bottom">
                    <label class="form-check-label" for="mobile_iphone_bottom">Alul</label>
                </div>
            </div>
        </div>

        <div class="flex flex-row justify-between">
            <div class="mt-3"> <label>IPad kategória</label></div>
            <div class="mt-3 flex flex-row justify-evenly" style="width: 70%;">
                <div style="width: 35%;">
                    <input id="mobile_ipad_top" class="form-check-input" type="checkbox"
                        wire:model.live="mobile_ipad_top">
                    <label class="form-check-label" for="mobile_ipad_top">Felül</label>
                </div>
                <div>
                    <input id="mobile_ipad_bottom" class="form-check-input" type="checkbox"
                        wire:model.live="mobile_ipad_bottom">
                    <label class="form-check-label" for="mobile_ipad_bottom">Alul</label>
                </div>
            </div>
        </div>

        <div class="flex flex-row justify-between">
            <div class="mt-3"> <label>Apple Watch kategória</label></div>
            <div class="mt-3 flex flex-row justify-evenly" style="width: 70%;">
                <div style="width: 35%;">
                    <input id="mobile_watch_top" class="form-check-input" type="checkbox"
                        wire:model.live="mobile_watch_top">
                    <label class="form-check-label" for="mobile_watch_top">Felül</label>
                </div>
                <div>
                    <input id="mobile_watch_bottom" class="form-check-input" type="checkbox"
                        wire:model.live="mobile_watch_bottom">
                    <label class="form-check-label" for="mobile_watch_bottom">Alul</label>
                </div>
            </div>
        </div>

        <div class="flex flex-row justify-between">
            <div class="mt-3"> <label>MacBook kategória</label></div>
            <div class="mt-3 flex flex-row justify-evenly" style="width: 70%;">
                <div style="width: 35%;">
                    <input id="mobile_macbook_top" class="form-check-input" type="checkbox"
                        wire:model.live="mobile_macbook_top">
                    <label class="form-check-label" for="mobile_macbook_top">Felül</label>
                </div>
                <div>
                    <input id="mobile_macbook_bottom" class="form-check-input" type="checkbox"
                        wire:model.live="mobile_macbook_bottom">
                    <label class="form-check-label" for="mobile_macbook_bottom">Alul</label>
                </div>
            </div>
        </div>

        <div class="flex flex-row justify-between">
            <div class="mt-3"> <label>IMac kategória</label></div>
            <div class="mt-3 flex flex-row justify-evenly" style="width: 70%;">
                <div style="width: 35%;">
                    <input id="mobile_imac_top" class="form-check-input" type="checkbox"
                        wire:model.live="mobile_imac_top">
                    <label class="form-check-label" for="mobile_imac_top">Felül</label>
                </div>
                <div>
                    <input id="mobile_imac_bottom" class="form-check-input" type="checkbox"
                        wire:model.live="mobile_imac_bottom">
                    <label class="form-check-label" for="mobile_imac_bottom">Alul</label>
                </div>
            </div>
        </div>

        <div class="flex flex-row justify-between">
            <div class="mt-3"> <label>Kiegészítők kategória</label></div>
            <div class="mt-3 flex flex-row justify-evenly" style="width: 70%;">
                <div style="width: 35%;">
                    <input id="mobile_others_top" class="form-check-input" type="checkbox"
                        wire:model.live="mobile_others_top">
                    <label class="form-check-label" for="mobile_others_top">Felül</label>
                </div>
                <div>
                    <input id="mobile_others_bottom" class="form-check-input" type="checkbox"
                        wire:model.live="mobile_others_bottom">
                    <label class="form-check-label" for="mobile_others_bottom">Alul</label>
                </div>
            </div>
        </div>

        <div class="flex flex-row justify-between">
            <div class="mt-3"> <label>Termékoldal</label></div>
            <div class="mt-3 flex flex-row justify-evenly" style="width: 70%;">
                <div style="width: 35%;">
                    <input id="mobile_product_page_top" class="form-check-input" type="checkbox"
                        wire:model.live="mobile_product_page_top">
                    <label class="form-check-label" for="mobile_product_page_top">Felül</label>
                </div>
                <div>
                    <input id="mobile_product_page_bottom" class="form-check-input" type="checkbox"
                        wire:model.live="mobile_product_page_bottom">
                    <label class="form-check-label" for="mobile_product_page_bottom">Alul</label>
                </div>
            </div>
        </div>
    </div>


</div>
