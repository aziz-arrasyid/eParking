<?php

namespace App\Http\Controllers;

use App\Models\GajiBulanan;
use Midtrans\Config;
use App\Models\Jukir;
use App\Models\Parkir;
use App\Models\Payment;
use App\Models\Transport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;

class dashboardJukirController extends Controller
{
    public function index(){
        $DataDiri = Jukir::where('user_id', auth()->user()->id)->first();
        $gajiBulanan = GajiBulanan::where('jukir_id', $DataDiri->id)->get();
        // dd($gajiBulanan, $DataDiri);

        return view('jukir.index')->with([
            'DataDiri' => $DataDiri,
            'Kendaraan' => Transport::all(),
            'GajiBulanan' => $gajiBulanan,
        ]);
    }

    public function serverSide()
    {
        $jukir = Jukir::where('user_id', Auth()->user()->id)->first();


        $query = Parkir::with('transport', 'jukir')->where('jukir_id', $jukir->id); // Menggunakan Eloquent 'with' untuk mengambil data relasi 'user'

        return DataTables::of($query)->make(true);
        // return DataTables::of(Student::query())->make(true);

    }

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

    public function paymentTest(Request $request)
    {
        $snapToken = "70c9d0f8-5fec-44c7-bf58-f58a53878294";

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode(env('MIDTRANS_SERVER_KEY')),
        ])->get("https://app.midtrans.com/snap/v1/transactions/$snapToken");

            $transactionData = $response->json();
            dd($response->status());
        return view('payment.index')->with([
            'snapToken' => 'd5446389-8da7-439c-a2b3-e69485179d86',
        ]);
    }
}
