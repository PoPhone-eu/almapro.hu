<div>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Weboldal beállítások
        </h2>
    </div>
    <div class="intro-y flex items-center mt-8">
        <small>A mentés automatikus...</small>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <form wire:submit>
                <!-- BEGIN: Input -->
                <div class="intro-y box">
                    <div
                        class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            Pontok
                        </h2>
                    </div>
                    <div id="input" class="p-5">
                        <div class="preview">
                            <div class="mt-3">
                                <label for="regular-form-2" class="form-label">Egyenleg feltöltés minimum limit</label>
                                <input type="number" wire:model.live="min_points"
                                    class="form-control form-control-rounded border-{{ $min_points == null ? 'danger' : 'success' }}"
                                    placeholder="Rounded">
                                <div>
                                    @error('min_points')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-3">
                                <label for="regular-form-2" class="form-label">Telefon lekérdezés IMEI számmal
                                    ára</label>
                                <input type="number" wire:model.live="imei_price"
                                    class="form-control form-control-rounded border-{{ $imei_price == null ? 'danger' : 'success' }}"
                                    placeholder="Rounded">
                                <div>
                                    @error('imei_price')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-3">
                                <label for="regular-form-2" class="form-label">Kiemelés ára</label>
                                <input type="number" wire:model.live="featured_price"
                                    class="form-control form-control-rounded border-{{ $featured_price == null ? 'danger' : 'success' }}"
                                    placeholder="Rounded">
                                <div>
                                    @error('featured_price')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-3">
                                <label for="regular-form-2" class="form-label">Kiemelés ideje napokban</label>
                                <input type="number" wire:model.live="featured_days"
                                    class="form-control form-control-rounded border-{{ $featured_days == null ? 'danger' : 'success' }}"
                                    placeholder="Rounded">
                                <div>
                                    @error('featured_days')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-3">
                                <label for="regular-form-2" class="form-label">Regisztráció esetén van pont
                                    jóváírás</label>
                                <select wire:model.live="register_award"
                                    class="form-select form-control-rounded border-success">
                                    <option value="1">Van jóváírás</option>
                                    <option value="0">Nincs jóváírás</option>
                                </select>
                            </div>
                            <div class="mt-3">
                                <label for="regular-form-2" class="form-label">Regisztráció esetén ennyi pont lesz
                                    jóváírva</label>
                                <input type="number" wire:model.live="register_awared_points"
                                    class="form-control form-control-rounded border-{{ $register_awared_points == null ? 'danger' : 'success' }}"
                                    placeholder="Rounded">
                                <div>
                                    @error('register_awared_points')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Input -->
        </div>

        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Input -->
            <div class="intro-y box">
                <div
                    class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        <!-- BEGIN: Input -->
                    </h2>
                </div>
            </div>
            <!-- END: Input -->
            </form>
        </div>

    </div>
</div>
