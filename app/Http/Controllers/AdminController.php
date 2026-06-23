<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ukm;
use App\Models\Pendaftaran;
use App\Models\AnggotaUkm;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalMahasiswa = User::where('Role', '!=', 'administrator')->count();
        $totalUkm = Ukm::count();
        $totalAnggota = AnggotaUkm::count();
        $pendaftaranPending = Pendaftaran::where('status', 'pending')->count();
        $pendaftaranList = Pendaftaran::with(['user', 'ukm'])->latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'totalMahasiswa',
            'totalUkm',
            'totalAnggota',
            'pendaftaranPending',
            'pendaftaranList'
        ));
    }

    public function setujuiPendaftaran($id)
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

    public function tolakPendaftaran($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update(['status' => 'ditolak']);
        return back()->with('success', 'Pendaftaran ditolak');
    }

    public function indexAnggota()
    {
        $anggotaList = AnggotaUkm::with(['user', 'ukm'])->get();
        $ukmList = Ukm::all();
        return view('admin.anggota.index', compact('anggotaList', 'ukmList'));
    }

    public function createAnggota()
    {
        $ukmList = Ukm::all();
        return view('admin.anggota.create', compact('ukmList'));
    }

    public function storeAnggota(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:users',
            'kelas' => 'required',
            'prodi' => 'required',
            'jurusan' => 'required',
            'ukm_id' => 'required|exists:ukms,id',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'kelas' => $request->kelas,
            'prodi' => $request->prodi,
            'jurusan' => $request->jurusan,
            'password' => bcrypt('password'),
            'Role' => 'anggota',
            'UKM' => Ukm::find($request->ukm_id)->nama,
            'email' => $request->nim . '@poliban.ac.id',
        ]);

        AnggotaUkm::create([
            'user_id' => $user->id,
            'ukm_id' => $request->ukm_id,
            'tanggal_bergabung' => now(),
        ]);

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil ditambahkan');
    }

    public function editAnggota($id)
    {
        $anggotaData = AnggotaUkm::with('user')->findOrFail($id);
        $ukmList = Ukm::all();
        return view('admin.anggota.edit', compact('anggotaData', 'ukmList'));
    }

    public function updateAnggota(Request $request, $id)
    {
        $anggotaData = AnggotaUkm::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:users,nim,' . $anggotaData->user_id,
            'kelas' => 'required',
            'prodi' => 'required',
            'jurusan' => 'required',
            'ukm_id' => 'required|exists:ukms,id',
        ]);

        $anggotaData->user->update($request->only(['nama', 'nim', 'kelas', 'prodi', 'jurusan']));
        $anggotaData->update(['ukm_id' => $request->ukm_id]);

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil diupdate');
    }

    public function destroyAnggota($id)
    {
        $anggotaData = AnggotaUkm::findOrFail($id);
        $anggotaData->delete();
        return back()->with('success', 'Anggota berhasil dihapus');
    }

    public function exportAnggota($ukmId = null)
    {
        $query = AnggotaUkm::with(['user', 'ukm']);
        if ($ukmId) {
            $query->where('ukm_id', $ukmId);
        }
        $anggotaList = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="anggota_ukm.csv"',
        ];

        $callback = function () use ($anggotaList) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Nama', 'NIM', 'Kelas', 'Prodi', 'Jurusan', 'UKM', 'Tanggal Bergabung']);
            foreach ($anggotaList as $index => $anggotaItem) {
                fputcsv($file, [
                    $index + 1,
                    $anggotaItem->user->nama,
                    $anggotaItem->user->nim,
                    $anggotaItem->user->kelas,
                    $anggotaItem->user->prodi,
                    $anggotaItem->user->jurusan,
                    $anggotaItem->ukm->nama,
                    $anggotaItem->tanggal_bergabung->format('d-m-Y'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function cetakAnggota($ukmId = null)
    {
        $query = AnggotaUkm::with(['user', 'ukm']);
        if ($ukmId) {
            $query->where('ukm_id', $ukmId);
        }
        $anggotaList = $query->get();
        return view('admin.anggota.cetak', compact('anggotaList'));
    }
}
