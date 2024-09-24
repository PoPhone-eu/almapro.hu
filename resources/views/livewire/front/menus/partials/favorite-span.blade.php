  <span class="favorite-span">
      @auth
          @if (isset($item))
              @if ($item->isFavorite(auth()->user()->id) == true)
                  <img src="/img/menuicons/kedvencek-ikon.svg" width="20px" title="Kedvenc">
              @endif
          @else
              @if ($product->isFavorite(auth()->user()->id) == true)
                  <img src="/img/menuicons/kedvencek-ikon.svg" width="20px" alt="Kedvenc">
              @endif
          @endif
      @else
          <img src="/img/menuicons/kedvencek-ikon.svg" width="20px" alt="Kedvenc">
      @endauth
  </span>
