<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

//    public function login(Request $request)
// {
//     // validasi input
//     $credentials = $request->validate([
//         'email' => 'required|email',
//         'password' => 'required',
//     ]);

//     // cek kredensial
//    if (Auth::attempt($credentials)) {
//     $request->session()->regenerate();
//     return redirect()->intended('/app/dashboard');
// }

// Auth::logout();


//     // kalau gagal
//     return back()->withErrors([
//         'email' => 'Email atau password salah.',
//     ]);
// }

public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/app/dashboard');
    }

    // Debug tambahan
    logger()->error('Login failed for email: ' . $request->email);

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ]);
}


public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
}

}