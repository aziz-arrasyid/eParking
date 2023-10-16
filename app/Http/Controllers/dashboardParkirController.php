<?php

namespace App\Http\Controllers;

use App\Models\Parkir;
use Illuminate\Http\Request;

class dashboardParkirController extends Controller
{
    public function index($no_plat)
    {
        // dd($no_plat, strtoupper($no_plat));
        $Parkir = Parkir::where('no_plat', strtoupper($no_plat))->get();
        if($Parkir->isEmpty())
        {
            // dd('kosong');
            return redirect()->back()->with('error','Data tidak tersedia atau penulisan format plat salah');
        }else{
            // dd($parkir);
            return view('history-kendaraan.index')->with([
                'Parkir' => $Parkir,
            ]);

        }
    }

    public function search()
    {
        return view('search-kendaraan.index');
    }

    public function filter($keyword)
    {

    }
}
