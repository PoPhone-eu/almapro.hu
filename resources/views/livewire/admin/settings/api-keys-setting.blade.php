<div>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Stripe és szamlazz.hu API kulcsok
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
                            Stripe
                        </h2>
                    </div>
                    <div id="input" class="p-5">
                        <div class="preview">
                            <div class="mt-3">
                                <label for="regular-form-2" class="form-label">Stripe Key</label>
                                <input type="text" wire:model.blur="stripe_key"
                                    class="form-control form-control-rounded border-{{ $stripe_key == null ? 'danger' : 'success' }}"
                                    placeholder="Rounded">
                                <div>
                                    @error('stripe_key')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-3">
                                <label for="regular-form-2" class="form-label">Stripe Secret</label>
                                <input type="text" wire:model.blur="stripe_secret"
                                    class="form-control form-control-rounded border-{{ $stripe_secret == null ? 'danger' : 'success' }}"
                                    placeholder="Rounded">
                                <div>
                                    @error('stripe_secret')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-3">
                                <label for="regular-form-2" class="form-label">Stripe Webhook Secret</label>
                                <input type="text" wire:model.blur="stripe_webhook_secret"
                                    class="form-control form-control-rounded border-{{ $stripe_webhook_secret == null ? 'danger' : 'success' }}"
                                    placeholder="Rounded">
                                <div>
                                    @error('stripe_webhook_secret')
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
                        Szamlazz.hu
                    </h2>
                </div>
                <div id="input" class="p-5">
                    <div class="preview">
                        <div class="mt-3">
                            <label for="regular-form-2" class="form-label">Szamlazz.hu API Kulcs</label>
                            <input type="text" wire:model.blur="szamlazz_hu_api_key"
                                class="form-control form-control-rounded border-{{ $szamlazz_hu_api_key == null ? 'danger' : 'success' }}"
                                placeholder="Rounded">
                            <div>
                                @error('szamlazz_hu_api_key')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Input -->
            </form>
        </div>

    </div>
</div>
