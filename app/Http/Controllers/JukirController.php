<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jukir;
use Illuminate\Http\Request;

class JukirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.index');
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
                'name' => 'required',
                'age' => 'required',
                'phoneNumber' => 'required',
            ],
            [
                'name.required' => "Nama jukir tidak boleh kosong",
                'age.required' => "Umur jukir tidak boleh kosong",
                'phoneNumber.required' => "Nomor HP jukir tidak boleh kosong",
            ]
        );

        $name = str_replace(' ', '_', $request->name);

        $username = $name . mt_rand(1000, 9999);

        // Memastikan username unik
        while (User::where('username', $username)->exists()) {
            $username = $name . mt_rand(1000, 9999);
        }

        $user = User::create([
            'username' => $username,
            'role' => '1',
            'password' => bcrypt('jukir'),
        ]);

        Jukir::create([
            'name' => $request->name,
            'age' => $request->age,
            'phoneNumber' => $request->phoneNumber,
            'user_id' => $user->id,
        ]);


        return redirect()->route('data-jukir.index')->with('success', 'data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jukir $data_jukir)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jukir $data_jukir)
    {
        $data_jukir->load('user');
        return response()->json($data_jukir);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jukir $data_jukir)
    {
        $request->validate([
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

        // Cek jika ada pengguna lain dengan username yang sama
        $existingUser = User::where('username', $request->username)
                            ->where('id', '!=', $data_jukir->user->id) // Excluding the current user
                            ->first();

        if ($existingUser) {
            return response()->json(['error' => 'Username sudah digunakan oleh jukir lain'], 422);
        }

        $data_jukir->update([
            'name' => $request->name,
            'age' => $request->age,
            'phoneNumber' => $request->phoneNumber,
        ]);

        if ($request->username != $data_jukir->user->username) {
            $data_jukir->user->update([
                'username' => $request->username,
            ]);
        }

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jukir $data_jukir)
    {
        User::where('id', $data_jukir->user_id)->delete();

        $data_jukir->delete();
        return response()->json();
    }
}
