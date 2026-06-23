@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-bold">List UKM</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($ukms as $ukm)
        <x-ui::card>
            <x-ui::card-header>
                <x-ui::card-title>{{ $ukm->nama }}</x-ui::card-title>
            </x-ui::card-header>
            <x-ui::card-content>
                <p class="text-gray-600 mb-4">{{ Str::limit($ukm->deskripsi, 100) }}</p>
                <form method="POST" action="{{ route('anggota.ukm.daftar') }}">
                    @csrf
                    <input type="hidden" name="ukm_id" value="{{ $ukm->id }}">
                    <x-ui::button type="submit">Daftar UKM Ini</x-ui::button>
                </form>
            </x-ui::card-content>
        </x-ui::card>
        @endforeach
    </div>
</div>
@endsection
