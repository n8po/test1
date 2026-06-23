<?php
/**
 * Module: UkmController
 * Created: 2026-06-23
 * Author: Raditya Natha Azra
 * Synopsis: Controller untuk manajemen data UKM
 * 
 * Functions:
 *   - index() : view -> tampilkan daftar UKM
 *   - create() : view -> tampilkan form tambah UKM
 *   - store(Request) : redirect -> proses tambah UKM
 *   - edit($id) : view -> tampilkan form edit UKM
 *   - update(Request, $id) : redirect -> proses update UKM
 *   - destroy($id) : redirect -> proses hapus UKM
 *   - search(Request) : view -> cari data UKM
 *   - tambahAnggota($id) : view -> form tambah anggota ke UKM
 *   - simpanAnggota(Request, $id) : redirect -> proses tambah anggota ke UKM
 * 
 * Input Parameters:
 *   - nama_ukm : string -> nama ukm
 *   - deskripsi : string -> deskripsi ukm
 *   - pembina : string -> nama pembina ukm
 *   - keyword : string -> kata kunci pencarian
 *   - user_id : integer -> id mahasiswa (untuk anggota)
 * 
 * Return Values:
 *   - 0 : gagal
 *   - 1 : berhasil
 */

namespace App\Http\Controllers;

use App\Models\Ukm;
use App\Models\AnggotaUkm;
use Illuminate\Http\Request;

class UkmController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isPengurus()) {
            return redirect()->route('mahasiswa.index')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut');
        }

        $ukmList = Ukm::with(['anggota.user'])->withCount('anggota')->paginate(6);
        $mahasiswaList = \App\Models\User::where('Role', '!=', 'administrator')
            ->where('status', 'approved')
            ->doesntHave('anggotaAktif')
            ->get();
        return view('ukm.index', compact('ukmList', 'mahasiswaList'));
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        return view('ukm.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'nama' => 'required|unique:ukms',
            'deskripsi' => 'nullable',
        ]);

        Ukm::create($request->only(['nama', 'deskripsi']));
        return redirect()->route('ukm.index')->with('success', 'UKM berhasil ditambahkan');
    }

    public function edit($id)
    {
        $ukm = Ukm::findOrFail($id);
        $user = auth()->user();
        if (!$user->isAdmin() && (!$user->isPengurus() || $user->getUkmId() != $ukm->id)) {
            abort(403, 'Unauthorized action.');
        }
        return view('ukm.edit', compact('ukm'));
    }

    public function update(Request $request, $id)
    {
        $ukm = Ukm::findOrFail($id);
        $user = auth()->user();
        if (!$user->isAdmin() && (!$user->isPengurus() || $user->getUkmId() != $ukm->id)) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'nama' => 'required|unique:ukms,nama,' . $id,
            'deskripsi' => 'nullable',
        ]);

        $ukm->update($request->only(['nama', 'deskripsi']));
        return redirect()->route('ukm.index')->with('success', 'UKM berhasil diperbarui');
    }

    public function destroy($id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $ukm = Ukm::findOrFail($id);
        $ukm->delete();
        return back()->with('success', 'UKM berhasil dihapus');
    }

    public function search(Request $request)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isPengurus()) {
            return redirect()->route('mahasiswa.index')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut');
        }

        $keyword = $request->keyword;
        $ukmList = Ukm::with(['anggota.user'])->withCount('anggota')
            ->where('nama', 'like', "%$keyword%")
            ->paginate(6);
        $mahasiswaList = \App\Models\User::where('Role', '!=', 'administrator')
            ->where('status', 'approved')
            ->doesntHave('anggotaAktif')
            ->get();
        return view('ukm.index', compact('ukmList', 'mahasiswaList'));
    }

    public function exportExcel()
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isPengurus()) {
            abort(403, 'Unauthorized action.');
        }

        $ukmList = Ukm::withCount('anggota')->get();
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="ukm.csv"',
        ];

        $callback = function () use ($ukmList) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Nama UKM', 'Deskripsi', 'Jumlah Anggota']);
            foreach ($ukmList as $index => $u) {
                fputcsv($file, [$index + 1, $u->nama, $u->deskripsi, $u->anggota_count]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function cetak()
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isPengurus()) {
            abort(403, 'Unauthorized action.');
        }

        $ukmList = Ukm::withCount('anggota')->get();
        return view('ukm.cetak', compact('ukmList'));
    }
}
