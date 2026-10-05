<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class CheckoutServices
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected PaymentService $payMongo,
    )
    {
        //
    }


    public function orderCheckout($amount, $paymentMethod)
    {
        return DB::transaction(function () use ($amount, $paymentMethod) {
            $order = Order::create([
                'amount' => $amount,
            ]);

            $session = $this->payMongo->createCheckoutSession(
                $amount,
                $paymentMethod,
                route('payment.success'),
                route('payment.cancel')
            );

            Payment::create([
                'order_id' => $order->id,
                'paymongo_payment_id' => $session['id'],
                'amount' => $amount,
                'status' => 'pending',
            ]);
            return $session;
        });

        
    }
}
