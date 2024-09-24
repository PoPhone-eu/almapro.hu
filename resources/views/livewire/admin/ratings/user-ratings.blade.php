<div>
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
        <h2 class="font-medium text-base mr-auto">
            ÉRTÉKELÉSEK - {{ $user->full_name }}
        </h2>
        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
            <div class="w-56 relative text-slate-500">
                <input wire:model.live="search" type="text" class="form-control w-56 box pr-10"
                    placeholder="Értékelő neve...">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    icon-name="search" class="lucide lucide-search w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0"
                    data-lucide="search">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12">
            <table class="table table-report -mt-2" style=" z-index: 10;">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">
                            <a wire:click="sortBy('created_at')" role="button" href="#">
                                Dátum
                                @include('partials._sort-icon', ['field' => 'created_at'])
                            </a>
                        </th>
                        </th>
                        <th class="whitespace-nowrap">
                            <a wire:click="sortBy('author_name')" role="button" href="#">
                                Értékelő
                                @include('partials._sort-icon', ['field' => 'author_name'])
                            </a>
                        </th>
                        <th class="whitespace-nowrap">
                            <a wire:click="sortBy('rating')" role="button" href="#">
                                Értékelés
                                @include('partials._sort-icon', ['field' => 'rating'])
                            </a>
                        </th>
                        <th class="whitespace-nowrap">Termék</th>
                        <th class="text-center whitespace-nowrap">Művelet</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ratings as $item)
                        <tr wire:key="item-{{ $item->id }}" class="intro-x">
                            <td>
                                <span
                                    class="font-medium whitespace-nowrap">{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</span>
                            </td>
                            <td>
                                <span class="font-medium whitespace-nowrap">{{ $item->author_name }}</span>
                            </td>
                            <td>
                                <span class="font-medium whitespace-nowrap">{{ $item->rating }}</span>
                            </td>
                            <td>
                                <span class="font-medium whitespace-nowrap">{{ $item->title }}</span>
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <a role="button" class="flex items-center mr-3"
                                        wire:click="openModal({{ $item->id }})">
                                        @include('partials.icons.edit-icon')
                                        </svg> Megnéz </a>
                                    <a class="flex items-center text-danger" href="javascript:;"
                                        wire:confirm="Biztos, hogy törölni akarod?"
                                        wire:click="deleteitem({{ $item->id }})">
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
                {{ $ratings->links() }}
            </div>

            <div class="col text-right text-muted">
                {{ __('messages.search-results', [
                    'firstItem' => $ratings->firstItem(),
                    'lastItem' => $ratings->lastItem(),
                    'total' => $ratings->total(),
                ]) }}

            </div>

            <!-- END: Pagination -->
        </div>
    </div>

    <x-admin-user-modal title="Értékelés" name="admin-modal">
        <x-slot:body>
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <label class="font-medium text-gray-800">Termék: {{ $rating_title }}</label>
                <br>
                <label class="font-medium text-gray-800">Értékelést adta: {{ $author_name }}</label>
                <br>
                <label class="font-medium text-gray-800">Értékelés: {{ $rating_value }}</label>
                <br>
                <label class="font-medium text-gray-800">Értékelés leírása:</label>
                <p>
                    {{ $rating_description }}
                </p>
            </div>
            <div class="bg-gray-200 px-4 py-3 text-right">
                <button type="button" @click="$dispatch('closeModal')"
                    class="btn btn-sm btn-dark py-2 px-4 mr-2 text-white"><i class="fas fa-times"></i>
                    Bezár</button>
            </div>
        </x-slot>
    </x-admin-user-modal>

</div>
