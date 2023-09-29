<?php

namespace App\Http\Controllers;

use App\Models\Jukir;
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
}
