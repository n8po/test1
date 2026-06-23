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
                <x-ui::sidebar collapsible="icon" class="border-r">
                    <x-ui::sidebar-header>
                        <x-ui::sidebar-menu>
                            <x-ui::sidebar-menu-item>
                                <x-ui::sidebar-menu-button size="lg">
                                    <div class="bg-sidebar-primary text-sidebar-primary-foreground flex size-8 items-center justify-center rounded-lg">
                                        <x-lucide-building class="size-5" />
                                    </div>
                                    <div class="grid flex-1 text-left text-sm leading-tight">
                                        <span class="truncate font-semibold">UKM Poliban</span>
                                        <span class="truncate text-xs">{{ auth()->user()->isAdmin() ? 'Administrator' : 'Anggota' }}</span>
                                    </div>
                                </x-ui::sidebar-menu-button>
                            </x-ui::sidebar-menu-item>
                        </x-ui::sidebar-menu>
                    </x-ui::sidebar-header>

                    <x-ui::sidebar-content>
                        <x-ui::sidebar-group>
                            <x-ui::sidebar-group-label>Menu</x-ui::sidebar-group-label>
                            <x-ui::sidebar-menu>

                                {{-- Dashboard --}}
                                <x-ui::sidebar-menu-item>
                                    <x-ui::sidebar-menu-button as="a" href="{{ route('admin.dashboard') }}" class="{{ request()->is('dashboard*') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : '' }}">
                                        <x-lucide-layout-dashboard class="size-4" />
                                        <span>Dashboard</span>
                                    </x-ui::sidebar-menu-button>
                                </x-ui::sidebar-menu-item>

                                {{-- ADMIN ONLY: Mahasiswa CRUD --}}
                                @if(auth()->user()->isAdmin())
                                <x-ui::sidebar-menu-item>
                                    <x-ui::sidebar-menu-button as="a" href="{{ route('mahasiswa.index') }}" class="{{ request()->is('mahasiswa*') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : '' }}">
                                        <x-lucide-users class="size-4" />
                                        <span>Mahasiswa</span>
                                    </x-ui::sidebar-menu-button>
                                </x-ui::sidebar-menu-item>

                                <x-ui::sidebar-menu-item>
                                    <x-ui::sidebar-menu-button as="a" href="{{ route('ukm.index') }}" class="{{ request()->is('ukm*') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : '' }}">
                                        <x-lucide-building-2 class="size-4" />
                                        <span>Unit Kegiatan</span>
                                    </x-ui::sidebar-menu-button>
                                </x-ui::sidebar-menu-item>

                                <x-ui::sidebar-menu-item>
                                    <x-ui::sidebar-menu-button as="a" href="{{ route('pendaftaran.index') }}" class="{{ request()->is('pendaftaran*') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : '' }}">
                                        <x-lucide-file-text class="size-4" />
                                        <span>Pendaftaran</span>
                                    </x-ui::sidebar-menu-button>
                                </x-ui::sidebar-menu-item>

                                <x-ui::sidebar-menu-item>
                                    <x-ui::sidebar-menu-button as="a" href="{{ route('admin.anggota.index') }}" class="{{ request()->is('admin/anggota*') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : '' }}">
                                        <x-lucide-user-check class="size-4" />
                                        <span>Anggota UKM</span>
                                    </x-ui::sidebar-menu-button>
                                </x-ui::sidebar-menu-item>

                                {{-- ANGGOTA ONLY: Lihat anggota se-UKM --}}
                                @else
                                <x-ui::sidebar-menu-item>
                                    <x-ui::sidebar-menu-button as="a" href="{{ route('mahasiswa.index') }}" class="{{ request()->is('mahasiswa*') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : '' }}">
                                        <x-lucide-users class="size-4" />
                                        <span>Anggota UKM Saya</span>
                                    </x-ui::sidebar-menu-button>
                                </x-ui::sidebar-menu-item>
                                @endif
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
                                            <x-lucide-log-out class="size-4 mr-1" />
                                            Logout
                                        </x-ui::button>
                                    </form>
                                </div>
                            </x-ui::sidebar-menu-item>
                        </x-ui::sidebar-menu>
                    </x-ui::sidebar-footer>
                </x-ui::sidebar>

                {{-- Main --}}
                <main class="flex-1 p-6 lg:p-8">
                    <div class="mx-auto max-w-7xl space-y-6">
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
