<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'data'         => 'array',
    ];

    const POSITIONS = [
        'home'          => [
            'name' => 'Kezdőlap',
            'chance'    => 0,
            'positions' => [
                'top'       => [
                    'pos_name' => 'Felső',
                    'value' => false,
                ],
                /* 'bottom'    =>
                [
                    'pos_name' => 'Alsó',
                    'value' => false,
                ], */
            ],
        ],
        'IPhone'          => [
            'name' => 'iPhone',
            'chance'    => 0,
            'positions' => [
                'top'       => [
                    'pos_name' => 'Felső',
                    'value' => false,
                ],
                /*  'bottom'    =>
                [
                    'pos_name' => 'Alsó',
                    'value' => false,
                ], */
            ],
        ],
        'IPad'          => [
            'name' => 'iPad',
            'chance'    => 0,
            'positions' => [
                'top'       => [
                    'pos_name' => 'Felső',
                    'value' => false,
                ],
                /*  'bottom'    =>
                [
                    'pos_name' => 'Alsó',
                    'value' => false,
                ], */
            ],
        ],
        'Watch'         => [
            'name' => 'Watch',
            'chance'    => 0,
            'positions' => [
                'top'       => [
                    'pos_name' => 'Felső',
                    'value' => false,
                ],
                /* 'bottom'    =>
                [
                    'pos_name' => 'Alsó',
                    'value' => false,
                ], */
            ],
        ],
        'MacBook'       => [
            'name' => 'MacBook',
            'chance'    => 0,
            'positions' => [
                'top'       => [
                    'pos_name' => 'Felső',
                    'value' => false,
                ],
                /*  'bottom'    =>
                [
                    'pos_name' => 'Alsó',
                    'value' => false,
                ], */
            ],
        ],
        'IMac'          => [
            'name' => 'iMac',
            'chance'    => 0,
            'positions' => [
                'top'       => [
                    'pos_name' => 'Felső',
                    'value' => false,
                ],
                /*  'bottom'    =>
                [
                    'pos_name' => 'Alsó',
                    'value' => false,
                ], */
            ],
        ],
        'Others'        => [
            'name' => 'Others',
            'chance'    => 0,
            'positions' => [
                'top'       => [
                    'pos_name' => 'Felső',
                    'value' => false,
                ],
                /* 'bottom'    =>
                [
                    'pos_name' => 'Alsó',
                    'value' => false,
                ], */
            ],
        ],
        'Samsung'        => [
            'name' => 'Samsung',
            'chance'    => 0,
            'positions' => [
                'top'       => [
                    'pos_name' => 'Felső',
                    'value' => false,
                ],
                /* 'bottom'    =>
                [
                    'pos_name' => 'Alsó',
                    'value' => false,
                ], */
            ],
        ],
        'Android'        => [
            'name' => 'Android',
            'chance'    => 0,
            'positions' => [
                'top'       => [
                    'pos_name' => 'Felső',
                    'value' => false,
                ],
                /* 'bottom'    =>
                [
                    'pos_name' => 'Alsó',
                    'value' => false,
                ], */
            ],
        ],
        'egyeb'        => [
            'name' => 'egyeb',
            'chance'    => 0,
            'positions' => [
                'top'       => [
                    'pos_name' => 'Felső',
                    'value' => false,
                ],
                /* 'bottom'    =>
                [
                    'pos_name' => 'Alsó',
                    'value' => false,
                ], */
            ],
        ],
        /* 'product_page'  => [
            'name' => 'Termékoldal',
            'chance'    => 0,
            'positions' => [
                'top'       => [
                    'pos_name' => 'Felső',
                    'value' => false,
                ],
                'bottom'    =>
                [
                    'pos_name' => 'Alsó',
                    'value' => false,
                ],
            ],
        ], */
    ];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('invoice_id', 'like', '%' . $query . '%')
            ->orWhere('from_date', 'like', '%' . $query . '%')
            ->orWhere('to_date', 'like', '%' . $query . '%')
            ->orWhere('chance', 'like', '%' . $query . '%')
            ->orWhere('from_date', 'like', '%' . $query . '%');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function positions()
    {
        return $this->hasMany(BannerPosition::class);
    }
}
