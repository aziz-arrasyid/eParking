<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Jukir;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class JukirControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jukir = Jukir::all();

        return response()->json($jukir);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'age' => 'required',
            'phoneNumber' => 'required',
        ], [
            'name.required' => "Nama jukir tidak boleh kosong",
            'age.required' => "Umur jukir tidak boleh kosong",
            'phoneNumber.required' => "Nomor HP jukir tidak boleh kosong",
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $name = str_replace(' ', '_', $request->name);

        $username = $name . mt_rand(1000, 9999);

        // Memastikan username unik
        while (User::where('username', $username)->exists()) {
            $username = $name . mt_rand(1000, 9999);
        }

        $user = User::create([
            'username' => $username,
            'role' => '1', // Mengganti '1' menjadi 'jukir'
            'password' => bcrypt('jukir'),
        ]);

        $jukir = Jukir::create([
            'name' => $request->name,
            'age' => $request->age,
            'phoneNumber' => $request->phoneNumber,
            'user_id' => $user->id,
        ]);

        return response()->json(['message' => 'Data berhasil ditambahkan', 'data_jukir' => $jukir, 'data_user' => $user], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Jukir $jukir)
    {
        return response()->json(['data' => $jukir]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $jukir)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $jukir)
    {
        //
    }
}
