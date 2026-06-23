@extends('layouts.app')

@section('content')
<div class="text-center py-12">
    <h2 class="text-4xl font-bold text-gray-900 mb-4">Sistem Manajemen UKM Poliban</h2>
    <p class="text-xl text-gray-600 mb-8">Selamat datang di sistem pendaftaran dan manajemen UKM Politeknik Negeri Banjarmasin</p>
    
    @guest
        <div class="flex justify-center gap-4 mt-8">
            <x-button href="{{ route('login') }}" size="lg">Login</x-button>
            <x-button href="{{ route('register') }}" variant="outline" size="lg">Register</x-button>
        </div>
    @endguest
    
    @auth
        <div class="max-w-md mx-auto mt-8">
            <x-card>
                <x-card-header>
                    <x-card-title>Informasi Akun</x-card-title>
                </x-card-header>
                <x-card-content class="space-y-2">
                    <p><strong>Nama:</strong> {{ auth()->user()->nama }}</p>
                    <p><strong>NIM:</strong> {{ auth()->user()->nim }}</p>
                    <p><strong>Role:</strong> <x-badge variant="{{ auth()->user()->Role === 'administrator' ? 'success' : 'info' }}">{{ auth()->user()->Role }}</x-badge></p>
                </x-card-content>
            </x-card>
        </div>
    @endauth
</div>
@endsection
