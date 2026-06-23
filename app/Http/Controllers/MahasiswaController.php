<?php
/**
 * Module: MahasiswaController
 * Created: 2026-06-23
 * Author: System
 * Synopsis: Controller untuk manajemen data mahasiswa
 */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswaList = User::where('Role', '!=', 'administrator')->get();
        return view('mahasiswa.index', compact('mahasiswaList'));
    }

    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:users',
            'kelas' => 'required',
            'prodi' => 'required',
            'jurusan' => 'required',
        ]);

        User::create([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'kelas' => $request->kelas,
            'prodi' => $request->prodi,
            'jurusan' => $request->jurusan,
            'password' => bcrypt('password123'),
            'Role' => 'anggota',
            'UKM' => 'Belum Memilih',
            'email' => $request->nim . '@poliban.ac.id',
        ]);

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil ditambahkan');
    }

    public function edit($id)
    {
        $mahasiswa = User::findOrFail($id);
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = User::findOrFail($id);
        
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:users,nim,' . $id,
            'kelas' => 'required',
            'prodi' => 'required',
            'jurusan' => 'required',
        ]);

        $mahasiswa->update($request->only(['nama', 'nim', 'kelas', 'prodi', 'jurusan']));
        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui');
    }

    public function destroy($id)
    {
        $mahasiswa = User::findOrFail($id);
        $mahasiswa->delete();
        return back()->with('success', 'Data mahasiswa berhasil dihapus');
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $mahasiswaList = User::where('Role', '!=', 'administrator')
            ->where(function ($query) use ($keyword) {
                $query->where('nama', 'like', "%$keyword%")
                    ->orWhere('nim', 'like', "%$keyword%")
                    ->orWhere('kelas', 'like', "%$keyword%");
            })
            ->get();
            
        return view('mahasiswa.index', compact('mahasiswaList'));
    }

    public function exportExcel()
    {
        $mahasiswaList = User::where('Role', '!=', 'administrator')->get();
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="mahasiswa.csv"',
        ];

        $callback = function () use ($mahasiswaList) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'NIM', 'Nama', 'Kelas', 'Prodi', 'Jurusan', 'UKM']);
            foreach ($mahasiswaList as $index => $m) {
                fputcsv($file, [$index + 1, $m->nim, $m->nama, $m->kelas, $m->prodi, $m->jurusan, $m->UKM]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function cetak()
    {
        $mahasiswaList = User::where('Role', '!=', 'administrator')->get();
        return view('mahasiswa.cetak', compact('mahasiswaList'));
    }
}
