<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Jukir;
use App\Models\Parkir;
use App\Models\Payment;
use App\Models\Transport;
use App\Models\GajiBulanan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ParkirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('jukir.dataParkir.index')->with([
            'title' => 'Data Parkir',
            'DataDiri' => Jukir::where('user_id', auth()->user()->id)->first(),
            'Kendaraan' => Transport::all(),
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
                'transport_id' => 'required',
                'jukir_id' => 'required',
                'no_plat' => 'required',
            ],
            [
                'transport_id' => 'jenis kendaraan tidak boleh kosong',
                'jukir_id' => 'id jukir tidak boleh kosong',
                'no_plat' => 'No plat kendaraan tidak boleh kosong',
            ]
        );

        $upperString = strtoupper($request->no_plat);

        $parkir = Parkir::create([
            'transport_id' => $request->transport_id,
            'jukir_id' => $request->jukir_id,
            'no_plat' => $upperString,
        ]);

        // dd('eParking'.$parkir->id.$request->jukir_id.rand());
        return redirect()->route('data-parkir.index')->with('success','Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Parkir $data_parkir)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Parkir $data_parkir)
    {
        if($data_parkir->status == 'unpaid')
        {
            // Hitung jarak waktu dalam jam
            $created_at = Carbon::parse($data_parkir->created_at);
            $now = Carbon::now();
            $jarakWaktuJam = $now->diffInHours($created_at);

            // Hitung harga parkir berdasarkan tarif per jam
            $hargaPerJam = $data_parkir->transport->hargaParkir; // Harga per jam

            if($jarakWaktuJam > 0)
            {
                $hargaParkir = $jarakWaktuJam * $hargaPerJam;

                $totalHarga = $data_parkir->transport->hargaParkir + $hargaParkir;
                // $data_parkir->hargaPerJam = $hargaParkir;
                $data_parkir->update([
                    'hargaPerJam' => $totalHarga
                ]);
            }
        }

        $data_parkir->load('transport', 'jukir');
        return response()->json($data_parkir);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Parkir $data_parkir)
    {
        $request->validate([
                'transport_id' => 'required',
                'jukir_id' => 'required',
                'no_plat' => 'required',
                'status' => 'required',
            ],
            [
                'transport_id.required' => 'Jenis kendaran tidak boleh kosong',
                'jukir_id.required' => 'id jukir tidak boleh kosong',
                'no_plat.required' => 'No plat tidak boleh kosong',
                'status.required' => 'bayar parkir tidak boleh kosong',
            ]
        );

        $upperString = strtoupper($request->no_plat);

        $data_parkir->update([
            'transport_id' => $request->transport_id,
            'jukir_id' => $request->jukir_id,
            'no_plat' => $upperString,
            'status' => $request->status,
        ]);

        $transport = Transport::find($request->transport_id);

        $untung = $transport->hargaParkir - $transport->pajak;

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

        if( $request->status == 'paid'){
            $data_parkir->update([
                'untungBersih' => $untung,
            ]);

            if(!GajiBulanan::where('bulan', $monthNameId[$month]. ' '. $year)->where('jukir_id', $request->jukir_id)->exists()){
                if($data_parkir->payment_type == 'cash'){
                    GajiBulanan::create([
                        'jukir_id' => $request->jukir_id,
                        'bulan' => $monthNameId[$month]. ' '. $year,
                        'cashPajak' => $data_parkir->hargaPerJam,
                    ]);
                }
            }else{
                $gajiBulanan = GajiBulanan::where('jukir_id', $request->jukir_id)->where('bulan', $monthNameId[$month].' '. $year)->first();
                if($data_parkir->payment_type == 'cash'){
                    $gajiBulanan->update([
                        'cashPajak' => $gajiBulanan->cashPajak + $data_parkir->hargaPerJam,
                    ]);
                }
            }
        }else{
            $data_parkir->update([
                'untungBersih' => 0,
            ]);

            $gajiBulanan = GajiBulanan::where('jukir_id', $request->jukir_id)->where('bulan', $monthNameId[$month].' '. $year)->first();
                if($data_parkir->payment_type == 'cash'){
                    if($gajiBulanan->cashPajak > 0){
                        $gajiBulanan->update([
                            'cashPajak' => $gajiBulanan->cashPajak - $data_parkir->hargaPerJam,
                        ]);
                    }
                }
        }

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Parkir $data_parkir)
    {
        $data_parkir->delete();

        return response()->json();
    }
}
