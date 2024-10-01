<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Shop;
use App\Models\Banner;
use App\Models\Product;
use App\Models\UserPoint;
use App\Models\MyFavorite;
use App\Models\UserPayment;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Codebyray\ReviewRateable\Contracts\ReviewRateable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Codebyray\ReviewRateable\Traits\ReviewRateable as ReviewRateableTrait;

class User extends Authenticatable implements ReviewRateable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Billable;
    use ReviewRateableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'given_name',
        'full_name',
        'role',
        'provider_id',
        'avatar',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    // hasRole function
    public function hasRole($role)
    {
        return $this->role == $role;
    }

    /**
     * Search function on Name and Email
     *
     */
    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('name', 'like', '%' . $query . '%')
            ->orWhere('email', 'like', '%' . $query . '%');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function userPoints()
    {
        return $this->hasMany(UserPoint::class);
    }

    public function payments()
    {
        return $this->hasMany(UserPayment::class);
    }

    public function banners()
    {
        return $this->hasMany(Banner::class);
    }

    public function shops()
    {
        return $this->hasMany(Shop::class);
    }

    // has many MyFavorite
    public function favorites()
    {
        return $this->hasMany(MyFavorite::class);
    }
}
