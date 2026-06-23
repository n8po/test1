<?php
/**
 * Module: MahasiswaController
 * Created: 2026-06-23
 * Author: Raditya Natha Azra
 * Synopsis: Controller untuk manajemen data mahasiswa dan anggota UKM
 * 
 * Functions:
 *   - index() : view -> tampilkan daftar mahasiswa
 *   - create() : view -> tampilkan form tambah mahasiswa
 *   - store(Request) : redirect -> proses tambah mahasiswa
 *   - edit($id) : view -> tampilkan form edit mahasiswa
 *   - update(Request, $id) : redirect -> proses update mahasiswa
 *   - destroy($id) : redirect -> proses hapus mahasiswa
 *   - search(Request) : view -> cari data mahasiswa
 *   - approve($id) : redirect -> setujui mahasiswa
 *   - tolak($id) : redirect -> tolak mahasiswa
 *   - exportExcel() : stream -> export data mahasiswa ke csv
 *   - cetak() : view -> cetak laporan mahasiswa
 * 
 * Input Parameters:
 *   - nama : string -> nama mahasiswa
 *   - nim : string -> nomor induk mahasiswa
 *   - kelas : string -> kelas mahasiswa
 *   - prodi : string -> program studi
 *   - jurusan : string -> jurusan
 *   - keyword : string -> kata kunci pencarian
 * 
 * Return Values:
 *   - 0 : gagal
 *   - 1 : berhasil
 */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $mahasiswaList = User::where('Role', '!=', 'administrator')->paginate(20);
        } else {
            $ukmId = auth()->user()->getUkmId();
            $mahasiswaList = User::whereHas('anggotaUkm', function ($query) use ($ukmId) {
                $query->where('ukm_id', $ukmId);
            })->paginate(20);
        }
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

        $status = $request->input('status') === 'approved' ? 'approved' : 'pending';

        $user = User::create([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'kelas' => $request->kelas,
            'prodi' => $request->prodi,
            'jurusan' => $request->jurusan,
            'password' => bcrypt('password123'),
            'Role' => 'anggota',
            'status' => $status,
            'UKM' => 'Belum Memilih',
        ]);

        if (auth()->user()->isPengurus()) {
            $ukmId = auth()->user()->getUkmId();
            if ($ukmId) {
                $ukm = \App\Models\Ukm::find($ukmId);
                if ($status === 'approved') {
                    \App\Models\AnggotaUkm::create([
                        'user_id' => $user->id,
                        'ukm_id' => $ukmId,
                        'tanggal_bergabung' => now(),
                    ]);
                    $user->update(['UKM' => $ukm->nama]);
                } else {
                    \App\Models\Pendaftaran::create([
                        'user_id' => $user->id,
                        'ukm_id' => $ukmId,
                        'alasan' => 'Diajukan oleh pengurus UKM (' . auth()->user()->nama . ')',
                        'status' => 'pending',
                    ]);
                }
            }
        }

        $msg = $status === 'approved' 
            ? 'Data mahasiswa berhasil ditambahkan dan disetujui.' 
            : 'Data mahasiswa berhasil ditambahkan. Status: Pending — perlu disetujui admin sebelum aktif.';

        return redirect()->route('mahasiswa.index')->with('success', $msg);
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

        $status = $request->input('status') === 'approved' ? 'approved' : 'pending';

        $mahasiswa->update(array_merge(
            $request->only(['nama', 'nim', 'kelas', 'prodi', 'jurusan']),
            ['status' => $status]
        ));

        if (auth()->user()->isPengurus()) {
            $ukmId = auth()->user()->getUkmId();
            if ($ukmId) {
                $ukm = \App\Models\Ukm::find($ukmId);
                if ($status === 'approved') {
                    \App\Models\AnggotaUkm::firstOrCreate([
                        'user_id' => $mahasiswa->id,
                        'ukm_id' => $ukmId,
                    ], [
                        'tanggal_bergabung' => now(),
                    ]);
                    $mahasiswa->update(['UKM' => $ukm->nama]);
                } else {
                    \App\Models\AnggotaUkm::where('user_id', $mahasiswa->id)->where('ukm_id', $ukmId)->delete();
                    $mahasiswa->update(['UKM' => 'Belum Memilih']);

                    \App\Models\Pendaftaran::firstOrCreate([
                        'user_id' => $mahasiswa->id,
                        'ukm_id' => $ukmId,
                        'status' => 'pending',
                    ], [
                        'alasan' => 'Diajukan oleh pengurus UKM (' . auth()->user()->nama . ')',
                    ]);
                }
            }
        }

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Data mahasiswa berhasil dihapus');
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $query = User::where('Role', '!=', 'administrator');

        if (!auth()->user()->isAdmin()) {
            $ukmId = auth()->user()->getUkmId();
            $query->whereHas('anggotaUkm', function ($q) use ($ukmId) {
                $q->where('ukm_id', $ukmId);
            });
        }

        $mahasiswaList = $query->where(function ($query) use ($keyword) {
                $query->where('nama', 'like', "%$keyword%")
                    ->orWhere('nim', 'like', "%$keyword%")
                    ->orWhere('kelas', 'like', "%$keyword%");
            })
            ->paginate(20)
            ->withQueryString();

        return view('mahasiswa.index', compact('mahasiswaList'));
    }

    // Approve mahasiswa
    public function approve($id)
    {
        $mahasiswa = User::findOrFail($id);
        $mahasiswa->update(['status' => 'approved']);
        return back()->with('success', "Mahasiswa {$mahasiswa->nama} berhasil disetujui");
    }

    // Tolak mahasiswa
    public function tolak($id)
    {
        $mahasiswa = User::findOrFail($id);
        $mahasiswa->update(['status' => 'ditolak']);
        return back()->with('success', "Mahasiswa {$mahasiswa->nama} ditolak");
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
            fputcsv($file, ['No', 'NIM', 'Nama', 'Kelas', 'Prodi', 'Jurusan', 'Status', 'UKM']);
            foreach ($mahasiswaList as $index => $m) {
                fputcsv($file, [$index + 1, $m->nim, $m->nama, $m->kelas, $m->prodi, $m->jurusan, $m->status, $m->UKM]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function cetak()
    {
        if (auth()->user()->isAdmin()) {
            $mahasiswaList = User::where('Role', '!=', 'administrator')->get();
        } else {
            $ukmId = auth()->user()->getUkmId();
            $mahasiswaList = User::whereHas('anggotaUkm', function ($query) use ($ukmId) {
                $query->where('ukm_id', $ukmId);
            })->get();
        }
        return view('mahasiswa.cetak', compact('mahasiswaList'));
    }
}
