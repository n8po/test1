@extends('layouts.app')
@section('title', 'Tambah Anggota')
@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.anggota.index') }}" class="text-muted-foreground hover:text-foreground">
            <x-lucide-arrow-left class="size-5" />
        </a>
        <h1 class="text-2xl font-bold tracking-tight">Tambah Anggota</h1>
    </div>

    <x-ui::card>
        <x-ui::card-header>
            <x-ui::card-title>Form Tambah Anggota</x-ui::card-title>
            <x-ui::card-description>Pilih mahasiswa yang sudah terdaftar untuk ditambahkan ke UKM</x-ui::card-description>
        </x-ui::card-header>
        <x-ui::card-content>
            <form method="POST" action="{{ route('admin.anggota.store') }}" class="space-y-4">
                @csrf

                <x-ui::field>
                    <x-ui::field-label for="user_id">Pilih Mahasiswa</x-ui::field-label>
                    <x-ui::select id="user_id" name="user_id" native required>
                        <option value="">-- Pilih Mahasiswa --</option>
                        @foreach($mahasiswaList as $m)
                        <option value="{{ $m->id }}" {{ old('user_id') == $m->id ? 'selected' : '' }}>
                            {{ $m->nim }} - {{ $m->nama }} ({{ $m->kelas }}/{{ $m->prodi }})
                        </option>
                        @endforeach
                    </x-ui::select>
                    @if($mahasiswaList->isEmpty())
                    <p class="text-xs text-muted-foreground mt-1">Semua mahasiswa sudah terdaftar di UKM</p>
                    @endif
                </x-ui::field>

                <x-ui::field>
                    <x-ui::field-label for="ukm_id">UKM</x-ui::field-label>
                    <x-ui::select id="ukm_id" name="ukm_id" native required>
                        <option value="">-- Pilih UKM --</option>
                        @foreach($ukmList as $ukm)
                        <option value="{{ $ukm->id }}" {{ old('ukm_id') == $ukm->id ? 'selected' : '' }}>{{ $ukm->nama }}</option>
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
