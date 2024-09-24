<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrder extends Model
{
    use HasFactory;
    protected $guarded = [];

    const STATUS = [
        'new'    => 'Új',
        'accepted' => 'Elfogadva',
        'rejected' => 'Elutasítva',
        'completed' => 'Teljesítve',
    ];
}
