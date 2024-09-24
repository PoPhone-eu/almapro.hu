<div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
    <div class="form-label xl:w-64 xl:!mr-10">
        <div class="text-left">
            <div class="flex items-center">
                <div class="font-medium">Termékleírás</div>
                <div
                    class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">
                    Kötelező</div>
            </div>
            <div class="leading-relaxed text-slate-500 text-xs mt-3">
                <div>Győződj meg arról, hogy a termékleírás részletes magyarázatot ad a termékről és könnyen érthető.
                </div>
                <div class="mt-2">Mobilszámra, e-mail címre stb. vonatkozó információkat nem ajánlott itt megadni
                    a személyes adataid védelme érdekében.</div>
            </div>
        </div>
    </div>
    <div class="w-full mt-3 xl:mt-0 flex-1">
        @error('description')
            <span class="error">{{ $message }}</span>
        @enderror
        <div wire:ignore>
            <div x-data x-ref="editor" x-init="const quill = new Quill($refs.editor, {
                theme: 'snow'
            });
            quill.on('text-change', () => {
                $wire.set('description', quill.root.innerHTML)
            })">{!! $description !!}
            </div>
        </div>
        <div class="form-help text-right"></div>
    </div>
</div>
