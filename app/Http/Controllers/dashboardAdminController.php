<?php

namespace App\Http\Controllers;

use App\Models\Jukir;
use App\Models\Parkir;
use App\Models\GajiBulanan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class dashboardAdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function serverSide()
    {
        $query = Jukir::with('user'); // Menggunakan Eloquent 'with' untuk mengambil data relasi 'user'

        return DataTables::of($query)->make(true);
    }

    public function serverSideUpah()
    {
        $query = GajiBulanan::with('jukir'); // Menggunakan Eloquent 'with' untuk mengambil data relasi 'user'

        // Jumlahkan semua data dengan payment_type 'cash'
        $totalCash = Parkir::where('payment_type', 'cash')->count();

        // Jumlahkan semua data dengan payment_type 'qris'
        $totalQris = Parkir::where('payment_type', 'qris')->count();


        return DataTables::of($query)
        ->addColumn('totalCash', function () {
            $totalCash = Parkir::where('payment_type', 'cash')->count();
            return $totalCash;
        })
        ->addColumn('totalQris', function () {
            $totalQris = Parkir::where('payment_type', 'qris')->count();
            return $totalQris;
        })
        ->make(true);
        // return DataTables::of($query)->with('totalCash', $totalCash)->with('totalQris', $totalQris)->make(true);
         // $data = [
        //     'data' => $query,
        //     'totalCash'=> $totalCash,
        //     'totalQris'=> $totalQris
        // ];

        // return DataTables::of($data)->make(true);
    }
}
