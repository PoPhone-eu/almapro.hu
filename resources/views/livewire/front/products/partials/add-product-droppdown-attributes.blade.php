            <div class="form-inline flex-col xl:flex-row mt-5 pt-5">
                <div class="form-label xl:w-64 xl:!mr-10">
                    <div class="text-left">
                        <div class="flex items-center">
                            <div class="font-medium text-bold">Eszköz állapota</div>
                            <div
                                class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                                Kötelező</div>
                        </div>
                    </div>
                </div>
                <div class="w-full mt-3 xl:mt-0 flex-1">
                    <select wire:model.live="allapot" class="form-select user-input" style="width: 300px;" required>
                        <option value="">Válassz...</option>
                        @foreach (\App\Models\Product::DEVICE_STATES as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if ($attr_type == 'iPhone' || $attr_type == 'iPad' || $attr_type == 'Watch' || $attr_type == 'Watch')
                <div class="form-inline flex-col xl:flex-row mt-5 pt-5">
                    <div class="form-label xl:w-64 xl:!mr-10">
                        <div class="text-left">
                            <div class="flex items-center">
                                <div class="font-medium text-bold">Keret állapota</div>
                                <div
                                    class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                                    Kötelező</div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-3 xl:mt-0 flex-1">
                        <select wire:model.live="keret" class="form-select user-input" style="width: 300px;" required>
                            <option value="">Válassz...</option>
                            @foreach (\App\Models\Product::DEVICE_STATUS as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-inline flex-col xl:flex-row mt-5 pt-5">
                    <div class="form-label xl:w-64 xl:!mr-10">
                        <div class="text-left">
                            <div class="flex items-center">
                                <div class="font-medium text-bold">Hátlap állapota</div>
                                <div
                                    class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                                    Kötelező</div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-3 xl:mt-0 flex-1">
                        <select wire:model.live="hatlap" class="form-select user-input" style="width: 300px;" required>
                            <option value="">Válassz...</option>
                            @foreach (\App\Models\Product::DEVICE_STATUS as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-inline flex-col xl:flex-row mt-5 pt-5">
                    <div class="form-label xl:w-64 xl:!mr-10">
                        <div class="text-left">
                            <div class="flex items-center">
                                <div class="font-medium text-bold">Kijelző állapota</div>
                                <div
                                    class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                                    Kötelező</div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-3 xl:mt-0 flex-1">
                        <select wire:model.live="kijelzo" class="form-select user-input" style="width: 300px;" required>
                            <option value="">Válassz...</option>
                            @foreach (\App\Models\Product::DEVICE_STATUS as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @elseif($attr_type == 'MacBook')
                <div class="form-inline flex-col xl:flex-row mt-5 pt-5">
                    <div class="form-label xl:w-64 xl:!mr-10">
                        <div class="text-left">
                            <div class="flex items-center">
                                <div class="font-medium text-bold">Fedlap állapota</div>
                                <div
                                    class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                                    Kötelező</div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-3 xl:mt-0 flex-1">
                        <select wire:model.live="fedlap" class="form-select user-input" style="width: 300px;" required>
                            <option value="">Válassz...</option>
                            @foreach (\App\Models\Product::DEVICE_STATUS as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-inline flex-col xl:flex-row mt-5 pt-5">
                    <div class="form-label xl:w-64 xl:!mr-10">
                        <div class="text-left">
                            <div class="flex items-center">
                                <div class="font-medium text-bold">Hátlap állapota</div>
                                <div
                                    class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                                    Kötelező</div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-3 xl:mt-0 flex-1">
                        <select wire:model.live="hatlap" class="form-select user-input" style="width: 300px;" required>
                            <option value="">Válassz...</option>
                            @foreach (\App\Models\Product::DEVICE_STATUS as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-inline flex-col xl:flex-row mt-5 pt-5">
                    <div class="form-label xl:w-64 xl:!mr-10">
                        <div class="text-left">
                            <div class="flex items-center">
                                <div class="font-medium text-bold">Kijelző állapota</div>
                                <div
                                    class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                                    Kötelező</div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-3 xl:mt-0 flex-1">
                        <select wire:model.live="kijelzo" class="form-select user-input" style="width: 300px;" required>
                            <option value="">Válassz...</option>
                            @foreach (\App\Models\Product::DEVICE_STATUS as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @elseif($attr_type == 'iMac')
                <div class="form-inline flex-col xl:flex-row mt-5 pt-5">
                    <div class="form-label xl:w-64 xl:!mr-10">
                        <div class="text-left">
                            <div class="flex items-center">
                                <div class="font-medium text-bold">Hátlap állapota</div>
                                <div
                                    class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                                    Kötelező</div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-3 xl:mt-0 flex-1">
                        <select wire:model.live="hatlap" class="form-select user-input" style="width: 300px;" required>
                            <option value="">Válassz...</option>
                            @foreach (\App\Models\Product::DEVICE_STATUS as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-inline flex-col xl:flex-row mt-5 pt-5">
                    <div class="form-label xl:w-64 xl:!mr-10">
                        <div class="text-left">
                            <div class="flex items-center">
                                <div class="font-medium text-bold">Kijelző állapota</div>
                                <div
                                    class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                                    Kötelező</div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-3 xl:mt-0 flex-1">
                        <select wire:model.live="kijelzo" class="form-select user-input" style="width: 300px;"
                            required>
                            <option value="">Válassz...</option>
                            @foreach (\App\Models\Product::DEVICE_STATUS as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @else
                <div class="form-inline flex-col xl:flex-row mt-5 pt-5">
                    <div class="form-label xl:w-64 xl:!mr-10">
                        <div class="text-left">
                            <div class="flex items-center">
                                <div class="font-medium text-bold">Hátlap állapota</div>
                                <div
                                    class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                                    Opcionális</div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-3 xl:mt-0 flex-1">
                        <select wire:model.live="hatlap" class="form-select user-input" style="width: 300px;">
                            <option value="">Válassz...</option>
                            @foreach (\App\Models\Product::DEVICE_STATUS as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-inline flex-col xl:flex-row mt-5 pt-5">
                    <div class="form-label xl:w-64 xl:!mr-10">
                        <div class="text-left">
                            <div class="flex items-center">
                                <div class="font-medium text-bold">Kijelző állapota</div>
                                <div
                                    class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                                    Opcionális</div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-3 xl:mt-0 flex-1">
                        <select wire:model.live="kijelzo" class="form-select user-input" style="width: 300px;">
                            <option value="">Válassz...</option>
                            @foreach (\App\Models\Product::DEVICE_STATUS as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-inline flex-col xl:flex-row mt-5 pt-5">
                    <div class="form-label xl:w-64 xl:!mr-10">
                        <div class="text-left">
                            <div class="flex items-center">
                                <div class="font-medium text-bold">Fedlap állapota</div>
                                <div
                                    class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                                    Opcionális</div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-3 xl:mt-0 flex-1">
                        <select wire:model.live="fedlap" class="form-select user-input" style="width: 300px;">
                            <option value="">Válassz...</option>
                            @foreach (\App\Models\Product::DEVICE_STATUS as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-inline flex-col xl:flex-row mt-5 pt-5">
                    <div class="form-label xl:w-64 xl:!mr-10">
                        <div class="text-left">
                            <div class="flex items-center">
                                <div class="font-medium text-bold">Ház állapota</div>
                                <div
                                    class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                                    Opcionális</div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-3 xl:mt-0 flex-1">
                        <select wire:model.live="fedlap" class="form-select user-input" style="width: 300px;">
                            <option value="">Válassz...</option>
                            @foreach (\App\Models\Product::DEVICE_STATUS as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif
