@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <span class="text-sm text-gray-500">{{ now()->format('d F Y') }}</span>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Mahasiswa</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalMahasiswa }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total UKM</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalUkm }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Pendaftaran Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pendaftaranPending }}</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Anggota Aktif</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalAnggota }}</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold mb-4">Menu Utama</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('mahasiswa.index') }}" class="flex items-center gap-3 p-4 rounded-lg border hover:bg-blue-50 hover:border-blue-300 transition-colors">
                <div class="bg-blue-100 p-2 rounded-lg">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-medium">Mahasiswa</p>
                    <p class="text-xs text-gray-500">Kelola data mahasiswa</p>
                </div>
            </a>

            <a href="{{ route('ukm.index') }}" class="flex items-center gap-3 p-4 rounded-lg border hover:bg-green-50 hover:border-green-300 transition-colors">
                <div class="bg-green-100 p-2 rounded-lg">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <p class="font-medium">Unit Kegiatan</p>
                    <p class="text-xs text-gray-500">Kelola data UKM</p>
                </div>
            </a>

            <a href="{{ route('pendaftaran.index') }}" class="flex items-center gap-3 p-4 rounded-lg border hover:bg-yellow-50 hover:border-yellow-300 transition-colors">
                <div class="bg-yellow-100 p-2 rounded-lg">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-medium">Pendaftaran</p>
                    <p class="text-xs text-gray-500">Persetujuan anggota</p>
                </div>
            </a>

            <a href="{{ route('admin.anggota.index') }}" class="flex items-center gap-3 p-4 rounded-lg border hover:bg-purple-50 hover:border-purple-300 transition-colors">
                <div class="bg-purple-100 p-2 rounded-lg">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-medium">Anggota UKM</p>
                    <p class="text-xs text-gray-500">Data anggota aktif</p>
                </div>
            </a>
        </div>
    </div>

    {{-- Recent Pendaftaran --}}
    @if($pendaftaranList->count() > 0)
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Pendaftaran Terbaru</h2>
            <a href="{{ route('pendaftaran.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIM</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">UKM</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($pendaftaranList as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $p->user->nama }}</td>
                        <td class="px-4 py-3">{{ $p->user->nim }}</td>
                        <td class="px-4 py-3">{{ $p->ukm->nama }}</td>
                        <td class="px-4 py-3">
                            @if($p->status === 'pending')
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($p->status === 'diterima')
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Diterima</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($p->status === 'pending')
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('pendaftaran.setujui', $p->id) }}">
                                    @csrf
                                    <button type="submit" class="text-xs bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">Setujui</button>
                                </form>
                                <form method="POST" action="{{ route('pendaftaran.tolak', $p->id) }}">
                                    @csrf
                                    <button type="submit" class="text-xs bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Tolak</button>
                                </form>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
