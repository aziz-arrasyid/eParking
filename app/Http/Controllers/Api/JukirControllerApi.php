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
    public function update(Request $request, Jukir $jukir)
    {
        $validator = Validator::make($request->all(),[
                'name' => 'required',
                'username' => 'required',
                'age' => 'required',
                'phoneNumber' => 'required',
            ],
            [
                'name.required' => 'Nama jukir tidak boleh kosong',
                'username.required' => 'Username jukir tidak boleh kosong',
                'age.required' => 'Umur jukir tidak boleh kosong',
                'phoneNumber.required' => 'Nomor HP jukir tidak boleh kosong',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Cek jika ada pengguna lain dengan username yang sama
        $existingUser = User::where('username', $request->username)
                            ->where('id', '!=', $jukir->user->id) // Excluding the current user
                            ->first();

        if ($existingUser) {
            return response()->json(['error' => 'Username sudah digunakan oleh jukir lain'], 422);
        }

        $jukir->update([
            'name' => $request->name,
            'age' => $request->age,
            'phoneNumber' => $request->phoneNumber,
        ]);

        if ($request->username != $jukir->user->username) {
            $jukir->user->update([
                'username' => $request->username,
            ]);
        }

        return response()->json(['message' => 'Data berhasil di update', 'data' => $jukir]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jukir $jukir)
    {
        User::where('id', $jukir->user_id)->delete();

        $jukir->delete();
        return response()->json(['message' => 'Data berhasil di hapus']);
    }
}
