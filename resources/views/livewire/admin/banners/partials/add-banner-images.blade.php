<div>
    <span style="color:red;">
        @if ($selected_user == null)
            Kersd ki a céges felhesználót a jobb oldali beviteli mező segítségével.
        @endif
    </span>
    <div class="form-inline">
        <label for="normal_image_path" class="form-label sm:w-20">Desktop file</label>
        <input id="normal_image_path" type="file" wire:model="normal_image" class="form-control"
            {{ $selected_user == null ? 'disabled' : '' }}>
    </div>
    <div class="form-inline mt-5">
        <label for="mobile_image" class="form-label sm:w-20">Mobile file</label>
        <input id="mobile_image" type="file" wire:model="mobile_image" class="form-control"
            {{ $selected_user == null ? 'disabled' : '' }}>
    </div>

    {{-- banner link input --}}
    <div class="form-inline mt-5">
        <label for="link" class="form-label sm:w-20">Banner link (teljes url-t írd be)</label>
        <input id="link" type="text" wire:model.live="link" class="form-control"
            placeholder="https://akarmi.hu">
    </div>

    <div>

        <h2 class="font-medium text-base mr-auto mt-4">
            Megjelenítés helyei
        </h2>


        @foreach ($selectedPositions as $key => $value)
            <div class="flex flex-row justify-between">
                <div class="mt-3"> <label>{{ $value['name'] }}</label></div>
                <div class="mt-3 flex flex-row justify-evenly" style="width: 60%;">
                    @foreach ($value['positions'] as $key_p => $value_p)
                        {{--      @foreach ($value_p as $key_p_2 => $value_p_2) --}}
                        <div style="width: 35%;">
                            <input id="{{ $value['name'] }}-{{ $key_p }}-{{ $key_p }}"
                                class="form-check-input" type="checkbox"
                                wire:model.live="selectedPositions.{{ $key }}.positions.{{ $key_p }}.value">
                            <label class="form-check-label"
                                for="{{ $value['name'] }}-{{ $key_p }}-{{ $key_p }}">{{ $value_p['pos_name'] }}</label>
                        </div>
                    @endforeach

                    <div>
                        <input class="form-check-input" type="number" step="1" min="0" max="100"
                            wire:model.live="selectedPositions.{{ $key }}.chance" style="width: 140px;"
                            placeholder="esély %">

                    </div>
                </div>
            </div>
        @endforeach


    </div>

</div>
