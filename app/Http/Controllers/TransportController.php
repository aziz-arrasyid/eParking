<?php

namespace App\Http\Controllers;

use App\Models\Parkir;
use App\Models\Transport;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.dataJenisKendaraan.index')->with([
            'Transport' => Transport::all(),
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
        $request->validate([
                'jenisKendaraan' => 'required',
                'hargaParkir' => 'required',
            ],
            [
                'jenisKendaraan.required' => 'Jenis kendaraan tidak boleh kosong',
                'hargaParkir.required' => 'Harga parkir tidak boleh kosong',
            ]
        );

        $transport = Transport::create($request->all());

        return redirect()->route('data-kendaraan.index')->with('success','Data berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transport $data_kendaraan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transport $data_kendaraan)
    {
        return response()->json($data_kendaraan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transport $data_kendaraan)
    {
        $request->validate([
                'jenisKendaraan' => 'required',
                'hargaParkir' => 'required',
            ],
            [
                'jenisKendaraan.required' => 'Jenis kendaraan tidak boleh kosong',
                'hargaParkir.required' => 'Harga parkir tidak boleh kosong',
            ]
        );

        $data_kendaraan->update($request->all());

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transport $data_kendaraan)
    {
        Parkir::where('transport_id', $data_kendaraan->id)->delete();

        $data_kendaraan->delete();

        return response()->json();
    }
}
