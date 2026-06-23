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
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk admin.');
        }

        $mahasiswaList = User::where('Role', '!=', 'administrator')->paginate(20);
        return view('mahasiswa.index', compact('mahasiswaList'));
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:users',
            'kelas' => 'required',
            'prodi' => 'required',
            'jurusan' => 'required',
        ]);

        $status = $request->input('status') === 'approved' ? 'approved' : 'pending';

        User::create([
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

        $msg = $status === 'approved'
            ? 'Data mahasiswa berhasil ditambahkan dan disetujui.'
            : 'Data mahasiswa berhasil ditambahkan. Status: Pending — perlu disetujui admin sebelum aktif.';

        return redirect()->route('mahasiswa.index')->with('success', $msg);
    }

    public function edit($id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        $mahasiswa = User::findOrFail($id);
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

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

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui');
    }

    public function destroy($id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        User::findOrFail($id)->delete();
        return back()->with('success', 'Data mahasiswa berhasil dihapus');
    }

    public function search(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $keyword = $request->keyword;

        $mahasiswaList = User::where('Role', '!=', 'administrator')
            ->where(function ($query) use ($keyword) {
                $query->where('nama', 'like', "%$keyword%")
                    ->orWhere('nim', 'like', "%$keyword%")
                    ->orWhere('kelas', 'like', "%$keyword%");
            })
            ->paginate(20)
            ->withQueryString();

        return view('mahasiswa.index', compact('mahasiswaList'));
    }

    public function approve($id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        $mahasiswa = User::findOrFail($id);
        $mahasiswa->update(['status' => 'approved']);
        return back()->with('success', "Mahasiswa {$mahasiswa->nama} berhasil disetujui");
    }

    public function tolak($id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        $mahasiswa = User::findOrFail($id);
        $mahasiswa->update(['status' => 'ditolak']);
        return back()->with('success', "Mahasiswa {$mahasiswa->nama} ditolak");
    }

    public function exportExcel()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

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
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $mahasiswaList = User::where('Role', '!=', 'administrator')->get();
        return view('mahasiswa.cetak', compact('mahasiswaList'));
    }
}
