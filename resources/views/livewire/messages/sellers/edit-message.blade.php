<div class="w-full ">
    <style>
        .inbox-head {
            background: #bb539a;
            border-radius: 0 4px 0 0;
            color: #fff;
            min-height: 80px;
            padding: 20px;
        }

        .inbox-head h3 {
            display: inline-block;
            font-weight: 600;
            font-size: 1.9rem;
            margin: 0;
            padding-top: 6px;
        }
    </style>
    <div class="inbox-head">
        <h3>Küldte:
            {{ $this_sender_name }}</h3>
    </div>
    <div class="">
        <form wire:submit="submit">

            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 ">
                <label class="category-grid-name-tag" style="margin: 12px;">Válaszom:</label>
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
                <div>
                    @error('this_body')
                        <span class="error">A válasz mező üres. Írj valamit...</span>
                    @enderror
                </div>
                @if ($this_original_body && $this_original_body != null)
                    <div class="mt-3"> <label class="category-grid-name-tag ">Előzmény:</label><br>
                        <div
                            style="padding: 12px;margin: 12px; border: solid 1px black;overflow: auto; max-height: 360px;">
                            {!! $this_original_body !!}
                        </div>
                    </div>
                @endif
            </div>
            <div class="bg-gray-200 px-4 py-3 text-right" style="background: #bb539a">
                <button type="button" href="{{ route('messages.index') }}" wire:navigate
                    class="rounded-lg px-4 py-2 bg-gray-200 hover:bg-gray-300 duration-300 save-button"><i
                        class="fas fa-times"></i>
                    Mégse</button>
                <button type="submit" {{-- @click="$dispatch('submit')" --}} class="save-button"><i class="fas fa-plus"></i>
                    Válaszol</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("livewire:navigated", () => {
            Livewire.on('reloadit', () => {
                Livewire.dispatch('changeit');
            });
        })
    </script>
</div>
