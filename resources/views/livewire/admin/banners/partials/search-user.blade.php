<!-- input for searchung user and selecting it -->
<div class="m-5">
    <label for="search_user" class="form-label">Céges felhasználó: Keresés név vagy email cím alapján</label>
    <input id="search_user" wire:model.live="search_user" type="text" class="form-control border-success">
    <!-- if users is not empty we show the names and emails of them so we can click and select -->
    @if (!empty($users))
        <div class="list-group mt-5">
            @foreach ($users as $user)
                <button wire:click="selectUser({{ $user->id }})" type="button"
                    class="list-group-item list-group-item-action">- {{ $user->full_name }} -
                    {{ $user->email }}</button>
            @endforeach
        </div>
    @endif
</div>
