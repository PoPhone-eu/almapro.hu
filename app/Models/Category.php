<?php

namespace App\Models;

use App\Models\SubCategory;
use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'position' => 'float',
    ];
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    /**
     * Search function on Name and Email
     *
     */
    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('type', 'like', '%' . $query . '%')
            ->orWhere('category_name', 'like', '%' . $query . '%');
    }
}
