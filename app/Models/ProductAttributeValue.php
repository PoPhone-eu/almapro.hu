<?php

namespace App\Models;

use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductAttributeValue extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Search function on Name and Email
     *
     */
    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('value', 'like', '%' . $query . '%')
            ->orWhere('rgb', 'like', '%' . $query . '%');
    }

    public function attribute()
    {

        return $this->belongsTo(ProductAttribute::class);
    }
}
