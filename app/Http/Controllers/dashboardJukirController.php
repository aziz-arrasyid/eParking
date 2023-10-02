<?php

namespace App\Http\Controllers;

use App\Models\Jukir;
use App\Models\Parkir;
use App\Models\Transport;
use Illuminate\Http\Request;
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
}
