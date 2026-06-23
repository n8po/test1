@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-ui::card>
            <x-ui::card-content class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-muted-foreground">Total Mahasiswa</p>
                    <p class="text-3xl font-bold">{{ $totalMahasiswa }}</p>
                </div>
                <div class="rounded-full bg-primary/10 p-3 text-primary">
                    <x-lucide-users class="size-5" />
                </div>
            </x-ui::card-content>
        </x-ui::card>

        <x-ui::card>
            <x-ui::card-content class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-muted-foreground">Total UKM</p>
                    <p class="text-3xl font-bold">{{ $totalUkm }}</p>
                </div>
                <div class="rounded-full bg-emerald-500/10 p-3 text-emerald-600">
                    <x-lucide-users class="size-5" />
                    </div>
                    <div>
                        <p class="font-medium">Mahasiswa</p>
                        <p class="text-xs text-muted-foreground">Kelola data mahasiswa</p>
                    </div>
                </a>

                <a href="{{ route('ukm.index') }}" class="flex items-center gap-3 rounded-lg border p-4 hover:bg-accent hover:text-accent-foreground transition-colors">
                    <div class="rounded-lg bg-emerald-500/10 p-2 text-emerald-600">
                        <x-lucide-building class="size-5" />
                    </div>
                    <div>
                        <p class="font-medium">Unit Kegiatan</p>
                        <p class="text-xs text-muted-foreground">Kelola data UKM</p>
                    </div>
                </a>

                <a href="{{ route('pendaftaran.index') }}" class="flex items-center gap-3 rounded-lg border p-4 hover:bg-accent hover:text-accent-foreground transition-colors">
                    <div class="rounded-lg bg-amber-500/10 p-2 text-amber-600">
                        <x-lucide-file-text class="size-5" />
                    </div>
                    <div>
                        <p class="font-medium">Pendaftaran</p>
                        <p class="text-xs text-muted-foreground">Persetujuan anggota</p>
                    </div>
                </a>

                <a href="{{ route('admin.anggota.index') }}" class="flex items-center gap-3 rounded-lg border p-4 hover:bg-accent hover:text-accent-foreground transition-colors">
                    <div class="rounded-lg bg-purple-500/10 p-2 text-purple-600">
                        <x-lucide-user-check class="size-4" />
                    </div>
                    <div>
                        <p class="font-medium">Anggota UKM</p>
                        <p class="text-xs text-muted-foreground">Data anggota aktif</p>
                    </div>
                </a>
            </div>
        </x-ui::card-content>
    </x-ui::card>

    {{-- Recent Pendaftaran --}}
    @if(isset($pendaftaranList) && $pendaftaranList->count() > 0)
    <x-ui::card>
        <x-ui::card-header class="flex flex-row items-center justify-between">
            <div>
                <x-ui::card-title>Pendaftaran Terbaru</x-ui::card-title>
                <x-ui::card-description>Permintaan pendaftaran yang perlu diproses</x-ui::card-description>
            </div>
            <x-ui::button href="{{ route('pendaftaran.index') }}" size="sm" variant="outline">Lihat Semua</x-ui::button>
        </x-ui::card-header>
        <x-ui::card-content>
            <x-ui::table>
                <x-ui::table-header>
                    <x-ui::table-row>
                        <x-ui::table-head>Nama</x-ui::table-head>
                        <x-ui::table-head>NIM</x-ui::table-head>
                        <x-ui::table-head>UKM</x-ui::table-head>
                        <x-ui::table-head>Status</x-ui::table-head>
                        <x-ui::table-head>Aksi</x-ui::table-head>
                    </x-ui::table-row>
                </x-ui::table-header>
                <x-ui::table-body>
                    @foreach($pendaftaranList as $p)
                    <x-ui::table-row>
                        <x-ui::table-cell>{{ $p->user->nama }}</x-ui::table-cell>
                        <x-ui::table-cell>{{ $p->user->nim }}</x-ui::table-cell>
                        <x-ui::table-cell>{{ $p->ukm->nama }}</x-ui::table-cell>
                        <x-ui::table-cell>
                            @if($p->status === 'pending')
                                <x-ui::badge variant="warning">Pending</x-ui::badge>
                            @elseif($p->status === 'diterima')
                                <x-ui::badge variant="success">Diterima</x-ui::badge>
                            @else
                                <x-ui::badge variant="destructive">Ditolak</x-ui::badge>
                            @endif
                        </x-ui::table-cell>
                        <x-ui::table-cell>
                            @if($p->status === 'pending')
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('pendaftaran.setujui', $p->id) }}">
                                    @csrf
                                    <x-ui::button type="submit" size="xs" variant="secondary">Setujui</x-ui::button>
                                </form>
                                <form method="POST" action="{{ route('pendaftaran.tolak', $p->id) }}">
                                    @csrf
                                    <x-ui::button type="submit" size="xs" variant="destructive">Tolak</x-ui::button>
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
