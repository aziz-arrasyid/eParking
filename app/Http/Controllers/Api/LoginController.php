<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'username dan password harus diisi'], 400);
        }

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = Auth::user();
            $name = str_replace('_', '', strtolower($user->username));
            $response = [
                'message' => 'Selamat datang ' . $name,
                'user' => $user,
            ];
            return response()->json($user);
        } else {
            return response()->json(['error' => 'username atau password salah'], 401);
        }
    }
}
