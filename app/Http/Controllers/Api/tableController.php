<?php

namespace App\Http\Controllers\Api;

use App\Models\Jukir;
use App\Models\Parkir;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class tableController extends Controller
{
    public function tableParkir($id)
    {
        $jukir = Jukir::where('user_id', $id)->first();

        $query = Parkir::with('transport', 'jukir')->where('jukir_id', $jukir->id)->get();

        return response()->json(['data' => $query]);
    }
}
