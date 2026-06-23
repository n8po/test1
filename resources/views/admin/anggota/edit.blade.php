@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <x-ui:card>
        <x-ui:card-header>
            <x-ui:card-title>Edit Anggota</x-ui:card-title>
        </x-ui:card-header>
        <x-ui:card-content>
            <form method="POST" action="{{ route('admin.anggota.update', $anggota->id) }}" class="space-y-4">
                @csrf @method('PUT')
                <x-ui:field>
                    <x-ui:field-label>Nama Lengkap</x-ui:field-label>
                    <x-ui:input type="text" name="nama" value="{{ $anggota->user->nama }}" required class="w-full" />
                </x-ui:field>
                
                <x-ui:field>
                    <x-ui:field-label>NIM</x-ui:field-label>
                    <x-ui:input type="text" name="nim" value="{{ $anggota->user->nim }}" required class="w-full" />
                </x-ui:field>
                
                <div class="grid grid-cols-2 gap-4">
                    <x-ui:field>
                        <x-ui:field-label>Kelas</x-ui:field-label>
                        <x-ui:input type="text" name="kelas" value="{{ $anggota->user->kelas }}" required class="w-full" />
                    </x-ui:field>
                    <x-ui:field>
                        <x-ui:field-label>Prodi</x-ui:field-label>
                        <x-ui:input type="text" name="prodi" value="{{ $anggota->user->prodi }}" required class="w-full" />
                    </x-ui:field>
                </div>
                
                <x-ui:field>
                    <x-ui:field-label>Jurusan</x-ui:field-label>
                    <x-ui:input type="text" name="jurusan" value="{{ $anggota->user->jurusan }}" required class="w-full" />
                </x-ui:field>
                
                <x-ui:field>
                    <x-ui:field-label>UKM</x-ui:field-label>
                    <select name="ukm_id" required class="w-full p-2 border rounded">
                        @foreach($ukms as $ukm)
                        <option value="{{ $ukm->id }}" {{ $ukm->id == $anggota->ukm_id ? 'selected' : '' }}>{{ $ukm->nama }}</option>
                        @endforeach
                    </select>
                </x-ui:field>
                
                <div class="flex gap-4 pt-4">
                    <x-ui:button type="submit">Update</x-ui:button>
                    <x-ui:button href="{{ route('admin.anggota.index') }}" variant="outline">Batal</x-ui:button>
                </div>
            </form>
        </x-ui:card-content>
    </x-ui:card>
</div>
@endsection
