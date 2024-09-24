<?php

namespace App\Models;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BannerPosition extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function banner()
    {
        return $this->belongsTo(Banner::class);
    }
}
