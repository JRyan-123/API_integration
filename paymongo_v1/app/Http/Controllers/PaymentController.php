<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function webhook(Request $request)
    {

        $event = $request->input('data.attributes.type');

        $sessionId = $request->input('data.attributes.data.id');

        $payment = Payment::where('paymongo_payment_id', $sessionId)->first();

        if (!$payment) {
            Log::warning('Webhook payment not found for session ID: ' . $sessionId);

            return response()->json(['message' => 'Not found'], 200);
        }

        try {
            if ($event === 'checkout_session.payment.paid') {

                DB::transaction(function () use ($payment) {
                    $payment->update(['status' => 'paid']);
                    $payment->order->update(['status' => 'paid']);
                });

                Log::info('Payment completed for Order ID: ' . $payment->id);
            }
        } catch (\Throwable $th) {
            Log::error('Error occurred while processing webhook: ' . $th->getMessage());

            return response()->json(['message' => 'Error'], 500);
        }

        return response()->json(['message' => 'OK'], 200);
    }
}
