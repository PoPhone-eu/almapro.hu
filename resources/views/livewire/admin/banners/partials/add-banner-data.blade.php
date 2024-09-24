<div>
    <div>

        <h2 class="font-medium text-base mr-auto mt-4">
            Banner adatok
        </h2>

        <div class="flex flex-row justify-between">
            <div class="mt-3"> <label>Státus</label></div>
            <div class="mt-3 flex flex-row justify-evenly" style="width: 70%;">
                <div style="width: 35%;">
                    <select class="form-select form-select-sm mt-2" wire:model.live="is_active">
                        <option value="1">Megjelenik</option>
                        <option value="0">Nem jelenik meg</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex flex-row justify-between">
            <div class="mt-3"> <label>Számlaazonosító</label></div>
            <div class="mt-3 flex flex-row justify-evenly" style="width: 70%;">
                <div style="width: 35%;">
                    <input id="invoice_number" class="form-input" type="text" wire:model.live="invoice_number">
                </div>
            </div>
        </div>

        <div class="flex flex-row justify-between">
            <div class="mt-3"> <label>Számladátum</label></div>
            <div class="mt-3 flex flex-row justify-evenly" style="width: 70%;">
                <div style="width: 35%;">
                    <input id="payment_date" class="form-input" type="date" wire:model.live="payment_date">
                </div>
            </div>
        </div>

        <div class="flex flex-row justify-between">
            <div class="mt-3"> <label>Fizetett összeg (FT)</label></div>
            <div class="mt-3 flex flex-row justify-evenly" style="width: 70%;">
                <div style="width: 35%;">
                    <input id="amount_payed" class="form-input" type="number" wire:model.live="amount_payed">
                </div>
            </div>
        </div>

    </div>


</div>
