@extends('layouts.app')

@section('title', 'Edit Anggota')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.anggota.index') }}" class="text-muted-foreground hover:text-foreground">
            <x-lucide-arrow-left class="size-5" />
        </a>
        <h1 class="text-2xl font-bold tracking-tight">Edit Anggota</h1>
    </div>

    <x-ui::card>
        <x-ui::card-header>
            <x-ui::card-title>Form Edit Anggota</x-ui::card-title>
            <x-ui::card-description>Ubah data anggota UKM</x-ui::card-description>
        </x-ui::card-header>
        <x-ui::card-content>
            <form method="POST" action="{{ route('admin.anggota.update', $anggotaData->id) }}" class="space-y-4">
                @csrf @method('PUT')

                <div class="grid grid-cols-2 gap-4">
                    <x-ui::field>
                        <x-ui::field-label for="nama">Nama Lengkap</x-ui::field-label>
                        <x-ui::input id="nama" type="text" name="nama" value="{{ old('nama', $anggotaData->user->nama) }}" required />
                    </x-ui::field>

                    <x-ui::field>
                        <x-ui::field-label for="nim">NIM</x-ui::field-label>
                        <x-ui::input id="nim" type="text" name="nim" value="{{ old('nim', $anggotaData->user->nim) }}" required />
                    </x-ui::field>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <x-ui::field>
                        <x-ui::field-label for="kelas">Kelas</x-ui::field-label>
                        <x-ui::input id="kelas" type="text" name="kelas" value="{{ old('kelas', $anggotaData->user->kelas) }}" required />
                    </x-ui::field>

                    <x-ui::field>
                        <x-ui::field-label for="prodi">Prodi</x-ui::field-label>
                        <x-ui::input id="prodi" type="text" name="prodi" value="{{ old('prodi', $anggotaData->user->prodi) }}" required />
                    </x-ui::field>
                </div>

                <x-ui::field>
                    <x-ui::field-label for="jurusan">Jurusan</x-ui::field-label>
                    <x-ui::input id="jurusan" type="text" name="jurusan" value="{{ old('jurusan', $anggotaData->user->jurusan) }}" required />
                </x-ui::field>

                <x-ui::field>
                    <x-ui::field-label for="ukm_id">UKM</x-ui::field-label>
                    <x-ui::select id="ukm_id" name="ukm_id" native required>
                        @foreach($ukmList as $ukm)
                        <option value="{{ $ukm->id }}" {{ $ukm->id == $anggotaData->ukm_id ? 'selected' : '' }}>{{ $ukm->nama }}</option>
                        @endforeach
                    </x-ui::select>
                </x-ui::field>

                <x-ui::separator />

                <div class="flex gap-4">
                    <x-ui::button type="submit">Update</x-ui::button>
                    <x-ui::button href="{{ route('admin.anggota.index') }}" variant="outline">Batal</x-ui::button>
                </div>
            </form>
        </x-ui::card-content>
    </x-ui::card>
</div>
@endsection
