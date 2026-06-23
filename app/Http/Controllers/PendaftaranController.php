<?php
/**
 * Module: PendaftaranController
 * Created: 2026-06-23
 * Author: Raditya Natha Azra
 * Synopsis: Controller untuk manajemen pendaftaran anggota UKM
 * 
 * Functions:
 *   - index() : view -> tampilkan daftar pendaftaran
 *   - create() : view -> tampilkan form tambah pendaftaran
 *   - store(Request) : redirect -> proses tambah pendaftaran
 *   - edit($id) : view -> tampilkan form edit pendaftaran
 *   - update(Request, $id) : redirect -> proses update pendaftaran
 *   - destroy($id) : redirect -> proses hapus pendaftaran
 *   - search(Request) : view -> cari data pendaftaran
 *   - approve($id) : redirect -> setujui pendaftaran
 *   - tolak($id) : redirect -> tolak pendaftaran
 * 
 * Input Parameters:
 *   - user_id : integer -> id mahasiswa pendaftar
 *   - ukm_id : integer -> id ukm yang didaftar
 *   - alasan : string -> alasan mendaftar
 *   - keyword : string -> kata kunci pencarian
 * 
 * Return Values:
 *   - 0 : gagal
 *   - 1 : berhasil
 */

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\AnggotaUkm;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index()
    {
        $pendaftaranList = Pendaftaran::with(['user', 'ukm'])->latest()->get();
        return view('pendaftaran.index', compact('pendaftaranList'));
    }

    public function setujui($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        $exists = AnggotaUkm::where('user_id', $pendaftaran->user_id)->exists();
        if ($exists) {
            return back()->with('error', 'Mahasiswa sudah terdaftar di UKM lain');
        }

        $pendaftaran->update(['status' => 'diterima']);

        AnggotaUkm::create([
            'user_id' => $pendaftaran->user_id,
            'ukm_id' => $pendaftaran->ukm_id,
            'tanggal_bergabung' => now(),
        ]);

        $pendaftaran->user->update(['UKM' => $pendaftaran->ukm->nama]);

        return back()->with('success', 'Pendaftaran disetujui');
    }

    public function tolak($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update(['status' => 'ditolak']);
        return back()->with('success', 'Pendaftaran ditolak');
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $pendaftaranList = Pendaftaran::with(['user', 'ukm'])
            ->where(function ($query) use ($keyword) {
                $query->whereHas('user', function ($q) use ($keyword) {
                    $q->where('nama', 'like', "%$keyword%")
                      ->orWhere('nim', 'like', "%$keyword%");
                })->orWhereHas('ukm', function ($q) use ($keyword) {
                    $q->where('nama', 'like', "%$keyword%");
                });
            })
            ->get();

        return view('pendaftaran.index', compact('pendaftaranList'));
    }

    public function exportExcel()
    {
        $pendaftaranList = Pendaftaran::with(['user', 'ukm'])->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="pendaftaran.csv"',
        ];

        $callback = function () use ($pendaftaranList) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Nama', 'NIM', 'UKM', 'Status', 'Tanggal Daftar']);

            foreach ($pendaftaranList as $i => $p) {
                fputcsv($file, [
                    $i + 1,
                    $p->user->nama ?? '-',
                    $p->user->nim ?? '-',
                    $p->ukm->nama ?? '-',
                    $p->status,
                    $p->created_at->format('d-m-Y'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function cetak()
    {
        $pendaftaranList = Pendaftaran::with(['user', 'ukm'])->get();
        return view('pendaftaran.cetak', compact('pendaftaranList'));
    }
}
