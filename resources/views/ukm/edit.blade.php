@extends('layouts.app')

@section('title', 'Edit UKM')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center gap-2">
        <a href="{{ route('ukm.index') }}" class="text-muted-foreground hover:text-foreground">
            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h1 class="text-2xl font-bold tracking-tight">Edit UKM</h1>
    </div>

    <x-ui:card>
        <x-ui:card-header>
            <x-ui:card-title>Form Edit UKM</x-ui:card-title>
            <x-ui:card-description>Edit data unit kegiatan mahasiswa</x-ui:card-description>
        </x-ui:card-header>
        <x-ui:card-content>
            <form method="POST" action="{{ route('ukm.update', $ukm->id) }}" class="space-y-4">
                @csrf @method('PUT')
                <x-ui:field>
                    <x-ui:field-label for="nama">Nama UKM</x-ui:field-label>
                    <x-ui:input id="nama" type="text" name="nama" value="{{ old('nama', $ukm->nama) }}" required />
                </x-ui:field>

                <x-ui:field>
                    <x-ui:field-label for="deskripsi">Deskripsi</x-ui:field-label>
                    <x-ui:textarea id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $ukm->deskripsi) }}</x-ui:textarea>
                </x-ui:field>

                <x-ui:separator />

                <div class="flex gap-2">
                    <x-ui:button type="submit">Update</x-ui:button>
                    <x-ui:button href="{{ route('ukm.index') }}" variant="outline">Batal</x-ui:button>
                </div>
            </form>
        </x-ui:card-content>
    </x-ui:card>
</div>
@endsection
