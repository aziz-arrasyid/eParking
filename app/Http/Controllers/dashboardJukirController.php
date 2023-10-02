<?php

namespace App\Http\Controllers;

use App\Models\Jukir;
use App\Models\Parkir;
use App\Models\Transport;
use Illuminate\Http\Request;
use Midtrans\Config;
use Yajra\DataTables\Facades\DataTables;

class dashboardJukirController extends Controller
{
    public function index(){
        return view('jukir.index')->with([
            'DataDiri' => Jukir::where('user_id', auth()->user()->id)->first(),
            'Kendaraan' => Transport::all(),
        ]);
    }

    public function serverSide()
    {
        $query = Parkir::with('transport', 'jukir'); // Menggunakan Eloquent 'with' untuk mengambil data relasi 'user'

        return DataTables::of($query)->make(true);
        // return DataTables::of(Student::query())->make(true);

    }

    public function payment()
    {
        // // Set your Merchant Server Key
        // \Midtrans\Config::$serverKey = 'YOUR_SERVER_KEY';
        // // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        // \Midtrans\Config::$isProduction = false;
        // // Set sanitization on (default)
        // \Midtrans\Config::$isSanitized = true;
        // // Set 3DS transaction for credit card to true
        // \Midtrans\Config::$is3ds = true;

        // $params = array(
        //     'transaction_details' => array(
        //         'order_id' => rand(),
        //         'gross_amount' => 10000,
        //     ),
        //     'customer_details' => array(
        //         'first_name' => 'budi',
        //         'last_name' => 'pratama',
        //         'email' => 'budi.pra@example.com',
        //         'phone' => '08111222333',
        //     ),
        // );

        // $snapToken = \Midtrans\Snap::getSnapToken($params);
        return view('payment.index');
    }
}
