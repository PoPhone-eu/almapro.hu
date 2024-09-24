<?php

namespace App\Http\Controllers\Admin\Stripe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;

class PlanController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $plans = Plan::get();
        return view("admin.stripe.plans", compact("plans"));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */

    public function show(Plan $plan, Request $request)
    {
        $intent = auth()->user()->createSetupIntent();
        return view("admin.stripe.subscription", compact("plan", "intent"));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function subscription(Request $request)
    {
        $plan = Plan::find($request->plan);
        $subscription = $request->user()->newSubscription($request->plan, $plan->stripe_plan)
            ->create($request->token);
        return view("admin.stripe.subscription_success");
    }
}
