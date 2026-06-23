<?php
/**
 * Module: AnggotaController
 * Created: 2026-06-23
 * Author: Raditya Natha Azra
 * Synopsis: Controller untuk anggota UKM (mahasiswa)
 * 
 * Functions:
 *   - dashboard() : view -> tampilkan dashboard anggota
 *   - listUkm() : view -> tampilkan daftar UKM
 *   - daftarUkm(Request) : redirect -> proses pendaftaran UKM
 *   - profil() : view -> tampilkan profil anggota
 * 
 * Input Parameters:
 *   - ukm_id : int -> ID UKM yang didaftarkan
 * 
 * Return Values:
 *   - 0 : gagal
 *   - 1 : berhasil
 */

namespace App\Http\Controllers;

use App\Models\Ukm;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnggotaController extends Controller
{
    public function dashboard()
    {
        $userData = Auth::user();
        $pendaftaranList = Pendaftaran::where('user_id', $userData->id)->get();

        return view('anggota.dashboard', compact('pendaftaranList'));
    }

    public function listUkm()
    {
        $ukmList = Ukm::all();

        return view('anggota.ukm.index', compact('ukmList'));
    }

    public function daftarUkm(Request $request)
    {
        $request->validate([
            'ukm_id' => 'required|exists:ukms,id'
        ]);

        $exists = Pendaftaran::where('user_id', Auth::id())
            ->where('ukm_id', $request->ukm_id)
            ->exists();

        if ($exists)
        {
            return back()->with('error', 'Anda sudah mendaftar di UKM ini');
        }

        Pendaftaran::create([
            'user_id' => Auth::id(),
            'ukm_id' => $request->ukm_id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Pendaftaran berhasil, menunggu persetujuan');
    }

    public function profil()
    {
        $userData = Auth::user();

        return view('anggota.profil', compact('userData'));
    }
}
