       <div class="search-container-row" style="z-index: 2000">
           <style>
               #res {
                   background: #ffffff;
                   /*  height: 350px; */
                   width: 50%;
                   padding: 10px;
                   box-sizing: border-box;
                   border: 1px solid #bb539a;
                   border-radius: 16px;
                   position: absolute;
                   top: 53px;
                   box-shadow: 0 4px 6px 0 rgba(0, 0, 0, 0.1);
                   z-index: 1500;

               }

               #res .liEls {
                   width: 100%;
                   height: 60px;
                   display: flex;
                   border-radius: inherit;
                   cursor: pointer;
               }

               #res .liEls:hover {
                   background: rgba(207, 208, 209, 0.3);
               }

               #res .liEls img {
                   margin-left: 10px;
                   border-radius: 50%;
                   width: 50px;
                   height: 50px;
               }

               #res .liEls .desc {
                   margin-left: 15px;
                   display: flex;
                   flex-direction: column;
               }

               #res .liEls .desc .title {
                   margin: 0;
                   height: 20px;
                   box-sizing: border-box;
               }

               #res .liEls .desc .author {
                   margin: 0;
                   font-size: 13px;
                   height: 15px;
                   box-sizing: border-box;
               }

               #res .liEls .desc .summary {
                   margin: 0;
                   margin-top: 3px;
                   position: relative;
                   font-size: 10px;
                   max-width: 500px;
                   overflow: hidden;
                   line-height: 1;
               }

               #res .liEls .desc .summary .content {
                   max-height: 50px;
                   overflow: hidden;
               }

               #res .liEls .desc .summary .fadeout {
                   display: block;
                   position: absolute;
                   cursor: pointer;
                   box-sizing: border;
                   top: 0;
                   left: 0;
                   right: 0;
                   text-align: center;
                   height: 50px;
                   background: -webkit-linear-gradient(rgba(237, 239, 240, 0) 42px, #ffffff 48px);
                   transition: background 150ms ease-in;
               }

               #res .liEls .desc .rating {
                   margin: 0;
                   font-size: 13px;
                   height: 15px;
               }

               .hideResults {
                   display: none;
               }

               hr {
                   margin: 0;
               }
           </style>

           <img class="search-here" src="/img/menuicons/itt-tudsz-keresni.svg">
           {{-- <img class="search-here" src="/img/menuicons/itt_tudsz_keresni.svg"> --}}
           <div class="search-container">
               <input wire:model.live="search" type="text" class="search-input"
                   placeholder="Keresés a termékek között...">
               <button wire:click="searchProducts()" type="button" class="search-button">KERESÉS

               </button>
               <img class="search-icon" src="/img/search_icon.png">
           </div>

           <div id="res"
               class="results {{ $searchresult == null || $searchresult->count() == 0 ? 'hideResults' : '' }}"
               style="z-index: 1000">

               @if ($searchresult != null)
                   @foreach ($searchresult as $item)
                       <a href="/showproduct/{{ $item->slug }}" wire:navigate>
                           <div class="liEls">
                               <img src="{{ $item->getMedia('gallery')->first()?->getUrl() }}" />
                               <div class="desc">
                                   <h4 class="title">{{ Str::limit($item->name, 40) }}</h4>
                                   <p class="author">{{ number_format($item->price) }} Ft</p>
                                   <!-- our fade out -->
                                   <div class="summary">
                                       @if (isset($item->data['attributes']) && $item->data['attributes'] != null)
                                           @foreach ($item->data['attributes'] as $key => $value)
                                               @if (isset($value['attr_display_name']))
                                                   <label class="category-grid-attributes"> {{ $value['value'] }}
                                                       @if ($loop->last)
                                                       @else
                                                           |
                                                       @endif
                                                   </label>
                                               @endif
                                               @if ($loop->iteration == 3)
                                               @break
                                           @endif
                                       @endforeach
                                   @endif
                               </div>
                               {{--   <p class="rating">4.5</p> --}}
                           </div>
                       </div>
                   </a>
               @endforeach
               <center><a {{-- wire:click="routeingToSearchpage()" --}} href="/searchresult?search={{ $search }}" wire:navigate
                       class="{{ $searchresult->count() > 4 ? '' : 'hidden' }} cursor-pointer"><strong>Összes
                           találat...</strong></a></center>
           @endif
       </div>
       <script>
           document.addEventListener("click", (evt) => {
               const flyoutEl = document.getElementById("res");
               let targetEl = evt.target; // clicked element
               do {
                   if (targetEl == flyoutEl) {
                       // This is a click inside, does nothing, just return.
                       //console.log('Clicked inside');
                       return;
                   }
                   // Go up the DOM
                   targetEl = targetEl.parentNode;
               } while (targetEl);
               // dispach livewire event
               Livewire.dispatch('hideResults');
           });
       </script>
   </div>
