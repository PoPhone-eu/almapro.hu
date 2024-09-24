<?php

namespace App\Http\Controllers\Menu;

use Stripe\Charge;
use Stripe\Stripe;
use App\Models\User;
use App\Models\Product;
use App\Models\UserPoint;
use App\Models\ApiSetting;
use App\Models\UserPayment;
use Illuminate\Http\Request;
use App\Models\LegalDocument;
use App\Services\SzamlazasService;
use App\Http\Controllers\Controller;
use App\Services\BannerRotationService;
use Illuminate\Support\Facades\Session;

class MenuController extends Controller
{
    // iphone menu
    public function welcome()
    {
        //$banners = BannerRotationService::getRandomBanners('top', 'home');
        return view('welcome');
    }

    // iphone menu
    public function iphone()
    {
        $product_type = 'iPhone';
        //$banners = BannerRotationService::getRandomBanners('top', 'iPhone');
        return view('menus.iphone', compact('product_type'));
    }

    // ipad menu
    public function ipad()
    {
        $product_type = 'iPad';
        //$banners = BannerRotationService::getRandomBanners('top', 'iPad');
        return view('menus.ipad', compact('product_type'));
    }

    // apple watch menu
    public function applewatch()
    {
        $product_type = 'Watch';
        //$banners = BannerRotationService::getRandomBanners('top', 'Watch');
        return view('menus.applewatch', compact('product_type'));
    }

    // macbook menu
    public function macbook()
    {
        $product_type = 'MacBook';
        //$banners = BannerRotationService::getRandomBanners('top', 'MacBook');
        return view('menus.macbook', compact('product_type'));
    }

    // imac menu
    public function imac()
    {
        $product_type = 'iMac';
        //$banners = BannerRotationService::getRandomBanners('top', 'iMac');
        return view('menus.imac', compact('product_type'));
    }

    // others menu
    public function others()
    {
        $product_type = 'Others';
        //$banners = BannerRotationService::getRandomBanners('top', 'Others');
        return view('menus.others', compact('product_type'));
    }

    // others samsung
    public function samsung()
    {
        $product_type = 'Samsung';
        //$banners = BannerRotationService::getRandomBanners('top', 'Samsung');
        return view('menus.samsung', compact('product_type'));
    }

    // others android
    public function android()
    {
        $product_type = 'Android';
        //$banners = BannerRotationService::getRandomBanners('top', 'Android');
        return view('menus.android', compact('product_type'));
    }

    // others egyeb
    public function egyeb()
    {
        $product_type = 'egyeb';
        //$banners = BannerRotationService::getRandomBanners('top', 'egyeb');
        return view('menus.egyeb', compact('product_type'));
    }

    // searchresult
    public function searchresult(Request $request)
    {
        $search = $request->search;
        return view('menus.searchresult', compact('search'));
    }

    // documents
    public function documents($slug)
    {
        $document = LegalDocument::where('slug', $slug)->first();
        if ($document == null) {
            return redirect()->route('welcome');
        }
        return view('menus.document', compact('document'));
    }

    // myinvoices
    public function myinvoices()
    {
        return view('menus.myinvoices');
    }

    // show productpage
    public function showproduct($slug)
    {
        $product = Product::where('slug', $slug)->first();
        if ($product == null) {
            return redirect()->route('welcome');
        }
        $product_id = $product->id;
        return view('menus.productpage', compact('product_id'));
    }

    public function profiloldal($seller_id)
    {
        return view('public.profile.seller-profile', compact('seller_id'));
    }

    // stripe payment
    public function payment()
    {
        $user = auth()->user();
        $user_points = getUserPoints($user->id);
        return view('menus.stripe.payment', compact('user_points'));
    }

    public function stripe(Request $request)
    {
        $user = auth()->user();
        $user_points = getUserPoints($user->id);
        // save stripe payment. Now as a test we assume the payment was successful so we simple add the points to the user by creating new userPoint:
        UserPoint::create([
            'points' => $request->amount + $user_points,
            'description' => 'Stripe payment: pontok vásárlása',
            'modified_by' => 'user',
            'user_id' => $user->id,
        ]);
        return redirect('/myproducts');
    }

    public function stripesubmit(Request $request)
    {
        $input = $request->all();
        $api_setting = ApiSetting::first();
        $stripe = new \Stripe\StripeClient($api_setting->stripe_secret);

        $redirectUrl = route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}';
        $response =  $stripe->checkout->sessions->create([
            'success_url' => $redirectUrl,
            'payment_method_types' => ['link', 'card'],
            'automatic_tax' => [
                'enabled' => true,
            ],
            'line_items' => [
                [
                    'price_data'  => [
                        'product_data' => [
                            'name' => 'Egyenleg feltöltés',
                        ],
                        'unit_amount'  => 100 * $input['amount'],
                        'currency'     => 'HUF',
                    ],
                    'quantity'    => 1
                ],
            ],
            'mode' => 'payment',
            'allow_promotion_codes' => false
        ]);

        return redirect($response['url']);
    }

    public function stripeCheckoutSuccess(Request $request)
    {
        $input = $request->all();
        $api_setting = ApiSetting::first();
        $stripe = new \Stripe\StripeClient($api_setting->stripe_secret);

        $checkout_session =   $stripe->checkout->sessions->retrieve($input['session_id'], []);
        if ($checkout_session['payment_status'] == 'paid') {
            $user = auth()->user();
            $user_points = getUserPoints($user->id);
            $amount = $checkout_session['amount_total'] / 100;
            // save stripe payment. Now as a test we assume the payment was successful so we simple add the points to the user by creating new userPoint:
            UserPoint::create([
                'points' => $amount + $user_points,
                'points_change' => $amount,
                'description' => 'Stripe payment: pontok vásárlása',
                'modified_by' => 'user',
                'user_id' => $user->id,
            ]);
            $user_payment = new UserPayment();
            $user_payment->user_id = auth()->user()->id;
            $user_payment->name = auth()->user()->full_name;
            $user_payment->stripe_id = $checkout_session['payment_intent'];
            $user_payment->stripe_status = $checkout_session['payment_status'];
            $user_payment->amount = $amount;
            $user_payment->uuid = $checkout_session['id'];
            $user_payment->quantity = 1;
            $user_payment->save();
            SzamlazasService::createInvoice($user_payment->id);
            return redirect('/myproducts');
        }

        return view('/');
    }

    /**
     * create curl request
     * we have created seperate method for curl request
     * instead of put code at every request
     *
     * @return Stripe response
     */
    private function curlPost($url, $data, $headers)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $response = json_decode($response, true);
        curl_close($ch);

        return $response;
    }

    public function imeiindex()
    {
        return view('menus.imeiindex');
    }
}
