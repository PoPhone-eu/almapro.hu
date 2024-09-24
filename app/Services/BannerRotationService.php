<?php

namespace App\Services;

use App\Models\User;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\UserInfo;
use App\Models\CustomerOrder;
use App\Models\InternalMessage;

class BannerRotationService
{

    public static function getRandomBanners($position_name, $this_position, $numberOfBannersToShow = 5)
    {
        if ($this_position == null) return [];
        $highestChance = Banner::max('chance');
        //$highestChance = 70;

        $randomChance = rand(0, $highestChance);
        $selectedBanners = Banner::query()
            ->where('is_active', true)
            ->join('banner_positions', 'banners.id', '=', 'banner_positions.banner_id')
            ->select('banners.*', 'banner_positions.position_name', 'banner_positions.this_position', 'banner_positions.chance')
            ->where('banner_positions.position_name', $position_name)
            ->where('banner_positions.this_position', $this_position)
            ->where('banner_positions.chance', '>=', $randomChance)
            ->where('banner_positions.chance', '<', 100)
            ->inRandomOrder()
            ->limit($numberOfBannersToShow)
            ->get()
            ->toArray();
        $selectedBanners_mandantory = Banner::query()
            ->where('is_active', true)
            ->join('banner_positions', 'banners.id', '=', 'banner_positions.banner_id')
            ->select('banners.*', 'banner_positions.position_name', 'banner_positions.this_position', 'banner_positions.chance')
            ->where('banner_positions.position_name', $position_name)
            ->where('banner_positions.this_position', $this_position)
            ->where('banner_positions.chance', 100)
            ->get()
            ->toArray();
        $selectedBannersAll = array_merge($selectedBanners_mandantory, $selectedBanners);
        return $selectedBannersAll;
        /*
        $selectedBanners = [];
         while (count($selectedBanners) < $numberOfBannersToShow) {
            $randomChance = rand(0, $highestChance);
            $additionalBanners  = Banner::query()
                ->where('is_active', true)
                ->join('banner_positions', 'banners.id', '=', 'banner_positions.banner_id')
                ->select('banners.*', 'banner_positions.position_name', 'banner_positions.this_position', 'banner_positions.chance')
                ->where('banner_positions.position_name', $position_name)
                ->where('banner_positions.this_position', $this_position)
                ->where('banner_positions.chance', '>=', $randomChance)
                ->inRandomOrder()
                ->limit($numberOfBannersToShow - count($selectedBanners))
                ->get();
            $selectedBanners = array_merge($selectedBanners, $additionalBanners->all());
        }
        $selectedBanners = array_slice($selectedBanners, 0, $numberOfBannersToShow);
        shuffle($selectedBanners);
        return $selectedBanners; */
    }
}
