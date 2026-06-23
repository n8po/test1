@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-2xl font-bold tracking-tight">Data Mahasiswa</h2>
        <div class="flex flex-wrap gap-2">
            <x-ui:button href="{{ route('mahasiswa.create') }}">
                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah
            </x-ui:button>
            <x-ui:button href="{{ route('mahasiswa.export') }}" variant="secondary">
                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export Excel
            </x-ui:button>
            <x-ui:button href="{{ route('mahasiswa.cetak') }}" variant="outline">
                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak
            </x-ui:button>
        </div>
    </div>

    {{-- Search --}}
    <x-ui:card>
        <x-ui:card-content>
            <form method="POST" action="{{ route('mahasiswa.search') }}">
                @csrf
                <div class="flex gap-2">
                    <x-ui:input type="text" name="keyword" placeholder="Cari nama, NIM, atau kelas..." value="{{ request()->old('keyword') }}" class="flex-1" />
                    <x-ui:button type="submit">Cari</x-ui:button>
                    <x-ui:button href="{{ route('mahasiswa.index') }}" variant="outline">Reset</x-ui:button>
                </div>
            </form>
        </x-ui:card-content>
    </x-ui:card>

    {{-- Table --}}
    <x-ui:card>
        <x-ui:card-content class="p-0">
            <x-ui:table>
                <x-ui:table-header>
                    <x-ui:table-row>
                        <x-ui:table-head>No</x-ui:table-head>
                        <x-ui:table-head>NIM</x-ui:table-head>
                        <x-ui:table-head>Nama</x-ui:table-head>
                        <x-ui:table-head>Kelas</x-ui:table-head>
                        <x-ui:table-head>Prodi</x-ui:table-head>
                        <x-ui:table-head>Jurusan</x-ui:table-head>
                        <x-ui:table-head>UKM</x-ui:table-head>
                        <x-ui:table-head>Aksi</x-ui:table-head>
                    </x-ui:table-row>
                </x-ui:table-header>
                <x-ui:table-body>
                    @foreach($mahasiswaList as $index => $m)
                    <x-ui:table-row>
                        <x-ui:table-cell>{{ $index + 1 }}</x-ui:table-cell>
                        <x-ui:table-cell class="font-mono">{{ $m->nim }}</x-ui:table-cell>
                        <x-ui:table-cell>{{ $m->nama }}</x-ui:table-cell>
                        <x-ui:table-cell>{{ $m->kelas }}</x-ui:table-cell>
                        <x-ui:table-cell>{{ $m->prodi }}</x-ui:table-cell>
                        <x-ui:table-cell>{{ $m->jurusan }}</x-ui:table-cell>
                        <x-ui:table-cell>
                            @if($m->UKM === 'Belum Memilih')
                                <x-ui:badge variant="outline">Belum Memilih</x-ui:badge>
                            @else
                                <x-ui:badge variant="secondary">{{ $m->UKM }}</x-ui:badge>
                            @endif
                        </x-ui:table-cell>
                        <x-ui:table-cell>
                            <div class="flex gap-2">
                                <x-ui:button href="{{ route('mahasiswa.edit', $m->id) }}" size="xs" variant="outline">Edit</x-ui:button>
                                <form method="POST" action="{{ route('mahasiswa.destroy', $m->id) }}" onsubmit="return confirm('Yakin hapus?')">
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
