<?php
/**
 * Module: UkmController
 * Created: 2026-06-23
 * Author: System
 * Synopsis: Controller untuk manajemen data UKM
 */

namespace App\Http\Controllers;

use App\Models\Ukm;
use App\Models\AnggotaUkm;
use Illuminate\Http\Request;

class UkmController extends Controller
{
    public function index()
    {
        $ukmList = Ukm::withCount('anggota')->get();
        return view('ukm.index', compact('ukmList'));
    }

    public function create()
    {
        return view('ukm.create');
    }

    public function store(Request $request)
    {
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
        return view('ukm.edit', compact('ukm'));
    }

    public function update(Request $request, $id)
    {
        $ukm = Ukm::findOrFail($id);
        $request->validate([
            'nama' => 'required|unique:ukms,nama,' . $id,
            'deskripsi' => 'nullable',
        ]);

        $ukm->update($request->only(['nama', 'deskripsi']));
        return redirect()->route('ukm.index')->with('success', 'UKM berhasil diperbarui');
    }

    public function destroy($id)
    {
        $ukm = Ukm::findOrFail($id);
        $ukm->delete();
        return back()->with('success', 'UKM berhasil dihapus');
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $ukmList = Ukm::withCount('anggota')
            ->where('nama', 'like', "%$keyword%")
            ->get();
        return view('ukm.index', compact('ukmList'));
    }

    public function exportExcel()
    {
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
        $ukmList = Ukm::withCount('anggota')->get();
        return view('ukm.cetak', compact('ukmList'));
    }
}
