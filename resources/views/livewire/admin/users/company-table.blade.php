<div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <button @click="$dispatch('open-admin-modal-this')" class="btn btn-primary shadow-md mr-2"
                {{-- onclick="toggleModal()" --}}>Új
                kereskedő felvitele</button>
            <div class="hidden md:block mx-auto text-slate-500"></div>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <div class="w-56 relative text-slate-500">
                    <input wire:model.live="search" type="text" class="form-control w-56 box pr-10"
                        placeholder="Keres...">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" icon-name="search"
                        class="lucide lucide-search w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0"
                        data-lucide="search">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>
            </div>
        </div>

        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12">
            <table class="table table-report -mt-2" style=" z-index: 10;">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">Név</th>
                        <th class="whitespace-nowrap">Email</th>
                        <th class="text-center whitespace-nowrap">Művelet</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr wire:key="user-{{ $user->id }}" class="intro-x">
                            <td>
                                <span class="font-medium whitespace-nowrap">{{ $user->name }}
                                    {{ $user->given_name }}</span>
                            </td>
                            <td>
                                <span class="font-medium whitespace-nowrap">{{ $user->email }}</span>
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <a href="userratings/{{ $user->id }}" role="button" wire:navigate
                                        class="flex items-center mr-3" {{-- href="javascript:;" --}}>
                                        @include('partials.icons.star')
                                        </svg> Értékelések </a>
                                    <a href="userproducts/{{ $user->id }}" role="button" wire:navigate
                                        class="flex items-center mr-3" {{-- href="javascript:;" --}}>
                                        @include('partials.icons.box')
                                        </svg> Termékek </a>
                                    <button class="flex items-center mr-3"
                                        @click="$dispatch('open-admin-modal-edit', { companyuser_id: {{ $user->id }}} )"
                                        {{-- href="javascript:;" --}}> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            icon-name="check-square" data-lucide="check-square"
                                            class="lucide lucide-check-square w-4 h-4 mr-1">
                                            <polyline points="9 11 12 14 22 4"></polyline>
                                            <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path>
                                        </svg> Szerkeszt </button>

                                    <a class="flex items-center text-danger" href="javascript:;"
                                        wire:confirm.prompt="Biztos, hogy törölni akarod? \n A megerősítéshez írd be hogy CONFIRM és nyomj egy entert. | CONFIRM"
                                        wire:click="deleteuser({{ $user->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" icon-name="trash-2"
                                            data-lucide="trash-2" class="lucide lucide-trash-2 w-4 h-4 mr-1">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path
                                                d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2">
                                            </path>
                                            <line x1="10" y1="11" x2="10" y2="17">
                                            </line>
                                            <line x1="14" y1="11" x2="14" y2="17">
                                            </line>
                                        </svg> Töröl </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
            <div class="col mt-3">
                {{ $users->links() }}
            </div>

            <div class="col text-right text-muted">
                {{ __('messages.search-results', [
                    'firstItem' => $users->firstItem(),
                    'lastItem' => $users->lastItem(),
                    'total' => $users->total(),
                ]) }}

            </div>

            <!-- END: Pagination -->
        </div>
    </div>

    <x-admin-user-modal title="{{ $modal_title }}" name="admin-modal">
        <x-slot:body>
            <form wire:submit="submit">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <label class="font-medium text-gray-800">Családnév*</label>
                    <input wire:model="newname" type="text" autocomplete="off"
                        class="w-full outline-none rounded bg-gray-100 p-2 mt-2 mb-3" required />
                    <label class="font-medium text-gray-800">Keresztnév*:</label>
                    <input wire:model="given_newname" type="text" autocomplete="off"
                        class="w-full outline-none rounded bg-gray-100 p-2 mt-2 mb-3" required />
                    <label class="font-medium text-gray-800">Email*:</label>
                    <input wire:model="newemail" type="text" autocomplete="off"
                        class="w-full outline-none rounded bg-gray-100 p-2 mt-2 mb-3" required />

                    @if ($companyuser_id == null)
                        <label class="font-medium text-gray-800">Jelszó*:</label>
                        <input type="password" wire:model="password"
                            class="w-full outline-none rounded bg-gray-100 p-2 mt-2 mb-3" autocomplete="off"
                            required />
                    @else
                        <input type="hidden" wire:model="password">
                    @endif
                </div>
                <div class="bg-gray-200 px-4 py-3 text-right">
                    <button type="button" @click="$dispatch('cancelSubmit')"
                        class="btn btn-sm btn-dark py-2 px-4 mr-2 text-white"><i class="fas fa-times"></i>
                        Mégse</button>
                    <button type="submit" @click="$dispatch('submit')"
                        class="btn btn-sm btn-success py-2 px-4 mr-2 text-white"><i class="fas fa-plus"></i>
                        Mentés</button>
                </div>
            </form>

        </x-slot>
    </x-admin-user-modal>

</div>
