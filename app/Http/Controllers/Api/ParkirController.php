<?php

namespace App\Http\Controllers\Api;

use App\Models\Parkir;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ParkirController extends Controller
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

        $order = Payment::where('order_id', $orderId)->first();
        $parkir = Parkir::find($order->id);
        if(!$order)
        {
            return response()->json([
                'message' => 'invalid order'
            ], 400);
        }

        if($transactionStatus == 'settlement')
        {
            $parkir->status = 'paid';
            $parkir->payment_type = $paymentType;
            $parkir->save();

            $response = [
                'status' => 'success',
                'message' => 'Transaksi berhasil.'
            ];
        }elseif($transactionStatus == 'expire')
        {
            $parkir->status = 'unpaid';
            $parkir->save();
        }

        return response()->json($response);
    }
}
