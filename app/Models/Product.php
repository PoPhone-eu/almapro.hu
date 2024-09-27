<?php

namespace App\Models;

use App\Models\Shop;
use App\Models\User;
use App\Models\Category;
use App\Models\MyFavorite;
use Spatie\Html\Elements\I;
use Spatie\Sluggable\HasSlug;
use App\Models\ProductAttribute;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasSlug, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'data'         => 'array',
    ];

    const TYPES = [
        'iPhone'    => 'IPhone',
        'iPad'      => 'IPad',
        'Watch'     => 'Apple Watch',
        'MacBook'   => 'MacBook',
        'iMac'      => 'IMac',
        'Others'    => 'Kiegészítők',
        'Samsung'   => 'Samsung',
        'Android'   => 'Android',
        'egyeb'     => 'Egyéb',
    ];

    const TYPES_CHECK = [
        'iPhone',
        'iPad',
        'Watch',
        'MacBook',
        'iMac',
        'Others',
        'Samsung',
        'Android',
        'egyeb',
    ];

    /*  A+: hibátlan
A : szinte hibátlan ( ide tartozik még a A/AB )
AB: szép, normál állapotú ( ide tartozik még a AB/B )
B: használt állapotú ( B/BC, BC )
D: törött, sérült állapotú
Felújított: felújított, teljesen hibátlan
*/
    const DEVICE_STATES = [
        'A+' => 'Hibátlan',
        'A'  => 'Szinte hibátlan',
        'AB' => 'Szép, normál állapotú',
        'B'  => 'Használt állapotú',
        'BC' => 'Használt állapotú',
        'C'  => 'Használt állapotú',
        'D'  => 'Törött, sérült állapotú',
        'Felújított' => 'Felújított, teljesen hibátlan',
    ];

    // állapotok
    const DEVICE_STATUS = [
        'Hibátlan'                  => "hibátlan",
        "Összességében szép"        => "nagyon szép, szinte hibátlan",
        "Enyhén mikrokarcos"        => "szép állapot",
        "Enyhén kopott"             => "pici kopás van rajta",
        "Közepesen mikrokarcos"     => "jó állapot, apróbb karcok vannak rajta",
        "Közepesen kopott"          => "jó állapot, apróbb kopások vannak rajta",
        "Erősen mikrokarcos"        => "használt állapot, vannak rajta karcok",
        "Erősen kopott"             => "használt állapot, vannak rajta kopások",
        "Kiskarcos"                 => "apróbb karcok vannak rajta",
        "Erősen kiskarcos"          => "használt állapot, vannak rajta karcok",
        "Erősen karcos"             => "használt állapot, vannak rajta karcok",
    ];

    // eszköz állapot típusok
    const DEVICE_STATUS_NAMES = [
        'iPhone'        => ['keret', 'hatlap', 'kijelzo'],
        'iPad'          => ['keret', 'hatlap', 'kijelzo'],
        'Watch'         => ['keret', 'hatlap', 'kijelzo'],
        'MacBook'       => ['fedlap', 'hatlap', 'kijelzo'],
        'iMac'          => ['hatlap', 'kijelzo'],
        'MacMini'       => ['haz'],
    ];

    const ATRR_TYPES = [
        'iPhone'    => 'IPhone',
        'iPad'      => 'IPad',
        'Watch'     => 'Apple Watch',
        'MacBook'   => 'MacBook',
        'iMac'      => 'IMac',
        'Others'    => 'Kiegészítők',
        'Samsung'   => 'Samsung',
        'Android'   => 'Android',
        'egyeb'     => 'Egyéb',
        'All'       => 'Összes',
    ];

    const IMEI_103 = [
        'Model Description' => 'Model leírása',
        'Model'             => 'Modell',
        'IMEI'              => 'IMEI',
        'Serial Number'     => 'Sorozatszám',
        'IMEI2'             => 'IMEI2',
        'MEID'              => 'MEID',
        'Warranty Status'   => 'Garancia státusza',
        'Estimated Purchase Date' => 'Vásárlás dátuma',
        'Demo Unit'         => 'Demo egység',
        'Loaner Device'     => 'Kölcsönzött eszköz',
        'Replaced Device'   => 'Cserélt eszköz',
        'Replacement Device' => 'Csere eszköz',
        'Refurbished Device' => 'Felújított eszköz',
        'Purchase Country'  => 'Vásárlás országa',
        'Locked Carrier'    => 'Zárolt szolgáltató',
        'Sim-Lock Status'   => 'Sim-Lock státusza',
    ];

    const IMEI_8 = [
        'Description'       => 'Leírás',
        'Model'             => 'Modell',
        'IMEI'              => 'IMEI',
        'IMEI2'             => 'IMEI2',
        'MEID'              => 'MEID',
        'Serial Number'     => 'Sorozatszám',
        'Warranty Status'   => 'Garancia státusza',
        'Purchase Date'     => 'Vásárlás dátuma',
        'Replaced Device'   => 'Cserélt eszköz',
        'SIM-Lock'          => 'Sim-Lock',
    ];

    const IMEI_30 = [
        'Model Description' => 'Megnevezés',
        'Model'             => 'Modell',
        'IMEI'              => 'IMEI',
        'IMEI2'             => 'IMEI2',
        'MEID'              => 'MEID',
        'Serial Number'     => 'Sorozatszám',
        'Warranty Status'   => 'Garancia státusza',
        'Estimated Purchase Date' => 'Vásárlás dátuma',
        'iCloud Lock'       => 'iCloud zárolás',
        'iCloud Status'     => 'iCloud státusza',
        'Demo Unit'         => 'Demo egység',
        'Loaner Device'     => 'Kölcsönzött eszköz',
        'Replaced Device'   => 'Cserélt eszköz',
        'Replacement Device' => 'Csere eszköz',
        'Refurbished Device' => 'Felújított eszköz',
        'Blacklist Status'  => 'Feketelistás státusz',
        'Purchase Country'  => 'Vásárlás országa',
        'Sim-Lock Status'   => 'Sim-Lock státusz',
    ];

    /*  "result": {
        "Search Term": "350000026537916",
        "IMEI1": "350000026537916",
        "IMEI2": "359969536537916",
        "Serial Number": "R58NB1ZW37F",
        "Manufacturer": "Samsung Electronics Vietnam Thai Nguyen Co., Ltd. (SEVT)",
        "Full Name": "MOBILE SM2A715F BLACK TMH",
        "Model Number": "SM-A715FZKUTMH",
        "Model Name": "Galaxy A71",
        "Production Date": "11 November 2020",
        "Purchase Date": "12 November 2020",
        "Warranty Until": "12 November 2021",
        "Warranty Status": "Warranty Expired",
        "Carrier": "T-Mobile Hungary"
    }, */

    const IMEI_80 = [
        'Search Term'       => 'Lekérdezett azonosító',
        'IMEI1'             => 'IMEI1',
        'IMEI2'             => 'IMEI2',
        'Serial Number'     => 'Sorozatszám',
        'Manufacturer'      => 'Gyártó',
        'Full Name'         => 'Teljes név',
        'Model Number'      => 'Modell szám',
        'Model Name'        => 'Modell név',
        'Production Date'   => 'Gyártás dátuma',
        'Purchase Date'     => 'Vásárlás dátuma',
        'Warranty Until'    => 'Garancia lejárati dátuma',
        'Warranty Status'   => 'Garancia státusza',
        'Carrier'           => 'Szolgáltató',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('main')->withResponsiveImages();
        $this->addMediaConversion('gallery')->withResponsiveImages();
    }

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('name', 'like', '%' . $query . '%')
            ->orWhere('type', 'like', '%' . $query . '%');
    }

    protected function asJson($value)
    {
        /**
         * Alter Cast
         * Default is altering unicode
         */
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function maincategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    public function shops()
    {
        return $this->belongsToMany(Shop::class, 'product_shop');
    }

    // has many MyFavorite
    public function favorites()
    {
        return $this->hasMany(MyFavorite::class);
    }

    // function to check if it is favorite. We add the user_id and check it in the MyFavorite table
    public function isFavorite($user_id)
    {
        return MyFavorite::where('user_id', $user_id)->where('product_id', $this->id)->exists();
    }
}
