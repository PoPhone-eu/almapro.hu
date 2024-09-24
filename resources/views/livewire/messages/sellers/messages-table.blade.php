    <div class="mail-box">
        <aside class="sm-side">
            <div class="user-head">
                <div class="user-name">
                    @if (auth()->user()->avatar == 'avatar.png' || auth()->user()->avatar == null)
                        <img src="/avatars/avatar.png" class="avatar">
                    @else
                        <img src="/storage/{{ auth()->user()->avatar }}" class="avatar">
                    @endif
                    <h5>{{ auth()->user()->full_name }}</h5>
                    <span>{{ auth()->user()->email }}</span>
                </div>
            </div>
            <div class="inbox-body">
                {{-- <a wire:click="composenew(1, {{ auth()->user()->id }})" class=" save-button"
                    {{ auth()->user()->role == 'person' ? '' : 'hidden' }}>
                    Üzenet írása
                </a> --}}
            </div>
            <ul class="inbox-nav inbox-divider">
                <li class="{{ $selected_side == 'in' ? 'active' : '' }}">
                    <a wire:click="changeSelectedSide('in')" class="cursor-pointer">
                        <i class="fa fa-inbox"></i>
                        Bejövő <span class="label label-danger pull-right">({{ $count_notseen_messages }})</span></a>

                </li>
                <li class="{{ $selected_side == 'out' ? 'active' : '' }}">
                    <a wire:click="changeSelectedSide('out')" class="cursor-pointer"><i class="fa fa-envelope-o"></i>
                        Elküldött</a>
                </li>
                {{--  <li>
                    <a class="cursor-pointer"><i class=" fa fa-trash-o"></i> Kuka</a>
                </li> --}}
            </ul>

        </aside>
        <aside class="lg-side" style="display: {{ $selected_side == 'in' ? 'block' : 'none' }}">
            <div class="inbox-head">
                <h3>Érdeklődők üzenetei</h3>
            </div>
            <div class="inbox-body">
                <div class="mail-option">

                    <ul class="unstyled inbox-pagination">
                    </ul>
                </div>
                <table class="table table-inbox table-hover w-full">
                    <tbody>
                        @foreach ($messages as $item)
                            <tr class="{{ $item->seen == false ? 'unread' : '' }}"
                                href="{{ route('messages.edit', $item->id) }}" wire:navigate {{-- wire:click="compose({{ $item->id }}, {{ $item->sender_id }})" --}}>
                                <td class="inbox-small-cells">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" icon-name="edit"
                                        data-lucide="edit" class="lucide lucide-edit block mx-auto">
                                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>

                                </td>
                                <td class="view-message">
                                    {{ $item->sender_name }}
                                    @if ($item->product_name != null)
                                        <br> <small>Termék: {{ $item->product_name }}</small>
                                    @endif
                                </td>
                                <td class="view-message ">{{ $item->subject }}</td>
                                <td class="view-message  text-right">{{ $item->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- BEGIN: Pagination -->
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                    <div class="col mt-3">
                        {{ $messages->links() }}
                    </div>
                </div>
            </div>
        </aside>

        <aside class="lg-side " style="display: {{ $selected_side == 'out' ? 'block' : 'none' }}">
            <div class="inbox-head">
                <h3>Elküldött válasz üzeneteim</h3>
            </div>
            <div class="inbox-body">
                <div class="mail-option">

                    <ul class="unstyled inbox-pagination">
                    </ul>
                </div>
                <table class="table table-inbox table-hover">
                    <tbody>
                        @foreach ($outmessages as $item)
                            <tr class="" wire:click="viewmessage({{ $item->id }})">
                                <td class="inbox-small-cells">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" icon-name="edit"
                                        data-lucide="edit" class="lucide lucide-edit block mx-auto">
                                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </td>
                                <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
                                <td class="view-message">
                                    {{ $item->sender_name }}
                                    @if ($item->product_name != null)
                                        <br> <small>Termék: {{ $item->product_name }}</small>
                                    @endif
                                </td>
                                <td class="view-message ">{{ $item->subject }}</td>
                                {{-- <td class="view-message  inbox-small-cells">** **</td> --}}
                                <td class="view-message  text-right">{{ $item->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- BEGIN: Pagination -->
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                    <div class="col mt-3">
                        {{ $outmessages->links() }}
                    </div>

                    <div class="col text-right text-muted">
                        {{ __('messages.search-results', [
                            'firstItem' => $outmessages->firstItem(),
                            'lastItem' => $outmessages->lastItem(),
                            'total' => $outmessages->total(),
                        ]) }}

                    </div>

                    <!-- END: Pagination -->
                </div>
                <!-- END: Pagination -->
            </div>
        </aside>


        <x-admin-user-modal title="{{ $modal_title }}" name="admin-modal">
            <x-slot:body>
                @if ($modalstatus == 'view')
                    <div style="padding: 12px;margin: 12px; border: solid 1px black;overflow: auto; max-height: 360px;">
                        {!! $this_original_body !!}
                    </div>
                @else
                    <form wire:submit="submit">

                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <label style="margin: 12px;">Küldte:
                                {{ $this_sender_name }}</label>
                            <br>
                            <div wire:ignore>
                                <div style="height:90px;" x-data x-ref="editor" x-init="const quill = new Quill($refs.editor, {
                                    theme: 'snow'
                                });
                                quill.on('text-change', () => {
                                    $dispatch('updateBody', { body: quill.root.innerHTML });
                                })">
                                </div>
                            </div>
                            @if ($this_original_body && $this_original_body != null)
                                <div>Előzmény:<br>
                                    <div
                                        style="padding: 12px;margin: 12px; border: solid 1px black;overflow: auto; max-height: 360px;">
                                        {!! $this_original_body !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="bg-gray-200 px-4 py-3 text-right" style="background: #bb539a">
                            <button type="button" wire:click="cancelSubmit"
                                class="rounded-lg px-4 py-2 bg-gray-200 hover:bg-gray-300 duration-300 save-button"><i
                                    class="fas fa-times"></i>
                                Mégse</button>
                            <button type="submit" @click="$dispatch('submit')"
                                class="rounded-lg px-4 py-2 bg-green-700 text-green-100 hover:bg-green-800 duration-300 save-button"><i
                                    class="fas fa-plus"></i>
                                Válaszol</button>
                        </div>
                    </form>
                @endif

            </x-slot>
        </x-admin-user-modal>
    </div>
