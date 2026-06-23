@extends('layouts.auth')

@section('content')
<div class="grid min-h-screen lg:grid-cols-2">
    {{-- Brand panel --}}
    <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white relative hidden flex-col justify-between overflow-hidden p-12 lg:flex">
        <div class="pointer-events-none absolute -right-20 -top-20 size-80 rounded-full bg-white/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -left-16 size-80 rounded-full bg-white/10 blur-3xl"></div>
        
        <a href="/" class="relative flex items-center gap-2 font-semibold">
            <span class="flex size-8 items-center justify-center rounded-lg bg-white/15">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </span> 
            UKM Poliban
        </a>
        
        <figure class="relative max-w-md">
            <svg class="mb-4 size-8 opacity-40" fill="currentColor" viewBox="0 0 24 24">
                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
            </svg>
            <blockquote class="text-2xl font-medium leading-snug text-balance">
                Sistem UKM Poliban membantu mahasiswa mengembangkan bakat dan minat melalui berbagai unit kegiatan.
            </blockquote>
            <figcaption class="mt-6 flex items-center gap-3">
                <div class="size-11 rounded-full bg-white/20 flex items-center justify-center ring-2 ring-white/20">
                    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="text-sm">
                    <div class="font-semibold">Politeknik Negeri Banjarmasin</div>
                    <div class="opacity-70">Kampus Inovatif dan Kompetitif</div>
                </div>
            </figcaption>
        </figure>
        
        <div class="relative flex gap-8 text-sm">
            <div><div class="text-2xl font-bold">8+</div><div class="opacity-70">UKM Aktif</div></div>
            <div><div class="text-2xl font-bold">500+</div><div class="opacity-70">Anggota</div></div>
            <div><div class="text-2xl font-bold">50+</div><div class="opacity-70">Kegiatan</div></div>
        </div>
    </div>

    {{-- Form --}}
    <div class="relative flex items-center justify-center p-6 sm:p-10">
        <div class="w-full max-w-sm">
            <a href="/" class="mb-8 flex items-center gap-2 font-semibold lg:hidden">
                <span class="bg-blue-600 text-white flex size-8 items-center justify-center rounded-lg">
                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </span> 
                UKM Poliban
            </a>

            <div class="mb-6">
                <h1 class="text-2xl font-bold tracking-tight">Selamat Datang</h1>
                <p class="text-gray-500 mt-1 text-sm">Login untuk mengakses sistem UKM Poliban.</p>
            </div>

            @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
                @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="grid gap-4">
                @csrf
                <div class="grid gap-2">
                    <label for="nim" class="text-sm font-medium">NIM</label>
                    <input 
                        id="nim" 
                        type="text" 
                        name="nim" 
                        placeholder="Masukkan NIM"
                        value="{{ old('nim') }}"
                        required 
                        class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                </div>
                <div class="grid gap-2">
                    <label for="password" class="text-sm font-medium">Password</label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        placeholder="Masukkan password"
                        required 
                        class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                </div>
                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium bg-blue-600 text-white hover:bg-blue-700 h-10 px-4 py-2">
                    Login
                </button>
            </form>

            <div class="my-6 flex items-center gap-3">
                <hr class="flex-1 border-gray-200">
                <span class="text-gray-500 text-xs uppercase">atau</span>
                <hr class="flex-1 border-gray-200">
            </div>

            <p class="text-center text-sm text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-medium">Daftar disini</a>
            </p>

            <p class="text-gray-400 mt-8 text-center text-xs">Sistem Manajemen UKM Poliban &copy; 2026</p>
        </div>
    </div>
</div>
@endsection
