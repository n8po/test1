@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <x-ui:card>
        <x-ui:card-header>
            <x-ui:card-title>Edit Kegiatan</x-ui:card-title>
        </x-ui:card-header>
        <x-ui:card-content>
            <form method="POST" action="{{ route('kegiatan.update', $kegiatan->id) }}" class="space-y-4">
                @csrf @method('PUT')
                <x-ui:field>
                    <x-ui:field-label>Nama Kegiatan</x-ui:field-label>
                    <x-ui:input type="text" name="nama_kegiatan" value="{{ $kegiatan->nama_kegiatan }}" required class="w-full" />
                </x-ui:field>
                
                <x-ui:field>
                    <x-ui:field-label>UKM</x-ui:field-label>
                    <x-ui:select name="UKM" native required>
                        @foreach($ukms as $ukm)
                        <option value="{{ $ukm->nama }}" {{ $ukm->nama == $kegiatan->UKM ? 'selected' : '' }}>{{ $ukm->nama }}</option>
                        @endforeach
                    </x-ui:select>
                </x-ui:field>
                
                <x-ui:field>
                    <x-ui:field-label>Tanggal</x-ui:field-label>
                    <x-ui:input type="date" name="tanggal" value="{{ $kegiatan->tanggal->format('Y-m-d') }}" required class="w-full" />
                </x-ui:field>
                
                <x-ui:field>
                    <x-ui:field-label>Deskripsi</x-ui:field-label>
                    <x-ui:textarea name="deskripsi" class="w-full" rows="4">{{ $kegiatan->deskripsi }}</x-ui:textarea>
                </x-ui:field>
                
                <div class="flex gap-4 pt-4">
                    <x-ui:button type="submit">Update</x-ui:button>
                    <x-ui:button href="{{ route('kegiatan.index') }}" variant="outline">Batal</x-ui:button>
                </div>
            </form>
        </x-ui:card-content>
    </x-ui:card>
</div>
@endsection
