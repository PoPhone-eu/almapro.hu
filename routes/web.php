<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\Users\UsersTable;
use Laravel\Socialite\Facades\Socialite;
use App\Livewire\Admin\Banners\BannersAdd;
use App\Livewire\Admin\Users\CompanyTable;
use App\Livewire\Front\Menus\Searchresult;
use App\Livewire\Admin\Banners\BannersEdit;
use App\Livewire\Admin\Ratings\UserRatings;
use App\Livewire\User\Products\ShowProduct;
use App\Http\Controllers\CKEditorController;
use App\Livewire\Admin\Banners\BannersTable;
use App\Http\Controllers\Menu\MenuController;
use App\Livewire\Admin\Users\AdminUsersTable;
use App\Livewire\Front\Profile\MyProfileData;
use App\Http\Controllers\SuperadminController;
use App\Livewire\Admin\Invoices\InvoicesTable;
use App\Livewire\Front\Products\CreateProduct;
use App\Livewire\Messages\Sellers\EditMessage;
use App\Http\Controllers\GoogleLoginController;
use App\Livewire\Admin\Settings\ApiKeysSetting;
use App\Livewire\Admin\Users\PrivateUsersTable;
use App\Http\Controllers\Company\ShopController;
use App\Livewire\Admin\Settings\SiteSettingEdit;
use App\Livewire\Admin\Users\PersonalUsersTable;
use App\Http\Controllers\FacebookLoginController;
use App\Livewire\Front\Menus\CustomerOrdersTable;
use App\Livewire\User\Products\UserProductsTable;
use App\Livewire\Admin\Categories\CategoriesTable;
use App\Http\Controllers\Admin\User\UserController;
use App\Livewire\Admin\Product\Products\AddNewProduct;
use App\Livewire\Admin\Product\Products\ProductsTable;
use App\Http\Controllers\Admin\LegalDocumentController;
use App\Http\Controllers\Products\MyProductsController;
use App\Livewire\Admin\Product\Attributes\AttributesTable;
use App\Livewire\Admin\Product\Attributes\AttributeValues;
use App\Http\Controllers\Messages\InternalMessageController;
use App\Http\Controllers\Admin\Product\Attribute\ProductAttributeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/testindex', function () {
    return view('testindex');
});
//Facebook
Route::get('/facebook/redirect', [FacebookLoginController::class, 'redirectToFacebook'])->name('facebook.redirect');
Route::get('/facebook/callback', [FacebookLoginController::class, 'handleFacebookCallback'])->name('facebook.callback');

Route::get('/google/redirect', [GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');
/* Route::get('/auth/redirect', function () {
    return Socialite::driver('facebook')->redirect();
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('facebook')->user();
}); */

Route::post('ckeditor/image_upload',                        [CKEditorController::class, 'upload'])->name('ckeditor.upload');

// MenuController
Route::get('/',                                             [MenuController::class, 'welcome'])->name('welcome');
Route::get('/iphone',                                       [MenuController::class, 'iphone']);
Route::get('/ipad',                                         [MenuController::class, 'ipad']);
Route::get('/applewatch',                                   [MenuController::class, 'applewatch']);
Route::get('/macbook',                                      [MenuController::class, 'macbook']);
Route::get('/imac',                                         [MenuController::class, 'imac']);
Route::get('/others',                                       [MenuController::class, 'others']);
Route::get('/samsung',                                      [MenuController::class, 'samsung']);
Route::get('/android',                                      [MenuController::class, 'android']);
Route::get('/egyeb',                                        [MenuController::class, 'egyeb']);
Route::get('/showproduct/{slug}',                           [MenuController::class, 'showproduct']);
Route::get('/searchresult',                                 [MenuController::class, 'searchresult']);
Route::get('/documents/{slug}',                             [MenuController::class, 'documents']);
Route::get('/superadmin',                                [SuperadminController::class, 'index'])->name('superadmin');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(
    function () {
        Route::get('/profiloldal/{seller_id}',                      [MenuController::class, 'profiloldal']);
        Route::get('/szamlaim',                                     [MenuController::class, 'myinvoices'])->name('myinvoices.index');
        Route::get('/payment',                                      [MenuController::class, 'payment']);
        Route::any('/stripe',                                       [MenuController::class, 'stripe']);
        Route::any('/stripesubmit',                                 [MenuController::class, 'stripesubmit'])->name('stripesubmit');
        Route::any('/stripesuccess',                                [MenuController::class, 'stripeCheckoutSuccess'])->name('stripe.success');
        Route::any('/telefon-adat-lekerdezes',                      [MenuController::class, 'imeiindex'])->name('imei.index');
    }
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // SuperadminController
    Route::get('/profilom', function () {
        return view('public.profile.profilepage');
    });
    // Front-end: user's profile
    Route::get('/profiledata', function () {
        return view('public.profile.myprofiledata');
    });
    Route::get('/customer-orders', function () {
        return view('public/orders/index');
    });
    Route::get('/myorders', function () {
        return view('public/orders/myorders');
    });

    Route::get('/admindash',                                AdminDashboard::class)->name('admindash');

    Route::get('/personal',                                 PersonalUsersTable::class);
    Route::get('/companies',                                CompanyTable::class);
    Route::get('/privates',                                 PrivateUsersTable::class);
    Route::get('/admins',                                   AdminUsersTable::class);
    Route::get('/userratings/{user_id}',                    UserRatings::class);
    Route::get('/sitesettings',                             SiteSettingEdit::class);
    // user's shops
    Route::get('myfavorites',                               [MyProductsController::class, 'myfavorites']);
    Route::resource('myproducts',                           MyProductsController::class);
    Route::resource('legaldocuments',                       LegalDocumentController::class);

    Route::get('/apikeys',                                  ApiKeysSetting::class);

    // products
    Route::get('/addproduct/{user_id}/{attr_type}/{category_id}/{subcategory_id}',    AddNewProduct::class);
    Route::get('/products',                                 ProductsTable::class);

    // invoices
    Route::get('/invoices-table',                           InvoicesTable::class);

    // banners for admin
    Route::get('/banners',                                  BannersTable::class);
    Route::get('/add-banner',                               BannersAdd::class);
    Route::get('/edit-banner/{banner_id}',                  BannersEdit::class);

    // product attributes
    Route::get('/attrvalues/{attr_id}',                     AttributeValues::class);
    Route::get('/attributes',                               AttributesTable::class);
    Route::resource('productattributes',                    ProductAttributeController::class);

    // categories
    Route::get('/categories',                               CategoriesTable::class);

    /*     Route::get('plans',                                     [PlanController::class, 'index']);
    Route::get('plans/{plan}',                              [PlanController::class, 'show'])->name("plans.show");
    Route::post('subscription',                             [PlanController::class, 'subscription'])->name("subscription.create"); */

    // user controller
    Route::resource('users',                                UserController::class);

    // user's shops
    Route::resource('shops',                                ShopController::class);

    // user's products
    Route::get('userproducts/{id}',                         UserProductsTable::class);
    Route::get('userproduct/{slug}',                        ShowProduct::class);

    // messages
    // internal messages
    Route::resource('messages',                             InternalMessageController::class);
});
