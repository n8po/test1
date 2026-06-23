@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="flex flex-col gap-4 md:gap-6">
    {{-- Header block --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b pb-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight">Dashboard</h2>
            @if(auth()->user()->isPengurus() && isset($myUkm))
                <p class="text-sm text-muted-foreground">Data {{ $myUkm->nama }} — {{ ucfirst(auth()->user()->Role) }}</p>
            @else
                <p class="text-sm text-muted-foreground">Statistik dan aktivitas Unit Kegiatan Mahasiswa Poliban</p>
            @endif
        </div>
    </div>

    @if(auth()->user()->isAdmin())
    {{-- ============================================ --}}
    {{-- ADMIN DASHBOARD --}}
    {{-- ============================================ --}}

    {{-- KPI cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        {{-- Card 1: Total Mahasiswa --}}
        <x-ui::card variant="sectioned">
            <x-ui::card-header>
                <x-ui::card-description class="flex items-center gap-2">
                    <x-lucide-users class="size-4 text-primary" /> Total Mahasiswa
                </x-ui::card-description>
                <x-ui::card-title class="text-2xl font-semibold tabular-nums">{{ number_format($totalMahasiswa) }}</x-ui::card-title>
            </x-ui::card-header>
            <x-ui::card-footer class="text-sm">
                <span class="text-emerald-600 dark:text-emerald-400 inline-flex items-center gap-1 font-medium">
                    <x-lucide-trending-up class="size-3.5" /> +12.5%
                </span>
                <span class="text-muted-foreground ml-2">vs. last month</span>
            </x-ui::card-footer>
        </x-ui::card>

        {{-- Card 2: Total UKM --}}
        <x-ui::card variant="sectioned">
            <x-ui::card-header>
                <x-ui::card-description class="flex items-center gap-2">
                    <x-lucide-building-2 class="size-4 text-emerald-600" /> Total UKM
                </x-ui::card-description>
                <x-ui::card-title class="text-2xl font-semibold tabular-nums">{{ number_format($totalUkm) }}</x-ui::card-title>
            </x-ui::card-header>
            <x-ui::card-footer class="text-sm">
                <span class="text-emerald-600 dark:text-emerald-400 inline-flex items-center gap-1 font-medium">
                    <x-lucide-trending-up class="size-3.5" /> +4.2%
                </span>
                <span class="text-muted-foreground ml-2">vs. last semester</span>
            </x-ui::card-footer>
        </x-ui::card>

        {{-- Card 3: Pendaftaran Pending --}}
        <x-ui::card variant="sectioned">
            <x-ui::card-header>
                <x-ui::card-description class="flex items-center gap-2">
                    <x-lucide-clock class="size-4 text-amber-600" /> Pendaftaran Pending
                </x-ui::card-description>
                <x-ui::card-title class="text-2xl font-semibold tabular-nums">{{ number_format($pendaftaranPending) }}</x-ui::card-title>
            </x-ui::card-header>
            <x-ui::card-footer class="text-sm">
                <span class="{{ $pendaftaranPending > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-muted-foreground' }} inline-flex items-center gap-1 font-medium">
                    <x-lucide-alert-circle class="size-3.5" /> {{ $pendaftaranPending }} pending
                </span>
                <span class="text-muted-foreground ml-2">perlu diproses</span>
            </x-ui::card-footer>
        </x-ui::card>

        {{-- Card 4: Anggota Aktif --}}
        <x-ui::card variant="sectioned">
            <x-ui::card-header>
                <x-ui::card-description class="flex items-center gap-2">
                    <x-lucide-check-circle class="size-4 text-purple-600" /> Anggota Aktif
                </x-ui::card-description>
                <x-ui::card-title class="text-2xl font-semibold tabular-nums">{{ number_format($totalAnggota) }}</x-ui::card-title>
            </x-ui::card-header>
            <x-ui::card-footer class="text-sm">
                <span class="text-emerald-600 dark:text-emerald-400 inline-flex items-center gap-1 font-medium">
                    <x-lucide-trending-up class="size-3.5" /> +8.2%
                </span>
                <span class="text-muted-foreground ml-2">vs. last month</span>
            </x-ui::card-footer>
        </x-ui::card>
    </div>

    {{-- Pendaftaran Terbaru + UKM Terpopuler --}}
    <div class="grid grid-cols-1 gap-4 md:gap-6 lg:grid-cols-7">
        {{-- Pendaftaran Terbaru Table --}}
        <x-ui::card variant="sectioned" class="lg:col-span-4">
            <x-ui::card-header class="flex flex-row items-center justify-between pb-2">
                <div>
                    <x-ui::card-title>Pendaftaran Terbaru</x-ui::card-title>
                    <x-ui::card-description>Permintaan pendaftaran mahasiswa yang perlu diproses</x-ui::card-description>
                </div>
                <x-ui::button href="{{ route('pendaftaran.index') }}" variant="outline" size="sm">
                    Lihat Semua
                </x-ui::button>
            </x-ui::card-header>
            <x-ui::card-content>
                @if(isset($pendaftaranList) && $pendaftaranList->count() > 0)
                    <x-ui::table>
                        <x-ui::table-header>
                            <x-ui::table-row>
                                <x-ui::table-head>Nama</x-ui::table-head>
                                <x-ui::table-head>NIM</x-ui::table-head>
                                <x-ui::table-head>UKM</x-ui::table-head>
                                <x-ui::table-head>Status</x-ui::table-head>
                                <x-ui::table-head class="text-right">Aksi</x-ui::table-head>
                            </x-ui::table-row>
                        </x-ui::table-header>
                        <x-ui::table-body>
                            @foreach($pendaftaranList as $p)
                                <x-ui::table-row>
                                    <x-ui::table-cell class="font-medium">{{ $p->user->nama }}</x-ui::table-cell>
                                    <x-ui::table-cell class="tabular-nums">{{ $p->user->nim }}</x-ui::table-cell>
                                    <x-ui::table-cell>{{ $p->ukm->nama }}</x-ui::table-cell>
                                    <x-ui::table-cell>
                                        @php
                                            $statusStyles = [
                                                'pending' => 'border-transparent bg-amber-500/15 text-amber-700 dark:text-amber-400',
                                                'diterima' => 'border-transparent bg-emerald-500/15 text-emerald-700 dark:text-emerald-400',
                                                'ditolak' => 'border-transparent bg-red-500/15 text-red-700 dark:text-red-400',
                                            ];
                                        @endphp
                                        <x-ui::badge variant="outline" class="{{ $statusStyles[$p->status] ?? '' }}">
                                            {{ ucfirst($p->status) }}
                                        </x-ui::badge>
                                    </x-ui::table-cell>
                                    <x-ui::table-cell class="text-right">
                                        @if($p->status === 'pending')
                                            <div class="inline-flex gap-1">
                                                <form method="POST" action="{{ route('pendaftaran.setujui', $p->id) }}" class="inline">
                                                    @csrf
                                                    <x-ui::button type="submit" size="xs" variant="secondary">Setujui</x-ui::button>
                                                </form>
                                                <form method="POST" action="{{ route('pendaftaran.tolak', $p->id) }}" class="inline">
                                                    @csrf
                                                    <x-ui::button type="submit" size="xs" variant="destructive">Tolak</x-ui::button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-xs text-muted-foreground">Diproses</span>
                                        @endif
                                    </x-ui::table-cell>
                                </x-ui::table-row>
                            @endforeach
                        </x-ui::table-body>
                    </x-ui::table>
                @else
                    <div class="text-center py-6 text-muted-foreground text-sm">
                        Tidak ada pendaftaran terbaru.
                    </div>
                @endif
            </x-ui::card-content>
        </x-ui::card>

        {{-- UKM Terpopuler Progress Bars --}}
        @php
            $topUkms = \App\Models\Ukm::withCount('anggota')->orderByDesc('anggota_count')->take(5)->get();
            $maxAnggota = $topUkms->max('anggota_count') ?: 1;
        @endphp
        <x-ui::card variant="sectioned" class="lg:col-span-3">
            <x-ui::card-header>
                <x-ui::card-title>UKM Terpopuler</x-ui::card-title>
                <x-ui::card-description>Unit Kegiatan Mahasiswa dengan anggota terbanyak</x-ui::card-description>
            </x-ui::card-header>
            <x-ui::card-content class="space-y-4">
                @forelse ($topUkms as $ukm)
                    @php
                        $pct = ($ukm->anggota_count / $maxAnggota) * 100;
                    @endphp
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between text-sm">
                            <span class="font-medium text-xs md:text-sm truncate mr-2" title="{{ $ukm->nama }}">{{ $ukm->nama }}</span>
                            <span class="text-muted-foreground tabular-nums text-xs whitespace-nowrap shrink-0">{{ number_format($ukm->anggota_count) }} anggota</span>
                        </div>
                        <x-ui::progress :value="$pct" class="h-2" />
                    </div>
                @empty
                    <div class="text-center py-6 text-muted-foreground text-sm">
                        Belum ada data UKM.
                    </div>
                @endforelse
            </x-ui::card-content>
        </x-ui::card>
    </div>

    @else
    {{-- ============================================ --}}
    {{-- PENGURUS (KETUA / SEKRETARIS) DASHBOARD --}}
    {{-- ============================================ --}}

    {{-- KPI cards: hanya Total Anggota + Anggota Aktif --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        {{-- Card 1: Total Anggota --}}
        <x-ui::card variant="sectioned">
            <x-ui::card-header>
                <x-ui::card-description class="flex items-center gap-2">
                    <x-lucide-users class="size-4 text-primary" /> Total Anggota
                </x-ui::card-description>
                <x-ui::card-title class="text-2xl font-semibold tabular-nums">{{ number_format($totalAnggota) }}</x-ui::card-title>
            </x-ui::card-header>
            <x-ui::card-footer class="text-sm">
                <span class="text-muted-foreground inline-flex items-center gap-1">
                    <x-lucide-building-2 class="size-3.5" /> {{ $myUkm->nama ?? '-' }}
                </span>
            </x-ui::card-footer>
        </x-ui::card>

        {{-- Card 2: Anggota Aktif --}}
        <x-ui::card variant="sectioned">
            <x-ui::card-header>
                <x-ui::card-description class="flex items-center gap-2">
                    <x-lucide-check-circle class="size-4 text-emerald-600" /> Anggota Aktif
                </x-ui::card-description>
                <x-ui::card-title class="text-2xl font-semibold tabular-nums">{{ number_format($anggotaAktif) }}</x-ui::card-title>
            </x-ui::card-header>
            <x-ui::card-footer class="text-sm">
                <span class="text-emerald-600 dark:text-emerald-400 inline-flex items-center gap-1 font-medium">
                    <x-lucide-check class="size-3.5" /> Semua terdaftar
                </span>
            </x-ui::card-footer>
        </x-ui::card>
    </div>

    {{-- Daftar Anggota UKM Saya --}}
    <x-ui::card variant="sectioned">
        <x-ui::card-header class="flex flex-row items-center justify-between pb-2">
            <div>
                <x-ui::card-title>Daftar Anggota {{ $myUkm->nama ?? '' }}</x-ui::card-title>
                <x-ui::card-description>Anggota aktif di Unit Kegiatan Mahasiswa Anda</x-ui::card-description>
            </div>
            <x-ui::button href="{{ route('ukm.index') }}" variant="outline" size="sm">
                Kelola UKM
            </x-ui::button>
        </x-ui::card-header>
        <x-ui::card-content>
            @if(isset($anggotaList) && $anggotaList->count() > 0)
                <x-ui::table>
                    <x-ui::table-header>
                        <x-ui::table-row>
                            <x-ui::table-head class="w-12">No</x-ui::table-head>
                            <x-ui::table-head>Nama</x-ui::table-head>
                            <x-ui::table-head>NIM</x-ui::table-head>
                            <x-ui::table-head>Kelas</x-ui::table-head>
                            <x-ui::table-head>Jabatan</x-ui::table-head>
                        </x-ui::table-row>
                    </x-ui::table-header>
                    <x-ui::table-body>
                        @foreach($anggotaList as $idx => $a)
                            <x-ui::table-row>
                                <x-ui::table-cell>{{ $idx + 1 }}</x-ui::table-cell>
                                <x-ui::table-cell class="font-medium">{{ $a->user->nama }}</x-ui::table-cell>
                                <x-ui::table-cell class="tabular-nums font-mono text-xs">{{ $a->user->nim }}</x-ui::table-cell>
                                <x-ui::table-cell>{{ $a->user->kelas }}</x-ui::table-cell>
                                <x-ui::table-cell>
                                    @if($a->jabatan === 'ketua')
                                        <x-ui::badge variant="default" class="text-xs">Ketua</x-ui::badge>
                                    @elseif($a->jabatan === 'sekretaris')
                                        <x-ui::badge variant="secondary" class="text-xs">Sekretaris</x-ui::badge>
                                    @else
                                        <x-ui::badge variant="outline" class="text-xs">Anggota</x-ui::badge>
                                    @endif
                                </x-ui::table-cell>
                            </x-ui::table-row>
                        @endforeach
                    </x-ui::table-body>
                </x-ui::table>
            @else
                <div class="text-center py-8 text-muted-foreground text-sm">
                    <x-lucide-users class="size-10 mx-auto mb-3 opacity-30" />
                    Belum ada anggota di UKM Anda.
                </div>
            @endif
        </x-ui::card-content>
    </x-ui::card>

    @endif
</div>
@endsection
