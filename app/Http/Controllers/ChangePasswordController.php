<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jukir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('password.index')->with([
            'title' => 'Profile',
            'DataDiri' => Jukir::where('user_id', auth()->user()->id)->first(),
        ]);
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ],[
            'current_password.required' => 'current password tidak boleh kosong',
            'password.required' => 'password tidak boleh kosong',
            'password.confirmed' => 'password baru dengan password confirm tidak sama',
            'password_confirmation.required' => 'password confirm tidak boleh kosong'
        ]
        );

        $user = User::find(Auth()->user()->id);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect('/profile#password')->with('error', 'Kata Sandi Lama Salah');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/profile#password')->with('success', 'Kata Sandi Berhasil Diubah');
    }
}
