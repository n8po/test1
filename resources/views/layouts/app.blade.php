<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UKM Poliban')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen bg-background">
    @auth
        <x-ui::sidebar-provider>
            <div class="flex min-h-screen">
                {{-- Sidebar --}}
                <x-ui::sidebar collapsible="icon" class="border-r">
                    <x-ui::sidebar-header>
                        <x-ui::sidebar-menu>
                            <x-ui::sidebar-menu-item>
                                <x-ui::sidebar-menu-button size="lg" class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground">
                                    <div class="bg-sidebar-primary text-sidebar-primary-foreground flex size-8 items-center justify-center rounded-lg">
                                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <div class="grid flex-1 text-left text-sm leading-tight">
                                        <span class="truncate font-semibold">UKM Poliban</span>
                                        <span class="truncate text-xs">Administrator</span>
                                    </div>
                                </x-ui::sidebar-menu-button>
                            </x-ui::sidebar-menu-item>
                        </x-ui::sidebar-menu>
                    </x-ui::sidebar-header>

                    <x-ui::sidebar-content>
                        <x-ui::sidebar-group>
                            <x-ui::sidebar-group-label>Menu</x-ui::sidebar-group-label>
                            <x-ui::sidebar-menu>
                                <x-ui::sidebar-menu-item>
                                    <x-ui::sidebar-menu-button as="a" href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : '' }}">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                        <span>Dashboard</span>
                                    </x-ui::sidebar-menu-button>
                                </x-ui::sidebar-menu-item>

                                <x-ui::sidebar-menu-item>
                                    <x-ui::sidebar-menu-button as="a" href="{{ route('mahasiswa.index') }}" class="{{ request()->is('mahasiswa*') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : '' }}">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                        </svg>
                                        <span>Mahasiswa</span>
                                    </x-ui::sidebar-menu-button>
                                </x-ui::sidebar-menu-item>

                                <x-ui::sidebar-menu-item>
                                    <x-ui::sidebar-menu-button as="a" href="{{ route('ukm.index') }}" class="{{ request()->is('ukm*') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : '' }}">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        <span>Unit Kegiatan</span>
                                    </x-ui::sidebar-menu-button>
                                </x-ui::sidebar-menu-item>

                                <x-ui::sidebar-menu-item>
                                    <x-ui::sidebar-menu-button as="a" href="{{ route('pendaftaran.index') }}" class="{{ request()->is('pendaftaran*') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : '' }}">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span>Pendaftaran</span>
                                    </x-ui::sidebar-menu-button>
                                </x-ui::sidebar-menu-item>

                                <x-ui::sidebar-menu-item>
                                    <x-ui::sidebar-menu-button as="a" href="{{ route('admin.anggota.index') }}" class="{{ request()->is('admin/anggota*') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : '' }}">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span>Anggota UKM</span>
                                    </x-ui::sidebar-menu-button>
                                </x-ui::sidebar-menu-item>
                            </x-ui::sidebar-menu>
                        </x-ui::sidebar-group>
                    </x-ui::sidebar-content>

                    <x-ui::sidebar-footer>
                        <x-ui::sidebar-menu>
                            <x-ui::sidebar-menu-item>
                                <div class="flex items-center gap-3 px-4 py-2">
                                    <x-ui::badge variant="outline">{{ auth()->user()->Role }}</x-ui::badge>
                                    <form method="POST" action="{{ route('logout') }}" class="ml-auto">
                                        @csrf
                                        <x-ui::button type="submit" variant="destructive" size="sm">
                                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            Logout
                                        </x-ui::button>
                                    </form>
                                </div>
                            </x-ui::sidebar-menu-item>
                        </x-ui::sidebar-menu>
                    </x-ui::sidebar-footer>
                </x-ui::sidebar>

                {{-- Main Content --}}
                <main class="flex-1 p-6 lg:p-8">
                    <div class="mx-auto max-w-7xl space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold tracking-tight">@yield('title', 'Dashboard')</h1>
                                <p class="text-muted-foreground mt-1 text-sm">Sistem Manajemen UKM Politeknik Negeri Banjarmasin</p>
                            </div>
                        </div>

                        <x-ui::separator />

                        @if(session('success'))
                            <x-ui::alert variant="success">
                                <x-ui::alert-title>Berhasil</x-ui::alert-title>
                                <x-ui::alert-description>{{ session('success') }}</x-ui::alert-description>
                            </x-ui::alert>
                        @endif

                        @if(session('error'))
                            <x-ui::alert variant="destructive">
                                <x-ui::alert-title>Error</x-ui::alert-title>
                                <x-ui::alert-description>{{ session('error') }}</x-ui::alert-description>
                            </x-ui::alert>
                        @endif

                        @yield('content')
                    </div>
                </main>
            </div>
        </x-ui::sidebar-provider>
    @else
        @yield('content')
    @endauth
    @blatuiScripts
</body>
</html>
