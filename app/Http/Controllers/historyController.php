<?php

namespace App\Http\Controllers;

use App\Models\Parkir;
use Illuminate\Http\Request;

class historyController extends Controller
{
    public function index($no_plat)
    {
        dd($no_plat);
        // dd($request->all());
        // return view('history-kendaraan.index')->with([
        //     'parkir',
        // ]);

        // $request->validate([
        //         'no_plat' => 'required',
        //     ],
        //     [
        //         'no_plat.required' => 'Nomor plat tidak boleh kosong',
        //     ]
        // );

        // $parkir = Parkir::where('no_plat', strtoupper($request->no_plat))->get();
        // if($parkir->isEmpty()){
        //     // dd('gak ada nomor plat');
        //     return redirect()->back()->with('error','Nomor plat tidak ada atau format penulisan plat salah');
        // }else{
        //     // return redirect()->route('history-parkir')->with([
        //     //     'success',
        //     //     'parkir' => $parkir,
        //     // ]);
        //     return view('history-kendaraan.index')->with([
        //         'parkir' => $parkir,
        //     ]);

        // }
    }
}
