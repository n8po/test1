@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <x-ui::card>
        <x-ui::card-header>
            <x-ui::card-title>Profil Saya</x-ui::card-title>
        </x-ui::card-header>
        <x-ui::card-content>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600">Nama</p>
                        <p class="font-medium">{{ auth()->user()->nama }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600">NIM</p>
                        <p class="font-medium">{{ auth()->user()->nim }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600">Kelas</p>
                        <p class="font-medium">{{ auth()->user()->kelas }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600">Prodi</p>
                        <p class="font-medium">{{ auth()->user()->prodi }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg col-span-2">
                        <p class="text-sm text-gray-600">Jurusan</p>
                        <p class="font-medium">{{ auth()->user()->jurusan }}</p>
                    </div>
                </div>
            </div>
        </x-ui::card-content>
    </x-ui::card>
</div>
@endsection
