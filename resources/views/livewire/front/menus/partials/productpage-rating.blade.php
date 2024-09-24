<div class="w-full defauld-background">

    <div class="rating-data-row">
        <div class="rating-header">
            <div class="user-star-rating">
                <div class="product-data-user flex flex-col">
                    <div class="flex flex-row content-center">
                        <div class="rating-number">
                            {{ round($seller->averageRating(), 1) }}
                        </div>
                        <div class="flex flex-col content-center">
                            <div class='rating-container pb-3'>
                                <div class='rating-stars'>
                                    <span class='rating'
                                        style="width: {{ round($seller->ratingPercent(), 1) }}%"></span>
                                </div>

                            </div>
                            ({{ $seller->countRating() }})
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
                <button class="base-button rating-button">Értékelés írása</button>
            </div>
        </div>
    </div>

    <div class="defauld-background-full">


        @foreach ($ratings as $item)
            <div class="rating-table w-full">
                @php
                    $author = \App\Models\User::find($item->author_id);
                    if ($author == null) {
                        continue;
                    }
                @endphp
                <div class="lex flex-row justify-between">
                    @if ($author->avatar == 'avatar.png' || $author->avatar == null)
                        <img src="/avatars/avatar.png" class="avatar">
                    @else
                        <img src="/storage/{{ $author->avatar }}" class="avatar">
                    @endif
                    <div class="flex flex-col">
                        <p class="text-bold">{{ $author->full_name }}</p>
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
                        {{-- <div class="text-right">
                            <label style="float:right;">
                                {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</label>
                        </div> --}}
                    </div>

                </div>

                <div class="description-text">
                    {!! $item->body !!}
                </div>
            </div>
        @endforeach
        <!-- BEGIN: Pagination -->
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center"
            style="margin-bottom: 8px;">
            <div class="col mt-3">
                {{ $ratings->links(data: ['scrollTo' => false]) }}
            </div>
            <!-- END: Pagination -->
        </div>
        <!-- END: Pagination -->

    </div>

</div>
