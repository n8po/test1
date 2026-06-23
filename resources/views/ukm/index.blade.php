@extends('layouts.app')
@section('title', 'Data Unit Kegiatan Mahasiswa')
@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-2xl font-bold tracking-tight">Data Unit Kegiatan Mahasiswa (UKM)</h2>
        <div class="flex flex-wrap gap-2">
            <x-ui::button href="{{ route('ukm.create') }}">
                <x-lucide-plus class="size-4" />
                Tambah UKM
            </x-ui::button>
            <x-ui::button href="{{ route('ukm.export') }}" variant="secondary">
                <x-lucide-download class="size-4" />
                Export Excel
            </x-ui::button>
            <x-ui::button href="{{ route('ukm.cetak') }}" variant="outline">
                <x-lucide-printer class="size-4" />
                Cetak
            </x-ui::button>
        </div>
    </div>

    {{-- Search --}}
    <x-ui::card>
        <x-ui::card-content>
            <form method="POST" action="{{ route('ukm.search') }}">
                @csrf
                <div class="flex gap-2">
                    <x-ui::input type="text" name="keyword" placeholder="Cari nama UKM..." class="flex-1" />
                    <x-ui::button type="submit">
                        <x-lucide-search class="size-4" />
                        Cari
                    </x-ui::button>
                    <x-ui::button href="{{ route('ukm.index') }}" variant="outline">Reset</x-ui::button>
                </div>
            </form>
        </x-ui::card-content>
    </x-ui::card>

    {{-- UKM Card Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($ukmList as $ukm)
        <x-ui::card class="hover:shadow-md transition-shadow">
            <x-ui::card-header class="pb-3">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-primary/10 p-2.5 text-primary">
                        <x-lucide-building-2 class="size-5" />
                    </div>
                    <div>
                        <x-ui::card-title class="text-base">{{ $ukm->nama }}</x-ui::card-title>
                        <x-ui::card-description>{{ Str::limit($ukm->deskripsi, 60) }}</x-ui::card-description>
                    </div>
                </div>
            </x-ui::card-header>
            <x-ui::card-content>
                <x-ui::separator class="my-3" />
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 text-sm text-muted-foreground">
                        <x-lucide-users class="size-4" />
                        <span>{{ $ukm->anggota_count ?? 0 }} Anggota</span>
                    </div>
                    <div class="flex gap-2">
                        <x-ui::button href="{{ route('ukm.edit', $ukm->id) }}" size="sm" variant="outline">
                            <x-lucide-pencil class="size-3.5" />
                            Edit
                        </x-ui::button>
                        <form method="POST" action="{{ route('ukm.destroy', $ukm->id) }}" onsubmit="return confirm('Yakin hapus UKM ini?')">
                            @csrf @method('DELETE')
                            <x-ui::button type="submit" size="sm" variant="destructive">
                                <x-lucide-trash-2 class="size-3.5" />
                                Hapus
                            </x-ui::button>
                        </form>
                    </div>
                </div>
            </x-ui::card-content>
        </x-ui::card>
        @empty
        <div class="col-span-full">
            <x-ui::card>
                <x-ui::card-content class="text-center py-12">
                    <x-lucide-building-2 class="size-12 mx-auto text-muted-foreground mb-4" />
                    <p class="text-muted-foreground">Belum ada data UKM</p>
                    <x-ui::button href="{{ route('ukm.create') }}" class="mt-4">Tambah UKM Baru</x-ui::button>
                </x-ui::card-content>
            </x-ui::card>
        </div>
        @endforelse
    </div>
</div>
@endsection
