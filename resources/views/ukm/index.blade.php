@extends('layouts.app')

@section('title', 'Data Unit Kegiatan Mahasiswa')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-2xl font-bold tracking-tight">Data Unit Kegiatan Mahasiswa (UKM)</h2>
        <div class="flex flex-wrap gap-2">
            <x-ui:button href="{{ route('ukm.create') }}">
                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah UKM
            </x-ui:button>
            <x-ui:button href="{{ route('ukm.export') }}" variant="secondary">Export Excel</x-ui:button>
            <x-ui:button href="{{ route('ukm.cetak') }}" variant="outline">Cetak</x-ui:button>
        </div>
    </div>

    <x-ui:card>
        <x-ui:card-content>
            <form method="POST" action="{{ route('ukm.search') }}">
                @csrf
                <div class="flex gap-2">
                    <x-ui:input type="text" name="keyword" placeholder="Cari nama UKM..." class="flex-1" />
                    <x-ui:button type="submit">Cari</x-ui:button>
                    <x-ui:button href="{{ route('ukm.index') }}" variant="outline">Reset</x-ui:button>
                </div>
            </form>
        </x-ui:card-content>
    </x-ui:card>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($ukmList as $ukm)
        <x-ui:card>
            <x-ui:card-header class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-t-xl text-white">
                <x-ui:card-title class="text-white">{{ $ukm->nama }}</x-ui:card-title>
            </x-ui:card-header>
            <x-ui:card-content>
                <p class="text-muted-foreground text-sm mb-4">{{ Str::limit($ukm->deskripsi, 100) }}</p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-medium">{{ $ukm->anggota_count ?? 0 }} Anggota</span>
                    </div>
                    <div class="flex gap-2">
                        <x-ui:button href="{{ route('ukm.edit', $ukm->id) }}" size="xs" variant="outline">Edit</x-ui:button>
                        <form method="POST" action="{{ route('ukm.destroy', $ukm->id) }}" onsubmit="return confirm('Yakin hapus?')">
                            @csrf @method('DELETE')
                            <x-ui:button type="submit" size="xs" variant="destructive">Hapus</x-ui:button>
                        </form>
                    </div>
                </div>
            </x-ui:card-content>
        </x-ui:card>
        @endforeach
    </div>
</div>
@endsection
