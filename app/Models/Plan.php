<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'stripe_plan',
        'price',
        'description',
    ];

    /**
     * Write code on Method
     *
     * @return response()
     */

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
