@extends('layouts.app')

@section('title', 'Edit Mahasiswa')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center gap-2">
        <a href="{{ route('mahasiswa.index') }}" class="text-muted-foreground hover:text-foreground">
            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h1 class="text-2xl font-bold tracking-tight">Edit Mahasiswa</h1>
    </div>

    <x-ui::card>
        <x-ui::card-header>
            <x-ui::card-title>Form Edit Mahasiswa</x-ui::card-title>
            <x-ui::card-description>Ubah data mahasiswa</x-ui::card-description>
        </x-ui::card-header>
        <x-ui::card-content>
            <form method="POST" action="{{ route('mahasiswa.update', $mahasiswa->id) }}" class="space-y-4">
                @csrf @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <x-ui::field>
                        <x-ui::field-label for="nim">NIM</x-ui::field-label>
                        <x-ui::input id="nim" type="text" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" required />
                    </x-ui::field>
                    <x-ui::field>
                        <x-ui::field-label for="nama">Nama Lengkap</x-ui::field-label>
                        <x-ui::input id="nama" type="text" name="nama" value="{{ old('nama', $mahasiswa->nama) }}" required />
                    </x-ui::field>
                </div>

                <x-ui::field>
                    <x-ui::field-label for="kelas">Kelas</x-ui::field-label>
                    <x-ui::input id="kelas" type="text" name="kelas" value="{{ old('kelas', $mahasiswa->kelas) }}" required />
                </x-ui::field>

                <div class="grid grid-cols-2 gap-4">
                    <x-ui::field>
                        <x-ui::field-label for="prodi">Prodi</x-ui::field-label>
                        <x-ui::input id="prodi" type="text" name="prodi" value="{{ old('prodi', $mahasiswa->prodi) }}" required />
                    </x-ui::field>
                    <x-ui::field>
                        <x-ui::field-label for="jurusan">Jurusan</x-ui::field-label>
                        <x-ui::input id="jurusan" type="text" name="jurusan" value="{{ old('jurusan', $mahasiswa->jurusan) }}" required />
                    </x-ui::field>
                </div>

                <x-ui::separator />

                <div class="flex gap-2">
                    <x-ui::button type="submit">Update</x-ui::button>
                    <x-ui::button href="{{ route('mahasiswa.index') }}" variant="outline">Batal</x-ui::button>
                </div>
            </form>
        </x-ui::card-content>
    </x-ui::card>
</div>
@endsection
