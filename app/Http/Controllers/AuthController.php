<?php
/**
 * Module: AuthController
 * Created: 2026-06-23
 * Author: Raditya Natha Azra
 * Synopsis: Controller untuk autentikasi pengguna (login, logout)
 * 
 * Functions:
 *   - showLogin() : view -> tampilkan form login
 *   - login(Request) : redirect -> proses login
 *   - logout(Request) : redirect -> proses logout
 * 
 * Input Parameters:
 *   - username : string -> username pengguna
 *   - password : string -> kata sandi
 * 
 * Return Values:
 *   - 0 : gagal
 *   - 1 : berhasil
 */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['username' => 'Username atau password salah']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
