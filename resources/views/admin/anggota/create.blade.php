@extends('layouts.app')

@section('title', 'Tambah Anggota')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.anggota.index') }}" class="text-muted-foreground hover:text-foreground">
            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h1 class="text-2xl font-bold tracking-tight">Tambah Anggota</h1>
    </div>

    <x-ui::card>
        <x-ui::card-header>
            <x-ui::card-title>Form Tambah Anggota</x-ui::card-title>
            <x-ui::card-description>Tambah anggota UKM baru</x-ui::card-description>
        </x-ui::card-header>
        <x-ui::card-content>
            <form method="POST" action="{{ route('admin.anggota.store') }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <x-ui::field>
                        <x-ui::field-label for="nama">Nama Lengkap</x-ui::field-label>
                        <x-ui::input id="nama" type="text" name="nama" value="{{ old('nama') }}" required />
                    </x-ui::field>

                    <x-ui::field>
                        <x-ui::field-label for="nim">NIM</x-ui::field-label>
                        <x-ui::input id="nim" type="text" name="nim" value="{{ old('nim') }}" required />
                    </x-ui::field>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <x-ui::field>
                        <x-ui::field-label for="kelas">Kelas</x-ui::field-label>
                        <x-ui::input id="kelas" type="text" name="kelas" value="{{ old('kelas') }}" required />
                    </x-ui::field>

                    <x-ui::field>
                        <x-ui::field-label for="prodi">Prodi</x-ui::field-label>
                        <x-ui::input id="prodi" type="text" name="prodi" value="{{ old('prodi') }}" required />
                    </x-ui::field>
                </div>

                <x-ui::field>
                    <x-ui::field-label for="jurusan">Jurusan</x-ui::field-label>
                    <x-ui::input id="jurusan" type="text" name="jurusan" value="{{ old('jurusan') }}" required />
                </x-ui::field>

                <x-ui::field>
                    <x-ui::field-label for="ukm_id">UKM</x-ui::field-label>
                    <x-ui::select id="ukm_id" name="ukm_id" native required>
                        @foreach($ukmList as $ukm)
                        <option value="{{ $ukm->id }}">{{ $ukm->nama }}</option>
                        @endforeach
                    </x-ui::select>
                </x-ui::field>

                <x-ui::separator />

                <div class="flex gap-4">
                    <x-ui::button type="submit">Simpan</x-ui::button>
                    <x-ui::button href="{{ route('admin.anggota.index') }}" variant="outline">Batal</x-ui::button>
                </div>
            </form>
        </x-ui::card-content>
    </x-ui::card>
</div>
@endsection
