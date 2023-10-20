<?php

namespace App\Http\Controllers\Api;

use App\Models\Parkir;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class MidtransAndroid extends Controller
{
    public function payment(Request $request)
    {
        $Parkir = Parkir::find($request->id);

        $payment = Payment::where('parkir_id', $request->id)->first();
        if(!$payment){
            $order_id = 'eParking'.$request->id.rand();
            // dd($Parkir);
            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = true;
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = true;
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = true;

            $params = array(
                'transaction_details' => array(
                    'order_id' => $order_id,
                    'gross_amount' => $Parkir->transport->hargaParkir,
                ),
                'customer_details' => array(
                    'first_name' => $Parkir->transport->jenisKendaraan,
                    'last_name' => $Parkir->no_plat,
                ),
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            Payment::create([
                'order_id' => $order_id,
                'snapToken' => $snapToken,
                'parkir_id' => $request->id,
            ]);

            return response()->json(['snapToken' => $snapToken]);
        }else{
            $snapToken = $payment->snapToken;

            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . base64_encode(env('MIDTRANS_SERVER_KEY')),
            ])->get("https://app.midtrans.com/snap/v1/transactions/$snapToken");

            if($response->status() == 400){
                $order_id = 'eParking'.$request->id.rand();
                // Set your Merchant Server Key
                \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
                // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
                \Midtrans\Config::$isProduction = true;
                // Set sanitization on (default)
                \Midtrans\Config::$isSanitized = true;
                // Set 3DS transaction for credit card to true
                \Midtrans\Config::$is3ds = true;

                $params = array(
                    'transaction_details' => array(
                        'order_id' => $order_id,
                        'gross_amount' => $Parkir->transport->hargaParkir,
                    ),
                    'customer_details' => array(
                        'first_name' => $Parkir->transport->jenisKendaraan,
                        'last_name' => $Parkir->no_plat,
                    ),
                );

                $snapToken = \Midtrans\Snap::getSnapToken($params);

                Payment::where('order_id', $payment->order_id)->update([
                    'snapToken' => $snapToken,
                    'order_id' => $order_id,
                ]);

                return response()->json(['snapToken' => $snapToken]);
            }else{
                return response()->json(['snapToken' => $payment->snapToken]);
            }
        }

    }
}
