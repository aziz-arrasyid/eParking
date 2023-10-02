<?php

namespace App\Http\Controllers;

use App\Models\Parkir;
use Illuminate\Http\Request;

class dashboardParkirController extends Controller
{
    public function index($no_plat)
    {
        preg_match('/^([a-zA-Z]+)(\d+)([a-zA-Z]+)$/', $no_plat, $matches);
        $data = strtoupper($matches[1]. ' '. $matches[2].' '. $matches[3]);
        $historys = Parkir::where('no_plat', $data)->get();
        return view('parkiran.index')->with([
            'tes' => $data,
            'History' => $historys,
        ]);
    }
}
