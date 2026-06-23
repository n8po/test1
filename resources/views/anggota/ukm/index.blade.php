@extends('layouts.app')
@section('title', 'Anggota UKM')
@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-2xl font-bold tracking-tight">Anggota UKM</h2>
        <div class="flex flex-wrap gap-2">
            <x-ui::button href="{{ route('admin.anggota.export') }}" variant="secondary">Export CSV</x-ui::button>
            <x-ui::button href="{{ route('admin.anggota.cetak') }}" variant="outline">Cetak</x-ui::button>
        </div>
    </div>

    <x-ui::card>
        <x-ui::card-content class="p-0">
            <x-ui::table>
                <x-ui::table-header>
                    <x-ui::table-row>
                        <x-ui::table-head>No</x-ui::table-head>
                        <x-ui::table-head>Nama</x-ui::table-head>
                        <x-ui::table-head>NIM</x-ui::table-head>
                        <x-ui::table-head>Kelas</x-ui::table-head>
                        <x-ui::table-head>Prodi</x-ui::table-head>
                        <x-ui::table-head>UKM</x-ui::table-head>
                        <x-ui::table-head>Jabatan</x-ui::table-head>
                    </x-ui::table-row>
                </x-ui::table-header>
                <x-ui::table-body>
                    @forelse($anggotaList as $i => $a)
                    <x-ui::table-row>
                        <x-ui::table-cell>{{ $i + 1 }}</x-ui::table-cell>
                        <x-ui::table-cell>{{ $a->user->nama ?? '-' }}</x-ui::table-cell>
                        <x-ui::table-cell>{{ $a->user->nim ?? '-' }}</x-ui::table-cell>
                        <x-ui::table-cell>{{ $a->user->kelas ?? '-' }}</x-ui::table-cell>
                        <x-ui::table-cell>{{ $a->user->prodi ?? '-' }}</x-ui::table-cell>
                        <x-ui::table-cell>{{ $a->ukm->nama ?? '-' }}</x-ui::table-cell>
                        <x-ui::table-cell>
                            <x-ui::badge variant="{{ $a->user->Role == 'ketua' ? 'default' : ($a->user->Role == 'sekretaris' ? 'secondary' : 'outline') }}">
                                {{ ucfirst($a->user->Role ?? 'anggota') }}
                            </x-ui::badge>
                        </x-ui::table-cell>
                    </x-ui::table-row>
                    @empty
                    <x-ui::table-row>
                        <x-ui::table-cell colspan="7" class="text-center text-muted-foreground py-8">
                            Belum ada anggota UKM
                        </x-ui::table-cell>
                    </x-ui::table-row>
                    @endforelse
                </x-ui::table-body>
            </x-ui::table>
        </x-ui::card-content>
    </x-ui::card>
</div>
@endsection
