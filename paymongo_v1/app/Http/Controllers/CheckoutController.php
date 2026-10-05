<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    public function __construct(
        protected \App\Services\CheckoutServices $checkoutServices,
    ) {
        //
    }
    public function index()
    {
        return view('pay');
    }

    public function checkout(Request $request)
    {
        $session = $this->checkoutServices->orderCheckout($request->amount, $request->payment_method);

        return redirect($session['attributes']['checkout_url']);
    }

    public function success()
    {
        return "payment success";
    }
    public function cancel()
    {
        return "payment cancel";
    }
}
