@extends('layouts.app')

@section('title', 'Kelola Anggota UKM')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-2xl font-bold tracking-tight">Kelola Anggota UKM</h2>
        <div class="flex flex-wrap gap-2">
            <x-ui:button href="{{ route('admin.anggota.create') }}">Tambah Anggota</x-ui:button>
            <x-ui:button href="{{ route('admin.anggota.export') }}" variant="secondary">Export CSV</x-ui:button>
            <x-ui:button href="{{ route('admin.anggota.cetak') }}" variant="outline">Cetak PDF</x-ui:button>
        </div>
    </div>

    <x-ui:card>
        <x-ui:card-content class="p-0">
            <x-ui:table>
                <x-ui:table-header>
                    <x-ui:table-row>
                        <x-ui:table-head>No</x-ui:table-head>
                        <x-ui:table-head>Nama</x-ui:table-head>
                        <x-ui:table-head>NIM</x-ui:table-head>
                        <x-ui:table-head>Kelas</x-ui:table-head>
                        <x-ui:table-head>Prodi</x-ui:table-head>
                        <x-ui:table-head>UKM</x-ui:table-head>
                        <x-ui:table-head>Aksi</x-ui:table-head>
                    </x-ui:table-row>
                </x-ui:table-header>
                <x-ui:table-body>
                    @foreach($anggotaList as $i => $a)
                    <x-ui:table-row>
                        <x-ui:table-cell>{{ $i + 1 }}</x-ui:table-cell>
                        <x-ui:table-cell>{{ $a->user->nama }}</x-ui:table-cell>
                        <x-ui:table-cell>{{ $a->user->nim }}</x-ui:table-cell>
                        <x-ui:table-cell>{{ $a->user->kelas }}</x-ui:table-cell>
                        <x-ui:table-cell>{{ $a->user->prodi }}</x-ui:table-cell>
                        <x-ui:table-cell>{{ $a->ukm->nama }}</x-ui:table-cell>
                        <x-ui:table-cell>
                            <div class="flex gap-2">
                                <x-ui:button href="{{ route('admin.anggota.edit', $a->id) }}" size="xs" variant="outline">Edit</x-ui:button>
                                <form method="POST" action="{{ route('admin.anggota.destroy', $a->id) }}" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf @method('DELETE')
                                    <x-ui:button type="submit" size="xs" variant="destructive">Hapus</x-ui:button>
                                </form>
                            </div>
                        </x-ui:table-cell>
                    </x-ui:table-row>
                    @endforeach
                </x-ui:table-body>
            </x-ui:table>
        </x-ui:card-content>
    </x-ui:card>
</div>
@endsection
