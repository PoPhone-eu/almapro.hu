@props(['name', 'title'])

<div x-cloak x-data="{ showrating: false }" x-show="showrating" x-on:open-rating-modal.window="showrating = true"
    x-on:close-rating-modal.window="showrating = false" x-on:keydown.escape.window="showrating = false"
    class="fixed z-10 overflow-y-auto top-20 w-full left-0"
    style="margin-top: 0px; margin-left: 0px; padding-left: 0px; z-index: 10000;">
    <div class="flex items-center justify-center min-height-100vh pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 {{-- transition-opacity --}}">
            <div class="absolute inset-0 bg-gray-900 opacity-75" />
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-center bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            @if (isset($title))
                <div class="px-4 py-3 flex items-center justify-between border-b border-gray-300"
                    style="background: #FB8518">
                    <div class="text-xl text-white">{{ $title }}</div>
                    <button x-on:click="$dispatch('close-modal')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif
            {{ $body }}
        </div>
    </div>
</div>
