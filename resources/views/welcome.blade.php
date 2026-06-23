@extends('layouts.app')

@section('content')
<div class="text-center py-12">
    <h2 class="text-4xl font-bold text-gray-900 mb-4">Sistem Manajemen UKM Poliban</h2>
    <p class="text-xl text-gray-600 mb-8">Selamat datang di sistem pendaftaran dan manajemen UKM Politeknik Negeri Banjarmasin</p>
    
    @guest
        <div class="flex justify-center gap-4 mt-8">
            <x-ui::button href="{{ route('login') }}" size="lg">Login</x-ui::button>
            <x-ui::button href="{{ route('register') }}" variant="outline" size="lg">Register</x-ui::button>
        </div>
    @endguest
    
    @auth
        <div class="max-w-md mx-auto mt-8">
            <x-ui::card>
                <x-ui::card-header>
                    <x-ui::card-title>Informasi Akun</x-ui::card-title>
                </x-ui::card-header>
                <x-ui::card-content class="space-y-2">
                    <p><strong>Nama:</strong> {{ auth()->user()->nama }}</p>
                    <p><strong>NIM:</strong> {{ auth()->user()->nim }}</p>
                    <p><strong>Role:</strong> <x-ui::badge variant="{{ auth()->user()->Role === 'administrator' ? 'success' : 'info' }}">{{ auth()->user()->Role }}</x-ui::badge></p>
                </x-ui::card-content>
            </x-ui::card>
        </div>
    @endauth
</div>
@endsection
