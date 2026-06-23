<?php
/**
 * Module: AuthController
 * Created: 2026-06-23
 * Author: Raditya Natha Azra
 * Synopsis: Controller untuk autentikasi pengguna (login, register, logout)
 * 
 * Functions:
 *   - showLogin() : view -> tampilkan form login
 *   - login(Request) : redirect -> proses login
 *   - showRegister() : view -> tampilkan form register
 *   - register(Request) : redirect -> proses registrasi
 *   - logout(Request) : redirect -> proses logout
 * 
 * Input Parameters:
 *   - nim : string -> NIM pengguna
 *   - password : string -> kata sandi
 *   - nama : string -> nama lengkap
 *   - kelas : string -> kelas
 *   - prodi : string -> program studi
 *   - jurusan : string -> jurusan
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
            'nim' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['nim' => 'NIM atau password salah']);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:users',
            'kelas' => 'required',
            'prodi' => 'required',
            'jurusan' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'kelas' => $request->kelas,
            'prodi' => $request->prodi,
            'jurusan' => $request->jurusan,
            'password' => Hash::make($request->password),
            'Role' => 'anggota',
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
