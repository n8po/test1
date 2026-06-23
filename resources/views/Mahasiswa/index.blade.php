@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-2xl font-bold tracking-tight">Data Mahasiswa</h2>
        <div class="flex flex-wrap gap-2">
            <x-ui::button href="{{ route('mahasiswa.create') }}">
                <x-lucide-plus class="size-4" />
                Tambah
            </x-ui::button>
            <x-ui::button href="{{ route('mahasiswa.export') }}" variant="secondary">
                <x-lucide-download class="size-4" />
                Export Excel
            </x-ui::button>
            <x-ui::button href="{{ route('mahasiswa.cetak') }}" variant="outline">
                <x-lucide-printer class="size-4" />
                Cetak
            </x-ui::button>
        </div>
    </div>

    {{-- Search --}}
    <x-ui::card>
        <x-ui::card-content>
            <form method="POST" action="{{ route('mahasiswa.search') }}">
                @csrf
                <div class="flex gap-2">
                    <x-ui::input type="text" name="keyword" placeholder="Cari nama, NIM, atau kelas..." value="{{ request()->old('keyword') }}" class="flex-1" />
                    <x-ui::button type="submit">Cari</x-ui::button>
                    <x-ui::button href="{{ route('mahasiswa.index') }}" variant="outline">Reset</x-ui::button>
                </div>
            </form>
        </x-ui::card-content>
    </x-ui::card>

    {{-- Table --}}
    <x-ui::card>
        <x-ui::card-content class="p-0">
            <x-ui::table>
                <x-ui::table-header>
                    <x-ui::table-row>
                        <x-ui::table-head>No</x-ui::table-head>
                        <x-ui::table-head>NIM</x-ui::table-head>
                        <x-ui::table-head>Nama</x-ui::table-head>
                        <x-ui::table-head>Kelas</x-ui::table-head>
                        <x-ui::table-head>Prodi</x-ui::table-head>
                        <x-ui::table-head>Jurusan</x-ui::table-head>
                        <x-ui::table-head>UKM</x-ui::table-head>
                        <x-ui::table-head>Aksi</x-ui::table-head>
                    </x-ui::table-row>
                </x-ui::table-header>
                <x-ui::table-body>
                    @foreach($mahasiswaList as $index => $m)
                    <x-ui::table-row>
                        <x-ui::table-cell>{{ $index + 1 }}</x-ui::table-cell>
                        <x-ui::table-cell class="font-mono">{{ $m->nim }}</x-ui::table-cell>
                        <x-ui::table-cell>{{ $m->nama }}</x-ui::table-cell>
                        <x-ui::table-cell>{{ $m->kelas }}</x-ui::table-cell>
                        <x-ui::table-cell>{{ $m->prodi }}</x-ui::table-cell>
                        <x-ui::table-cell>{{ $m->jurusan }}</x-ui::table-cell>
                        <x-ui::table-cell>
                            @if($m->UKM === 'Belum Memilih')
                                <x-ui::badge variant="outline">Belum Memilih</x-ui::badge>
                            @else
                                <x-ui::badge variant="secondary">{{ $m->UKM }}</x-ui::badge>
                            @endif
                        </x-ui::table-cell>
                        <x-ui::table-cell>
                            <div class="flex gap-2">
                                <x-ui::button href="{{ route('mahasiswa.edit', $m->id) }}" size="xs" variant="outline">Edit</x-ui::button>
                                <form method="POST" action="{{ route('mahasiswa.destroy', $m->id) }}" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf @method('DELETE')
                                    <x-ui::button type="submit" size="xs" variant="destructive">Hapus</x-ui::button>
                                </form>
                            </div>
                        </x-ui::table-cell>
                    </x-ui::table-row>
                    @endforeach
                </x-ui::table-body>
            </x-ui::table>
        </x-ui::card-content>
    </x-ui::card>
</div>
@endsection
