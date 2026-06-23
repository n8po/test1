@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-ui:card>
            <x-ui:card-content class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-muted-foreground">Total Mahasiswa</p>
                    <p class="text-3xl font-bold">{{ $totalMahasiswa }}</p>
                </div>
                <div class="rounded-full bg-primary/10 p-3 text-primary">
                    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
            </x-ui:card-content>
        </x-ui:card>

        <x-ui:card>
            <x-ui:card-content class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-muted-foreground">Total UKM</p>
                    <p class="text-3xl font-bold">{{ $totalUkm }}</p>
                </div>
                <div class="rounded-full bg-emerald-500/10 p-3 text-emerald-600">
                    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </x-ui:card-content>
        </x-ui:card>

        <x-ui:card>
            <x-ui:card-content class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-muted-foreground">Pendaftaran Pending</p>
                    <p class="text-3xl font-bold">{{ $pendaftaranPending }}</p>
                </div>
                <div class="rounded-full bg-amber-500/10 p-3 text-amber-600">
                    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </x-ui:card-content>
        </x-ui:card>

        <x-ui:card>
            <x-ui:card-content class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-muted-foreground">Anggota Aktif</p>
                    <p class="text-3xl font-bold">{{ $totalAnggota }}</p>
                </div>
                <div class="rounded-full bg-purple-500/10 p-3 text-purple-600">
                    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </x-ui:card-content>
        </x-ui:card>
    </div>

    {{-- Quick Actions --}}
    <x-ui:card>
        <x-ui:card-header>
            <x-ui:card-title>Menu Utama</x-ui:card-title>
            <x-ui:card-description>Akses cepat ke fitur utama</x-ui:card-description>
        </x-ui:card-header>
        <x-ui:card-content>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('mahasiswa.index') }}" class="flex items-center gap-3 rounded-lg border p-4 hover:bg-accent hover:text-accent-foreground transition-colors">
                    <div class="rounded-lg bg-primary/10 p-2 text-primary">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium">Mahasiswa</p>
                        <p class="text-xs text-muted-foreground">Kelola data mahasiswa</p>
                    </div>
                </a>

                <a href="{{ route('ukm.index') }}" class="flex items-center gap-3 rounded-lg border p-4 hover:bg-accent hover:text-accent-foreground transition-colors">
                    <div class="rounded-lg bg-emerald-500/10 p-2 text-emerald-600">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium">Unit Kegiatan</p>
                        <p class="text-xs text-muted-foreground">Kelola data UKM</p>
                    </div>
                </a>

                <a href="{{ route('pendaftaran.index') }}" class="flex items-center gap-3 rounded-lg border p-4 hover:bg-accent hover:text-accent-foreground transition-colors">
                    <div class="rounded-lg bg-amber-500/10 p-2 text-amber-600">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium">Pendaftaran</p>
                        <p class="text-xs text-muted-foreground">Persetujuan anggota</p>
                    </div>
                </a>

                <a href="{{ route('admin.anggota.index') }}" class="flex items-center gap-3 rounded-lg border p-4 hover:bg-accent hover:text-accent-foreground transition-colors">
                    <div class="rounded-lg bg-purple-500/10 p-2 text-purple-600">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium">Anggota UKM</p>
                        <p class="text-xs text-muted-foreground">Data anggota aktif</p>
                    </div>
                </a>
            </div>
        </x-ui:card-content>
    </x-ui:card>

    {{-- Recent Pendaftaran --}}
    @if(isset($pendaftaranList) && $pendaftaranList->count() > 0)
    <x-ui:card>
        <x-ui:card-header class="flex flex-row items-center justify-between">
            <div>
                <x-ui:card-title>Pendaftaran Terbaru</x-ui:card-title>
                <x-ui:card-description>Permintaan pendaftaran yang perlu diproses</x-ui:card-description>
            </div>
            <x-ui:button href="{{ route('pendaftaran.index') }}" size="sm" variant="outline">Lihat Semua</x-ui:button>
        </x-ui:card-header>
        <x-ui:card-content>
            <x-ui:table>
                <x-ui:table-header>
                    <x-ui:table-row>
                        <x-ui:table-head>Nama</x-ui:table-head>
                        <x-ui:table-head>NIM</x-ui:table-head>
                        <x-ui:table-head>UKM</x-ui:table-head>
                        <x-ui:table-head>Status</x-ui:table-head>
                        <x-ui:table-head>Aksi</x-ui:table-head>
                    </x-ui:table-row>
                </x-ui:table-header>
                <x-ui:table-body>
                    @foreach($pendaftaranList as $p)
                    <x-ui:table-row>
                        <x-ui:table-cell>{{ $p->user->nama }}</x-ui:table-cell>
                        <x-ui:table-cell>{{ $p->user->nim }}</x-ui:table-cell>
                        <x-ui:table-cell>{{ $p->ukm->nama }}</x-ui:table-cell>
                        <x-ui:table-cell>
                            @if($p->status === 'pending')
                                <x-ui:badge variant="warning">Pending</x-ui:badge>
                            @elseif($p->status === 'diterima')
                                <x-ui:badge variant="success">Diterima</x-ui:badge>
                            @else
                                <x-ui:badge variant="destructive">Ditolak</x-ui:badge>
                            @endif
                        </x-ui:table-cell>
                        <x-ui:table-cell>
                            @if($p->status === 'pending')
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('pendaftaran.setujui', $p->id) }}">
                                    @csrf
                                    <x-ui:button type="submit" size="xs" variant="secondary">Setujui</x-ui:button>
                                </form>
                                <form method="POST" action="{{ route('pendaftaran.tolak', $p->id) }}">
                                    @csrf
                                    <x-ui:button type="submit" size="xs" variant="destructive">Tolak</x-ui:button>
                                </form>
                            </div>
                            @endif
                        </x-ui:table-cell>
                    </x-ui:table-row>
                    @endforeach
                </x-ui:table-body>
            </x-ui:table>
        </x-ui:card-content>
    </x-ui:card>
    @endif
</div>
@endsection
