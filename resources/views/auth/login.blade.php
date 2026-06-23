@extends('layouts.auth')

@section('content')
<div class="grid min-h-screen lg:grid-cols-2">
    {{-- Brand panel --}}
    <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white relative hidden flex-col justify-between overflow-hidden p-12 lg:flex">
        <div class="pointer-events-none absolute -right-20 -top-20 size-80 rounded-full bg-white/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -left-16 size-80 rounded-full bg-white/10 blur-3xl"></div>
        
        <a href="/" class="relative flex items-center gap-2 font-semibold">
            <span class="flex size-8 items-center justify-center rounded-lg bg-white/15">
                <x-lucide-building class="size-5" />
            </span> 
            UKM Poliban
        </a>
        
        <figure class="relative max-w-md">
            <x-lucide-building class="size-5" />
                </span> 
                UKM Poliban
            </a>

            <x-ui::card class="mb-6">
                <x-ui::card-header>
                    <x-ui::card-title>Selamat Datang</x-ui::card-title>
                    <x-ui::card-description>Login untuk mengakses sistem UKM Poliban.</x-ui::card-description>
                </x-ui::card-header>
                <x-ui::card-content>
                    @if(session('success'))
                        <x-ui::alert variant="success" class="mb-4">
                            <x-ui::alert-description>{{ session('success') }}</x-ui::alert-description>
                        </x-ui::alert>
                    @endif

                    @if($errors->any())
                        <x-ui::alert variant="destructive" class="mb-4">
                            <x-ui::alert-description>
                                @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                                @endforeach
                            </x-ui::alert-description>
                        </x-ui::alert>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="grid gap-4">
                        @csrf
                        <x-ui::field>
                            <x-ui::field-label for="username">Username</x-ui::field-label>
                            <x-ui::input id="username" type="text" name="username" placeholder="Masukkan username" value="{{ old('username') }}" required />
                        </x-ui::field>

                        <x-ui::field>
                            <x-ui::field-label for="password">Password</x-ui::field-label>
                            <x-ui::input id="password" type="password" name="password" placeholder="Masukkan password" required />
                        </x-ui::field>

                        <x-ui::button type="submit" class="w-full">Login</x-ui::button>
                    </form>
                </x-ui::card-content>
            </x-ui::card>

            <p class="text-muted-foreground mt-8 text-center text-xs">Sistem Manajemen UKM Poliban &copy; {{ date('Y') }}</p>
        </div>
    </div>
</div>
@endsection
