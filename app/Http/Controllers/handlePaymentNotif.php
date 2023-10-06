<?php

namespace App\Http\Controllers;

use App\Models\Parkir;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class handlePaymentNotif extends Controller
{
    public function __invoke(Request $request)
    {
        $payload = $request->all();

        Log::info('incoming-midtrans', [
            'payload' => $payload,
        ]);

        $orderId = $payload['order_id'];
        $statusCode = $payload['status_code'];
        $grossAmount = $payload['gross_amount'];

        $requestSignature = $payload['signature_key'];

        $paymentType = $payload['payment_type'];

        $signature = hash('sha512', $orderId.$statusCode.$grossAmount.env('MIDTRANS_SERVER_KEY'));

        if($signature != $requestSignature)
        {
            return response()->json([
                'message' => 'invalid signature'
            ], 401);
        }

        $transactionStatus = $payload['transaction_status'];

        // $order = Payment::where('order_id', $orderId)->first();
        // if(!$order)
        // {
        //     return response()->json([
        //         'message' => 'invalid order'
        //     ], 400);
        // }

        // if($transactionStatus == 'settlement')
        // {
        //     $order->delete();
        // }elseif($transactionStatus == 'expire')
        // {
        //     $order->status = 'expired';
        // }

        return response()->json(['message' => 'success']);
    }
}
