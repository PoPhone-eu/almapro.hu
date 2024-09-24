<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPayment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Livewire: Search function on Payments
     *
     */
    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('name', 'like', '%' . $query . '%')
            ->orWhere('uuid', 'like', '%' . $query . '%')
            ->orWhere('stripe_id', 'like', '%' . $query . '%')
            ->orWhere('created_at', 'like', '%' . $query . '%');
    }
}
