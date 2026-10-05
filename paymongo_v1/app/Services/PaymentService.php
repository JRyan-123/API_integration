<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaymentService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createCheckoutSession(int $amount, string $paymentMethod, string $successUrl, string $cancelUrl): array
    {
        $response = Http::withBasicAuth(config('services.paymongo.secret_key'), '')
            ->post('https://api.paymongo.com/v1/checkout_sessions', [
                'data' => [
                    'attributes' => [
                        'line_items' => [
                            [
                                'currency' => 'PHP',
                                'amount' => $amount,
                                'name' => 'Order Payment',
                                'quantity' => 1,
                            ],
                        ],
                        'payment_method_types' => [$paymentMethod],
                        'success_url' => $successUrl,
                        'cancel_url' => $cancelUrl,
                    ],
                ],
            ]);

        $response->throw();

        $session = $response->json('data');

        if (! is_array($session)) {
            throw new \UnexpectedValueException('PayMongo returned an invalid checkout session response.');
        }

        return $session;
    }
 
}
