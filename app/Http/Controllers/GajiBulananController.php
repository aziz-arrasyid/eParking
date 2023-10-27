<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\GajiBulanan;
use Illuminate\Http\Request;

class GajiBulananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $now = Carbon::now();
        $month = $now->month;
        $year = $now->year;
        $monthNameId = [
            'Desember',
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
        ];
        // dd($now->month, $monthNameId[$month], $year, $monthNameId[$month]. ' '. $year, $now);

        return view('admin.dataGajiBulanan.index')->with([
            'title' => 'Data Upah'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(GajiBulanan $data_gaji_bulanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GajiBulanan $data_gaji_bulanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GajiBulanan $data_gaji_bulanan)
    {
        $data_gaji_bulanan->update($request->all());

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GajiBulanan $data_gaji_bulanan)
    {
        //
    }
}
