@extends('layouts.app')
@section('title', 'Pendaftaran')
@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-2xl font-bold tracking-tight">Data Pendaftaran</h2>
        <div class="flex flex-wrap gap-2">
            <x-ui::button href="{{ route('pendaftaran.export') }}" variant="secondary">Export CSV</x-ui::button>
            <x-ui::button href="{{ route('pendaftaran.cetak') }}" variant="outline">Cetak</x-ui::button>
        </div>
    </div>

    {{-- Search --}}
    <x-ui::card>
        <x-ui::card-content>
            <form method="POST" action="{{ route('pendaftaran.search') }}">
                @csrf
                <div class="flex gap-2">
                    <x-ui::input type="text" name="keyword" placeholder="Cari nama, NIM, atau UKM..." class="flex-1" />
                    <x-ui::button type="submit">Cari</x-ui::button>
                    <x-ui::button href="{{ route('pendaftaran.index') }}" variant="outline">Reset</x-ui::button>
                </div>
            </form>
        </x-ui::card-content>
    </x-ui::card>

    <x-ui::card>
        <x-ui::card-header>
            <x-ui::card-title>Daftar Pendaftaran</x-ui::card-title>
            <x-ui::card-description>Kelola pendaftaran anggota UKM</x-ui::card-description>
        </x-ui::card-header>
        <x-ui::card-content class="p-0">
            <x-ui::table>
                <x-ui::table-header>
                    <x-ui::table-row>
                        <x-ui::table-head>No</x-ui::table-head>
                        <x-ui::table-head>Nama</x-ui::table-head>
                        <x-ui::table-head>NIM</x-ui::table-head>
                        <x-ui::table-head>UKM</x-ui::table-head>
                        <x-ui::table-head>Status</x-ui::table-head>
                        <x-ui::table-head>Aksi</x-ui::table-head>
                    </x-ui::table-row>
                </x-ui::table-header>
                <x-ui::table-body>
                    @forelse($pendaftaranList as $i => $p)
                    <x-ui::table-row>
                        <x-ui::table-cell>{{ $i + 1 }}</x-ui::table-cell>
                        <x-ui::table-cell>{{ $p->user->nama ?? '-' }}</x-ui::table-cell>
                        <x-ui::table-cell>{{ $p->user->nim ?? '-' }}</x-ui::table-cell>
                        <x-ui::table-cell>{{ $p->ukm->nama ?? '-' }}</x-ui::table-cell>
                        <x-ui::table-cell>
                            <x-ui::badge variant="{{ $p->status == 'pending' ? 'outline' : ($p->status == 'diterima' ? 'secondary' : 'destructive') }}">
                                {{ $p->status }}
                            </x-ui::badge>
                        </x-ui::table-cell>
                        <x-ui::table-cell>
                            @if($p->status == 'pending')
                            <form method="POST" action="{{ route('pendaftaran.setujui', $p->id) }}" class="inline mr-1">
                                @csrf
                                <x-ui::button type="submit" size="xs" variant="secondary">Setujui</x-ui::button>
                            </form>
                            <form method="POST" action="{{ route('pendaftaran.tolak', $p->id) }}" class="inline">
                                @csrf
                                <x-ui::button type="submit" size="xs" variant="destructive">Tolak</x-ui::button>
                            </form>
                            @else
                            <span class="text-sm text-muted-foreground">Selesai</span>
                            @endif
                        </x-ui::table-cell>
                    </x-ui::table-row>
                    @empty
                    <x-ui::table-row>
                        <x-ui::table-cell colspan="6" class="text-center text-muted-foreground py-8">
                            Belum ada data pendaftaran
                        </x-ui::table-cell>
                    </x-ui::table-row>
                    @endforelse
                </x-ui::table-body>
            </x-ui::table>
        </x-ui::card-content>
    </x-ui::card>
</div>
@endsection
