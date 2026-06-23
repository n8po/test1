<?php
/**
 * Module: KegiatanController
 * Created: 2026-06-23
 * Author: Raditya Natha Azra
 * Synopsis: Controller untuk manajemen kegiatan UKM
 * 
 * Functions:
 *   - index() : view -> tampilkan daftar kegiatan
 *   - create() : view -> tampilkan form tambah kegiatan
 *   - store(Request) : redirect -> simpan kegiatan baru
 *   - edit($id) : view -> tampilkan form edit kegiatan
 *   - update(Request, $id) : redirect -> update data kegiatan
 *   - destroy($id) : redirect -> hapus kegiatan
 * 
 * Input Parameters:
 *   - nama_kegiatan : string -> nama kegiatan
 *   - ukm : string -> nama UKM penyelenggara
 *   - tanggal : date -> tanggal pelaksanaan
 *   - deskripsi : text -> deskripsi kegiatan
 * 
 * Return Values:
 *   - 0 : gagal
 *   - 1 : berhasil
 */

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Ukm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KegiatanController extends Controller
{
    public function index()
    {
        $userData = Auth::user();
        $kegiatanList = Kegiatan::where('UKM', $userData->UKM)->get();

        return view('kegiatan.index', compact('kegiatanList'));
    }

    public function create()
    {
        $ukmList = Ukm::all();

        return view('kegiatan.create', compact('ukmList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
            'ukm' => 'required',
            'tanggal' => 'required|date',
        ]);

        $userData = Auth::user();

        Kegiatan::create([
            'nama_kegiatan' => $request->nama_kegiatan,
            'UKM' => $request->ukm,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dibuat');
    }

    public function edit($id)
    {
        $kegiatanData = Kegiatan::findOrFail($id);
        $ukmList = Ukm::all();

        return view('kegiatan.edit', compact('kegiatanData', 'ukmList'));
    }

    public function update(Request $request, $id)
    {
        $kegiatanData = Kegiatan::findOrFail($id);
        $kegiatanData->update($request->only(['nama_kegiatan', 'UKM', 'tanggal', 'deskripsi']));

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil diupdate');
    }

    public function destroy($id)
    {
        $kegiatanData = Kegiatan::findOrFail($id);
        $kegiatanData->delete();

        return back()->with('success', 'Kegiatan berhasil dihapus');
    }

    public function cetak()
    {
        $kegiatanList = Kegiatan::all();
        return view('kegiatan.cetak', compact('kegiatanList'));
    }
}
