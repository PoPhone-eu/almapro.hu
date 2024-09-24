<div>
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
            <label class="font-medium text-gray-800">Jelszó*:</label>
            <input type="password" wire:model="password" class="w-full outline-none rounded bg-gray-100 p-2 mt-2 mb-3"
                autocomplete="off" required />
        </div>
        <div class="bg-gray-200 px-4 py-3 text-right">
            <button type="button" @click="$dispatch('cancelSubmit')"
                class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-700 mr-2" {{--  onclick="toggleModal()" --}}><i
                    class="fas fa-times"></i> Mégse</button>
            <button type="submit" @click="$dispatch('submit')"
                class="py-2 px-4 bg-blue-500 text-black rounded hover:bg-blue-700 mr-2"><i class="fas fa-plus"></i>
                Mentés</button>
        </div>

</div>
