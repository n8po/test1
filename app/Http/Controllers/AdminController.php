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

    public function indexAnggota()
    {
        $user = auth()->user();

        // ADMIN: lihat semua anggota
        if ($user->isAdmin()) {
            $anggotaList = AnggotaUkm::with(['user', 'ukm'])->get();
            $ukmList = Ukm::all();
            return view('admin.anggota.index', compact('anggotaList', 'ukmList'));
        }

        // ANGGOTA: hanya lihat anggota satu UKM
        $myUkmId = AnggotaUkm::where('user_id', $user->id)->first()?->ukm_id;
        $anggotaList = AnggotaUkm::with(['user', 'ukm'])
            ->when($myUkmId, fn($q) => $q->where('ukm_id', $myUkmId))
            ->get();
        $ukmList = Ukm::where('id', $myUkmId)->get();

        return view('anggota.ukm.index', compact('anggotaList', 'ukmList'));
    }

    public function createAnggota()
    {
        $mahasiswaList = User::where('Role', '!=', 'administrator')
            ->whereDoesntHave('anggotaAktif')
            ->get();
        $ukmList = Ukm::all();
        return view('admin.anggota.create', compact('mahasiswaList', 'ukmList'));
    }

    public function storeAnggota(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'ukm_id' => 'required|exists:ukms,id',
        ]);

        $user = User::findOrFail($request->user_id);

        // Cek belum jadi anggota
        if ($user->anggotaAktif) {
            return back()->with('error', 'User sudah terdaftar di UKM lain');
        }

        $user->update([
            'Role' => 'anggota',
            'UKM' => Ukm::find($request->ukm_id)->nama,
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
        AnggotaUkm::findOrFail($id)->delete();
        return back()->with('success', 'Anggota berhasil dihapus');
    }

    public function exportAnggota($ukmId = null)
    {
        $query = AnggotaUkm::with(['user', 'ukm']);
        if ($ukmId) $query->where('ukm_id', $ukmId);
        $anggotaList = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="anggota_ukm.csv"',
        ];

        $callback = function () use ($anggotaList) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Nama', 'NIM', 'Kelas', 'Prodi', 'Jurusan', 'UKM', 'Tanggal Bergabung']);
            foreach ($anggotaList as $index => $a) {
                fputcsv($file, [
                    $index + 1,
                    $a->user->nama,
                    $a->user->nim,
                    $a->user->kelas,
                    $a->user->prodi,
                    $a->user->jurusan,
                    $a->ukm->nama,
                    $a->tanggal_bergabung->format('d-m-Y'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function cetakAnggota($ukmId = null)
    {
        $query = AnggotaUkm::with(['user', 'ukm']);
        if ($ukmId) $query->where('ukm_id', $ukmId);
        $anggotaList = $query->get();
        return view('admin.anggota.cetak', compact('anggotaList'));
    }
}
