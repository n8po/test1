@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center gap-2">
        <a href="{{ route('mahasiswa.index') }}" class="text-muted-foreground hover:text-foreground">
            <x-lucide-arrow-left class="size-5" />
        </a>
        <h1 class="text-2xl font-bold tracking-tight">Tambah Mahasiswa</h1>
    </div>

    <x-ui::card>
        <x-ui::card-header>
            <x-ui::card-title>Form Tambah Mahasiswa</x-ui::card-title>
            <x-ui::card-description>Isi data mahasiswa baru</x-ui::card-description>
        </x-ui::card-header>
        <x-ui::card-content>
            <form method="POST" action="{{ route('mahasiswa.store') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <x-ui::field>
                        <x-ui::field-label for="nim">NIM</x-ui::field-label>
                        <x-ui::input id="nim" type="text" name="nim" value="{{ old('nim') }}" placeholder="Masukkan NIM" required />
                    </x-ui::field>
                    <x-ui::field>
                        <x-ui::field-label for="nama">Nama Lengkap</x-ui::field-label>
                        <x-ui::input id="nama" type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama" required />
                    </x-ui::field>
                </div>

                <x-ui::field>
                    <x-ui::field-label for="kelas">Kelas</x-ui::field-label>
                    <x-ui::input id="kelas" type="text" name="kelas" value="{{ old('kelas') }}" placeholder="Contoh: TI-1A" required />
                </x-ui::field>

                <div class="grid grid-cols-2 gap-4">
                    <x-ui::field>
                        <x-ui::field-label for="prodi">Prodi</x-ui::field-label>
                        <x-ui::input id="prodi" type="text" name="prodi" value="{{ old('prodi') }}" placeholder="Contoh: Teknik Informatika" required />
                    </x-ui::field>
                    <x-ui::field>
                        <x-ui::field-label for="jurusan">Jurusan</x-ui::field-label>
                        <x-ui::input id="jurusan" type="text" name="jurusan" value="{{ old('jurusan') }}" placeholder="Contoh: Teknologi Informasi" required />
                    </x-ui::field>
                </div>

                <x-ui::separator />

                <div class="flex gap-2">
                    <x-ui::button type="submit">Simpan</x-ui::button>
                    <x-ui::button href="{{ route('mahasiswa.index') }}" variant="outline">Batal</x-ui::button>
                </div>
            </form>
        </x-ui::card-content>
    </x-ui::card>
</div>
@endsection
