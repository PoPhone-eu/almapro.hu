<div class="w-full defauld-background">

    <div class="rating-data-row">
        <div class="rating-header">
            <div class="user-star-rating">
                <div class="product-data-user flex flex-col">
                    <div class="flex flex-row content-center">
                        <div class="rating-number">
                            {{ round(getApprovedRating($user_id), 1) }}
                            {{--    {{ round($user->averageRating(), 1) }} --}}
                        </div>
                        <div class="flex flex-col content-center">
                            <div class='rating-container pb-3'>
                                <div class='rating-stars'>
                                    @php
                                        $this_rating = getApprovedRating($user_id);
                                        $this_rating = getRatingPercentage($this_rating);
                                    @endphp
                                    <span class='rating' style="width: {{ round($this_rating, 1) }}%"></span>
                                </div>

                            </div>
                            ({{ countRating($user_id) }})
                            <svg width='0' height='0'>
                                <defs>
                                    <clipPath id='svgStars' clipPathUnits = 'objectBoundingBox'>
                                        <polygon
                                            points=".80 .073 .738 .118 .762 .19 .70 .145 .638 .19 .662 .118 .60 .073 .538 .118 .562 .19 .50 .145 .438 .19 .462 .118 .40 .073 .338 .118 .362 .19 .30 .145 .238 .19 .262 .118 .20 .073 .138 .118 .162 .19 .10 .145 .038 .19 .062 .118 0 .073 .076 .073 .10 0 .124 .073 .276 .073 .30 0 .324 .073 .476 .073 .50 0 .524 .073 .676 .073 .70 0 .724 .073 .876 .073 .90 0 .924 .073 1 .073 .938 .118 .962 .19 .90 .145 .838 .19 .862 .118 " />
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="write-rating-button">
                @auth
                    @if ($product != null)
                        @if ($already_rated == false)
                            <button class="base-button rating-button" wire:click="addrating"
                                {{ auth()->user()->id == $product->user_id ? 'hidden' : '' }}>Értékelés írása</button>
                        @else
                            <button class="base-button rating-button"
                                {{ auth()->user()->id == $product->user_id ? 'hidden' : '' }}>Már értékelted...</button>
                        @endif
                    @else
                    @endif
                @else
                    <button class="base-button rating-button" onclick="window.location.href='/login'">Értékelés
                        írása</button>
                @endauth
            </div>
        </div>
    </div>

    <div class="defauld-background-full relative">
        <img class="rating-here" src="/img/menuicons/review_this.svg" wire:ignore>

        @foreach ($ratings as $item)
            <div class="rating-table w-full">
                @php
                    $seller = \App\Models\User::find($item->reviewrateable_id);
                @endphp
                <div class="lex flex-row justify-between">
                    @if ($seller->avatar == 'avatar.png' || $seller->avatar == null)
                        <img src="/avatars/avatar.png" class="avatar">
                    @else
                        <img src="/storage/{{ $seller->avatar }}" class="avatar">
                    @endif
                    <div class="flex flex-col">
                        <p class="text-bold">{{ $seller->full_name }}</p>
                        <div class="flex flex-row">
                            <div class='rating-container'>
                                <div class='rating-stars'>
                                    <span class='rating'
                                        style="width: {{ getRatingPercentage($item->rating) }}%"></span>
                                </div>

                            </div>
                            <svg width='0' height='0'>
                                <defs>
                                    <clipPath id='svgStars' clipPathUnits = 'objectBoundingBox'>
                                        <polygon
                                            points=".80 .073 .738 .118 .762 .19 .70 .145 .638 .19 .662 .118 .60 .073 .538 .118 .562 .19 .50 .145 .438 .19 .462 .118 .40 .073 .338 .118 .362 .19 .30 .145 .238 .19 .262 .118 .20 .073 .138 .118 .162 .19 .10 .145 .038 .19 .062 .118 0 .073 .076 .073 .10 0 .124 .073 .276 .073 .30 0 .324 .073 .476 .073 .50 0 .524 .073 .676 .073 .70 0 .724 .073 .876 .073 .90 0 .924 .073 1 .073 .938 .118 .962 .19 .90 .145 .838 .19 .862 .118 " />
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                    </div>

                    <div class="flex flex-col text-right">
                        <p class="rating-content"> {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                        </p>
                    </div>

                </div>

                <div class="description-text">
                    {{ $item->author_name }}: {!! $item->body !!}
                </div>
            </div>
        @endforeach
        <!-- BEGIN: Pagination -->
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center"
            style="margin-bottom: 8px;">
            <div class="col mt-3">
                {{ $ratings->links(data: ['scrollTo' => false]) }}
            </div>
        </div>
        <!-- END: Pagination -->
    </div>
    <style>
        .slidecontainer {
            width: 100%;
        }

        .slider {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 25px;
            background: #d3d3d3;
            outline: none;
            opacity: 0.7;
            -webkit-transition: .2s;
            transition: opacity .2s;
        }

        .slider:hover {
            opacity: 1;
        }

        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 25px;
            height: 25px;
            background: #bb539a;
            cursor: pointer;
        }

        .slider::-moz-range-thumb {
            width: 25px;
            height: 25px;
            background: #bb539a;
            cursor: pointer;
        }
    </style>
    <x-rating-modal title="Értékelés írása" name="rating-modal">
        <x-slot:body>
            <form wire:submit="submit">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="slidecontainer">
                        <input type="range" min="0" max="5" {{-- value="3.5"  --}}step="0.1"
                            class="slider" id="myRange" wire:model.live="my_rating">
                    </div>
                    <div class="flex flex-row content-center">
                        <div class="rating-number" style="margin:0 auto;">
                            {{ $my_rating }}
                        </div>
                    </div>

                    <label>Értékelésem leírása:</label>
                    <textarea wire:model.blur="my_rating_content" id="my_rating_content" cols="30" rows="10" class="user-textarea"
                        placeholder="Opcionális..."></textarea>
                    <br>

                </div>
                <div class="bg-gray-200 px-4 py-3 text-right" style="background: #bb539a">
                    <button type="button" wire:click="cancelSubmit"
                        class="rounded-lg px-4 py-2 bg-gray-200 hover:bg-gray-300 duration-300 save-button"><i
                            class="fas fa-times"></i>
                        Mégse</button>
                    <button type="submit" @click="$dispatch('submit')"
                        class="rounded-lg px-4 py-2 bg-green-700 text-green-100 hover:bg-green-800 duration-300 save-button"><i
                            class="fas fa-plus"></i>
                        Értékelésem beküldése</button>
                </div>
            </form>
        </x-slot>
    </x-rating-modal>

</div>
