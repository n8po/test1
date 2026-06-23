@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="space-y-8">
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-ui::card class="hover:shadow-lg transition-shadow">
            <x-ui::card-content class="p-6">
                <div class="flex items-center justify-between">
                    <div class="space-y-1.5">
                        <p class="text-sm font-medium text-muted-foreground">Total Mahasiswa</p>
                        <p class="text-4xl font-bold tracking-tight">{{ $totalMahasiswa }}</p>
                    </div>
                    <div class="rounded-xl bg-primary/10 p-4 text-primary">
                        <x-lucide-users class="size-7" />
                    </div>
                </div>
            </x-ui::card-content>
        </x-ui::card>

        <x-ui::card class="hover:shadow-lg transition-shadow">
            <x-ui::card-content class="p-6">
                <div class="flex items-center justify-between">
                    <div class="space-y-1.5">
                        <p class="text-sm font-medium text-muted-foreground">Total UKM</p>
                        <p class="text-4xl font-bold tracking-tight">{{ $totalUkm }}</p>
                    </div>
                    <div class="rounded-xl bg-emerald-500/10 p-4 text-emerald-600">
                        <x-lucide-building-2 class="size-7" />
                    </div>
                </div>
            </x-ui::card-content>
        </x-ui::card>

        <x-ui::card class="hover:shadow-lg transition-shadow">
            <x-ui::card-content class="p-6">
                <div class="flex items-center justify-between">
                    <div class="space-y-1.5">
                        <p class="text-sm font-medium text-muted-foreground">Pendaftaran Pending</p>
                        <p class="text-4xl font-bold tracking-tight">{{ $pendaftaranPending }}</p>
                    </div>
                    <div class="rounded-xl bg-amber-500/10 p-4 text-amber-600">
                        <x-lucide-clock class="size-7" />
                    </div>
                </div>
            </x-ui::card-content>
        </x-ui::card>

        <x-ui::card class="hover:shadow-lg transition-shadow">
            <x-ui::card-content class="p-6">
                <div class="flex items-center justify-between">
                    <div class="space-y-1.5">
                        <p class="text-sm font-medium text-muted-foreground">Anggota Aktif</p>
                        <p class="text-4xl font-bold tracking-tight">{{ $totalAnggota }}</p>
                    </div>
                    <div class="rounded-xl bg-purple-500/10 p-4 text-purple-600">
                        <x-lucide-check-circle class="size-7" />
                    </div>
                </div>
            </x-ui::card-content>
        </x-ui::card>
    </div>

    {{-- Quick Actions --}}
    <x-ui::card>
        <x-ui::card-header class="p-6 pb-0">
            <x-ui::card-title class="text-lg">Menu Utama</x-ui::card-title>
            <x-ui::card-description>Akses cepat ke fitur utama aplikasi</x-ui::card-description>
        </x-ui::card-header>
        <x-ui::card-content class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('mahasiswa.index') }}" class="flex flex-col items-center gap-3 rounded-xl border-2 border-primary/10 p-6 hover:border-primary/30 hover:bg-accent/50 hover:shadow-md transition-all">
                    <div class="rounded-xl bg-primary/10 p-4 text-primary">
                        <x-lucide-users class="size-8" />
                    </div>
                    <div class="text-center">
                        <p class="font-semibold text-base">Mahasiswa</p>
                        <p class="text-xs text-muted-foreground mt-1">Kelola data mahasiswa</p>
                    </div>
                </a>
                <a href="{{ route('ukm.index') }}" class="flex flex-col items-center gap-3 rounded-xl border-2 border-emerald-500/10 p-6 hover:border-emerald-500/30 hover:bg-emerald-50/50 hover:shadow-md transition-all">
                    <div class="rounded-xl bg-emerald-500/10 p-4 text-emerald-600">
                        <x-lucide-building-2 class="size-8" />
                    </div>
                    <div class="text-center">
                        <p class="font-semibold text-base">Unit Kegiatan</p>
                        <p class="text-xs text-muted-foreground mt-1">Kelola data UKM</p>
                    </div>
                </a>
                <a href="{{ route('pendaftaran.index') }}" class="flex flex-col items-center gap-3 rounded-xl border-2 border-amber-500/10 p-6 hover:border-amber-500/30 hover:bg-amber-50/50 hover:shadow-md transition-all">
                    <div class="rounded-xl bg-amber-500/10 p-4 text-amber-600">
                        <x-lucide-file-text class="size-8" />
                    </div>
                    <div class="text-center">
                        <p class="font-semibold text-base">Pendaftaran</p>
                        <p class="text-xs text-muted-foreground mt-1">Persetujuan anggota</p>
                    </div>
                </a>
                <a href="{{ route('admin.anggota.index') }}" class="flex flex-col items-center gap-3 rounded-xl border-2 border-purple-500/10 p-6 hover:border-purple-500/30 hover:bg-purple-50/50 hover:shadow-md transition-all">
                    <div class="rounded-xl bg-purple-500/10 p-4 text-purple-600">
                        <x-lucide-user-check class="size-8" />
                    </div>
                    <div class="text-center">
                        <p class="font-semibold text-base">Anggota UKM</p>
                        <p class="text-xs text-muted-foreground mt-1">Data anggota aktif</p>
                    </div>
                </a>
            </div>
        </x-ui::card-content>
    </x-ui::card>

    {{-- Recent Pendaftaran --}}
    @if(isset($pendaftaranList) && $pendaftaranList->count() > 0)
    <x-ui::card>
        <x-ui::card-header class="p-6 pb-0 flex flex-row items-center justify-between">
            <div>
                <x-ui::card-title class="text-lg">Pendaftaran Terbaru</x-ui::card-title>
                <x-ui::card-description>Permintaan pendaftaran yang perlu diproses</x-ui::card-description>
            </div>
            <x-ui::button href="{{ route('pendaftaran.index') }}" variant="outline">Lihat Semua</x-ui::button>
        </x-ui::card-header>
        <x-ui::card-content class="p-0">
            <x-ui::table>
                <x-ui::table-header>
                    <x-ui::table-row>
                        <x-ui::table-head class="p-4">Nama</x-ui::table-head>
                        <x-ui::table-head class="p-4">NIM</x-ui::table-head>
                        <x-ui::table-head class="p-4">UKM</x-ui::table-head>
                        <x-ui::table-head class="p-4">Status</x-ui::table-head>
                        <x-ui::table-head class="p-4">Aksi</x-ui::table-head>
                    </x-ui::table-row>
                </x-ui::table-header>
                <x-ui::table-body>
                    @foreach($pendaftaranList as $p)
                    <x-ui::table-row>
                        <x-ui::table-cell class="p-4">{{ $p->user->nama }}</x-ui::table-cell>
                        <x-ui::table-cell class="p-4">{{ $p->user->nim }}</x-ui::table-cell>
                        <x-ui::table-cell class="p-4">{{ $p->ukm->nama }}</x-ui::table-cell>
                        <x-ui::table-cell class="p-4">
                            @if($p->status === 'pending')
                                <x-ui::badge variant="outline">Pending</x-ui::badge>
                            @elseif($p->status === 'diterima')
                                <x-ui::badge variant="secondary">Diterima</x-ui::badge>
                            @else
                                <x-ui::badge variant="destructive">Ditolak</x-ui::badge>
                            @endif
                        </x-ui::table-cell>
                        <x-ui::table-cell class="p-4">
                            @if($p->status === 'pending')
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('pendaftaran.setujui', $p->id) }}">
                                    @csrf
                                    <x-ui::button type="submit" size="sm" variant="secondary">Setujui</x-ui::button>
                                </form>
                                <form method="POST" action="{{ route('pendaftaran.tolak', $p->id) }}">
                                    @csrf
                                    <x-ui::button type="submit" size="sm" variant="destructive">Tolak</x-ui::button>
                                </form>
                            </div>
                            @endif
                        </x-ui::table-cell>
                    </x-ui::table-row>
                    @endforeach
                </x-ui::table-body>
            </x-ui::table>
        </x-ui::card-content>
    </x-ui::card>
    @endif
</div>
@endsection
