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
            <div class="flex min-h-screen w-full">
                <x-ui::sidebar collapsible="icon" class="border-r">


                    <x-ui::sidebar-content>
                        <x-ui::sidebar-group>
                            <x-ui::sidebar-group-label>Menu</x-ui::sidebar-group-label>
                            <x-ui::sidebar-menu>

                                {{-- Dashboard (Admin & Pengurus Only) --}}
                                @if(auth()->user()->isAdmin() || auth()->user()->isPengurus())
                                <x-ui::sidebar-menu-item>
                                    <x-ui::sidebar-menu-button as="a" href="{{ route('admin.dashboard') }}" class="{{ request()->is('dashboard*') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : '' }}">
                                        <x-lucide-layout-dashboard class="size-4" />
                                        <span>Dashboard</span>
                                    </x-ui::sidebar-menu-button>
                                </x-ui::sidebar-menu-item>
                                @endif

                                {{-- Mahasiswa (Admin) or Anggota UKM Saya (Mahasiswa/Pengurus) --}}
                                @if(auth()->user()->isAdmin())
                                <x-ui::sidebar-menu-item>
                                    <x-ui::sidebar-menu-button as="a" href="{{ route('mahasiswa.index') }}" class="{{ request()->is('mahasiswa*') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : '' }}">
                                        <x-lucide-users class="size-4" />
                                        <span>Mahasiswa</span>
                                    </x-ui::sidebar-menu-button>
                                </x-ui::sidebar-menu-item>
                                @else
                                <x-ui::sidebar-menu-item>
                                    <x-ui::sidebar-menu-button as="a" href="{{ route('mahasiswa.index') }}" class="{{ request()->is('mahasiswa*') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : '' }}">
                                        <x-lucide-users class="size-4" />
                                        <span>Anggota UKM Saya</span>
                                    </x-ui::sidebar-menu-button>
                                </x-ui::sidebar-menu-item>
                                @endif

                                {{-- Unit Kegiatan (Admin & Pengurus Only) --}}
                                @if(auth()->user()->isAdmin() || auth()->user()->isPengurus())
                                <x-ui::sidebar-menu-item>
                                    <x-ui::sidebar-menu-button as="a" href="{{ route('ukm.index') }}" class="{{ request()->is('ukm*') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : '' }}">
                                        <x-lucide-building-2 class="size-4" />
                                        <span>Unit Kegiatan</span>
                                    </x-ui::sidebar-menu-button>
                                </x-ui::sidebar-menu-item>
                                @endif

                                {{-- Pendaftaran (Admin Only) --}}
                                @if(auth()->user()->isAdmin())
                                <x-ui::sidebar-menu-item>
                                    <x-ui::sidebar-menu-button as="a" href="{{ route('pendaftaran.index') }}" class="{{ request()->is('pendaftaran*') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : '' }}">
                                        <x-lucide-file-text class="size-4" />
                                        <span>Pendaftaran</span>
                                    </x-ui::sidebar-menu-button>
                                </x-ui::sidebar-menu-item>
                                @endif
                            </x-ui::sidebar-menu>
                        </x-ui::sidebar-group>
                    </x-ui::sidebar-content>

                    <x-ui::sidebar-footer>
                        <x-ui::sidebar-menu>
                            <x-ui::sidebar-menu-item class="flex items-center gap-2">
                                <x-ui::dialog-trigger for="profile-dialog" class="flex-1 min-w-0 cursor-pointer">
                                    <x-ui::sidebar-menu-button size="lg" class="w-full justify-start p-1.5">
                                        <x-ui::avatar class="size-8 ring-2 ring-primary/20 shrink-0">
                                            <x-ui::avatar-fallback class="bg-primary text-primary-foreground font-semibold">
                                                {{ strtoupper(substr(auth()->user()->nama, 0, 2)) }}
                                            </x-ui::avatar-fallback>
                                        </x-ui::avatar>
                                        <div class="grid flex-1 text-left text-sm leading-tight min-w-0" x-show="open">
                                            <span class="truncate font-semibold">{{ auth()->user()->nama }}</span>
                                            <span class="truncate text-xs text-muted-foreground">{{ auth()->user()->username }}</span>
                                        </div>
                                    </x-ui::sidebar-menu-button>
                                </x-ui::dialog-trigger>

                                <form method="POST" action="{{ route('logout') }}" class="shrink-0 flex items-center" x-show="open">
                                    @csrf
                                    <x-ui::button type="submit" variant="ghost" size="icon" class="size-8 text-muted-foreground hover:text-destructive hover:bg-destructive/10" title="Logout">
                                        <x-lucide-log-out class="size-4" />
                                    </x-ui::button>
                                </form>
                            </x-ui::sidebar-menu-item>
                        </x-ui::sidebar-menu>
                    </x-ui::sidebar-footer>
                </x-ui::sidebar>

                <main class="flex-1 p-4 md:p-6 lg:p-8">
                    <div class="w-full space-y-6">
                        <div class="flex items-center gap-2 border-b pb-4">
                            <x-ui::sidebar-trigger class="-ml-1" />
                            <x-ui::separator orientation="vertical" class="h-4" />
                            <span class="text-sm font-semibold text-muted-foreground">Sistem Informasi UKM Poliban</span>
                        </div>
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

        {{-- Profile dialog modal (decoupled from sidebar scroll and scope) --}}
        <x-ui::dialog id="profile-dialog">
            <x-ui::dialog-content class="sm:max-w-md">
                <div class="flex items-center gap-3 border-b pb-4">
                    <x-ui::avatar class="size-10 ring-2 ring-primary/20 shrink-0">
                        <x-ui::avatar-fallback class="bg-primary text-primary-foreground font-semibold text-base">
                            {{ strtoupper(substr(auth()->user()->nama, 0, 2)) }}
                        </x-ui::avatar-fallback>
                    </x-ui::avatar>
                    <div>
                        <h3 class="text-base font-semibold leading-none">{{ auth()->user()->nama }}</h3>
                        <p class="text-xs text-muted-foreground mt-1">{{ auth()->user()->username }}</p>
                    </div>
                </div>

                <x-ui::dialog-header class="mt-4">
                    <x-ui::dialog-title>Edit Profil</x-ui::dialog-title>
                    <x-ui::dialog-description>Perbarui informasi akun Anda di bawah ini.</x-ui::dialog-description>
                </x-ui::dialog-header>
                
                {{-- Update Profile Form --}}
                <form id="profile-form" action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <x-ui::field>
                        <x-ui::label for="profile-username">Username</x-ui::label>
                        <x-ui::input type="text" id="profile-username" name="username" value="{{ auth()->user()->username }}" required />
                    </x-ui::field>
                    <x-ui::field>
                        <x-ui::label for="profile-email">Email</x-ui::label>
                        <x-ui::input type="email" id="profile-email" name="email" value="{{ auth()->user()->email }}" placeholder="alamat@email.com" />
                    </x-ui::field>
                    <x-ui::field>
                        <x-ui::label for="profile-password">Password Baru</x-ui::label>
                        <x-ui::input type="password" id="profile-password" name="password" placeholder="Kosongkan jika tidak ingin mengubah" />
                    </x-ui::field>
                    <x-ui::field>
                        <x-ui::label for="profile-password-confirm">Konfirmasi Password Baru</x-ui::label>
                        <x-ui::input type="password" id="profile-password-confirm" name="password_confirmation" placeholder="Ulangi password baru" />
                    </x-ui::field>
                </form>

                <x-ui::dialog-footer class="mt-6 flex justify-end items-center w-full gap-2">
                    <x-ui::dialog-close>
                        <x-ui::button type="button" variant="outline" size="sm">Batal</x-ui::button>
                    </x-ui::dialog-close>
                    <x-ui::button type="submit" form="profile-form" size="sm">Simpan</x-ui::button>
                </x-ui::dialog-footer>
            </x-ui::dialog-content>
        </x-ui::dialog>
    @else
        @yield('content')
    @endauth
</body>
</html>
