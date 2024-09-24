<div>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Banner módosítása
        </h2>
    </div>

    <div class="flex flex-row w-full mt-5">
        <div style="width: 70%" class="relative">
            @if ($banner->normal_image != null)
                <img src="/storage/{{ $banner->normal_image }}">
                <div
                    class="cursor-pointer w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-danger right-0 top-0 -mr-2 -mt-2">
                    <svg wire:click="deleteNormalImage()" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" icon-name="x" data-lucide="x" class="lucide lucide-x w-4 h-4">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </div>
            @endif
        </div>
        <div class="relative">
            @if ($banner->mobile_image != null)
                <img src="/storage/{{ $banner->mobile_image }}" style="height: 200px; margin-left: 25px;">
                <div
                    class="cursor-pointer w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-danger right-0 top-0 -mr-2 -mt-2">
                    <svg wire:click="deleteMobileImage()" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" icon-name="x" data-lucide="x"
                        class="lucide lucide-x w-4 h-4">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">

        <div class="intro-y col-span-12 lg:col-span-6">
            <form wire:submit="save">
                @include('livewire.admin.banners.partials.edit-banner-images')
                @include('livewire.admin.banners.partials.edit-banner-data')
                <div class="bg-gray-200 px-4 py-3 text-right">
                    @if ($error_msg != null)
                        <div class="text-red-500">{{ $error_msg }}</div>
                    @endif
                    <button type="submit" class="btn btn-sm btn-success py-2 px-4 mr-2 text-white">Mentés</button>
                </div>
            </form>
        </div>
        <div class="intro-y col-span-3">
            {{-- @include('livewire.admin.banners.partials.search-user') --}}
            @if ($selected_user != null)
                <div>Céges felhasználó: {{ $selected_user->full_name }}
                </div>
                <p>Email: {{ $selected_user->email }}</p>
                @php
                    $companyinfo = \App\Models\UserInfo::where('user_id', $selected_user->id)->first();
                @endphp
                @if ($companyinfo)
                    <div class="flex justify-stretch flex-row mt-5" style="padding: 5px;">
                        <div><strong>Cégadatok</strong></div>
                    </div>
                    <div class="flex justify-stretch flex-row mt-3"
                        style="border: 1px solid rgb(150, 150, 150);padding: 5px;">
                        <div>Cégnév:</div>
                        <div>{{ $companyinfo->company_name }}</div>
                    </div>
                    <div class="flex justify-stretch flex-row mt-1"
                        style="border: 1px solid rgb(150, 150, 150);padding: 5px;">
                        <div>Telefon:</div>
                        <div>{{ $companyinfo->company_phone }}</div>
                    </div>
                    <div class="flex justify-stretch flex-row mt-1"
                        style="border: 1px solid rgb(150, 150, 150);padding: 5px;">
                        <div>Cím:</div>
                        <div>{{ $companyinfo->company_address }}</div>
                    </div>
                    <div class="flex justify-stretch flex-row mt-1"
                        style="border: 1px solid rgb(150, 150, 150);padding: 5px;">
                        <div>Város:</div>
                        <div>{{ $companyinfo->company_city }}</div>
                    </div>
                    <div class="flex justify-stretch flex-row mt-1"
                        style="border: 1px solid rgb(150, 150, 150);padding: 5px;">
                        <div>Irányítószám:</div>
                        <div>{{ $companyinfo->company_postcode }}</div>
                    </div>
                    <div class="flex justify-stretch flex-row mt-1"
                        style="border: 1px solid rgb(150, 150, 150);padding: 5px;">
                        <div>Adószám:</div>
                        <div>{{ $companyinfo->company_tax_number }}</div>
                    </div>

                    <div class="flex justify-stretch flex-row mt-4" style="padding: 5px;">
                        <div><strong>Számlázási cím</strong></div>
                    </div>
                    <div class="flex justify-stretch flex-row mt-3" style="border: 1px solid green;padding: 5px;">
                        <div>Cím:</div>
                        <div>{{ $companyinfo->invoice_address }}</div>
                    </div>
                    <div class="flex justify-stretch flex-row mt-1" style="border: 1px solid green;padding: 5px;">
                        <div>Város:</div>
                        <div>{{ $companyinfo->invoice_city }}</div>
                    </div>
                    <div class="flex justify-stretch flex-row mt-1" style="border: 1px solid green;padding: 5px;">
                        <div>Irányítószám:</div>
                        <div>{{ $companyinfo->invoice_postcode }}</div>
                    </div>
                @endif

            @endif
        </div>
    </div>
</div>
