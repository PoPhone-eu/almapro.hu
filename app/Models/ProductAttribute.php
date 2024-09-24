<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductAttributeValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductAttribute extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected function asJson($value)
    {
        /**
         * Alter Cast
         * Default is altering unicode
         */
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Search function on Name and Email
     *
     */
    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('type', 'like', '%' . $query . '%')
            ->orWhere('attr_name', 'like', '%' . $query . '%')
            ->orWhere('attr_display_name', 'like', '%' . $query . '%');
    }

    public function values()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
