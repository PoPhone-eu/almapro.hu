<div class="product-page-content">
    <div class="product-data-row">
        <style>
            .rating-container {
                position: relative;
                width: calc((100 / 19) * 20px);
                height: 20px;
            }

            .rating-stars {
                position: absolute;
                width: 100%;
                height: 0%;
                padding-bottom: 100%;
                background: lightgray;
                -webkit-clip-path: url(#svgStars);
                clip-path: url(#svgStars);
                -webkit-clip-path: polygon(80% 7.3%, 73.8% 11.8%, 76.2% 19%, 70% 14.5%, 63.8% 19%, 66.2% 11.8%, 60% 7.3%, 53.8% 11.8%, 56.2% 19%, 50% 14.5%, 43.8% 19%, 46.2% 11.8%, 40% 7.3%, 33.8% 11.8%, 36.2% 19%, 30% 14.5%, 23.8% 19%, 26.2% 11.8%, 20% 7.3%, 13.8% 11.8%, 16.2% 19%, 10% 14.5%, 3.8% 19%, 6.2% 11.8%, 0 7.3%, 7.6% 7.3%, 10% 0, 12.4% 7.3%, 27.6% 7.3%, 30% 0, 32.4% 7.3%, 47.6% 7.3%, 50% 0, 52.4% 7.3%, 67.6% 7.3%, 70% 0, 72.4% 7.3%, 87.6% 7.3%, 90% 0, 92.4% 7.3%, 100% 7.3%, 93.8% 11.8%, 96.2% 19%, 90% 14.5%, 83.8% 19%, 86.2% 11.8%);
                clip-path: polygon(80% 7.3%, 73.8% 11.8%, 76.2% 19%, 70% 14.5%, 63.8% 19%, 66.2% 11.8%, 60% 7.3%, 53.8% 11.8%, 56.2% 19%, 50% 14.5%, 43.8% 19%, 46.2% 11.8%, 40% 7.3%, 33.8% 11.8%, 36.2% 19%, 30% 14.5%, 23.8% 19%, 26.2% 11.8%, 20% 7.3%, 13.8% 11.8%, 16.2% 19%, 10% 14.5%, 3.8% 19%, 6.2% 11.8%, 0 7.3%, 7.6% 7.3%, 10% 0, 12.4% 7.3%, 27.6% 7.3%, 30% 0, 32.4% 7.3%, 47.6% 7.3%, 50% 0, 52.4% 7.3%, 67.6% 7.3%, 70% 0, 72.4% 7.3%, 87.6% 7.3%, 90% 0, 92.4% 7.3%, 100% 7.3%, 93.8% 11.8%, 96.2% 19%, 90% 14.5%, 83.8% 19%, 86.2% 11.8%);
            }

            .rating {
                position: absolute;
                display: block;
                height: 100%;
                background-color: orange;
            }
        </style>

        <div class="contact">
            <div class="product-data-user flex flex-row ">
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
                                @php
                                    $this_rating = getApprovedRating($seller->id);
                                    $this_rating = getRatingPercentage($this_rating);
                                @endphp
                                <span class='rating' style="width: {{ round($this_rating, 1) }}%"></span>
                            </div>

                        </div>
                        ({{ countRating($seller->id) }})
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

        <div class="description">
            <div class="product-data-title">Profiladatok</div>
            <div><a href="" wire:navigate><img src="/img/szem.png" style="width:30px;"></a></div>
            <div class="description-text">
                @if ($seller->role == 'company')
                    @php
                        $userinfo = \App\Models\UserInfo::where('user_id', $seller->id)->first();
                    @endphp
                    <div class="flex flex-row justify-between  items-center"
                        style="width: 70%; margin: 0 auto;font-size: 1.1rem;">
                        <div class="text-bold" style="margin: 3px;">Város:</div>
                        <div>{{ $userinfo->invoice_city }}</div>
                    </div>
                @endif
                <div class="flex flex-row justify-between  items-center"
                    style="width: 70%; margin: 0 auto;font-size: 1.1rem;">
                    <div class="text-bold" style="margin: 3px;">Profil típusa:</div>
                    <div>{{ $seller->role == 'company' ? 'Kereskedő' : 'Magánszemély' }}</div>
                </div>
                <div class="flex flex-row justify-between  items-center"
                    style="width: 70%; margin: 0 auto;font-size: 1.1rem;">
                    <div class="text-bold" style="margin: 3px;">Regisztráció ideje:</div>
                    <div>{{ \Carbon\Carbon::parse($seller->created_at)->format('Y-m-d') }}</div>
                </div>
                <div class="flex flex-row justify-between  items-center"
                    style="width: 70%; margin: 0 auto;font-size: 1.1rem;">
                    <div class="text-bold" style="margin: 3px;">Utoljára aktív:</div>
                    @if ($seller->is_owner == false)
                        <div>{{ \Carbon\Carbon::parse($seller->updated_at)->diffForHumans() }}</div>
                    @else
                        <div>Nemrég</div>
                    @endif
                </div>
                <div class="flex flex-row justify-between  items-center"
                    style="width: 70%; margin: 0 auto;font-size: 1.1rem;">
                    <div class="text-bold" style="margin: 3px;">Hírdetések száma:</div>
                    <div>{{ $seller->products()->count() }} hírdetés</div>
                </div>

            </div>
        </div>
    </div>
    <div class="w-full">
        <livewire:front.ratings.user-rating-table :seller_id="$seller_id" :product_id="$product_id" />
    </div>

    <div class="w-full">
        <div class="title-name">
            <p>Hírdetett termékek</p>
        </div>
    </div>


    <div class="{{ $products->count() == 0 ? 'profile-content' : 'category-container' }}">
        @if ($products->count() == 0)
            <div class="flex w-full">
                <p class="category-grid-name-tag">Nincs találat</p>
            </div>
        @endif
        @foreach ($products as $item)
            <a href="/showproduct/{{ $item->slug }}" wire:navigate>
                <div class="category-grid-item">
                    <div class="category-grid-prod-image"{{--  id="this{{ $item->id }}" --}}>
                        <img src="{{ $item->getMedia('mainimage')->first()?->getUrl() }}" />
                    </div>
                    <div class="category-grid-prod-data">
                        <p class="category-grid-price-tag">{{ number_format($item->price) }} Ft</p>
                        <p class="category-grid-name-tag">{{ Str::limit($item->name, 40) }}</p>
                        @if (isset($item->data['attributes']) && $item->data['attributes'] != null)
                            @foreach ($item->data['attributes'] as $key => $value)
                                @if (isset($value['attr_display_name']))
                                    <label class="category-grid-attributes"> {{ $value['value'] }} @if ($loop->last)
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
                <button class="base-button category-grid-button mt-3">Megnézem</button>
            </div>
        </a>
    @endforeach

</div>

</div>
