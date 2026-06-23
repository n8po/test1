@extends('layouts.app')
@section('title', 'Pendaftaran')
@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-2xl font-bold tracking-tight">Data Pendaftaran</h2>
        <div class="flex flex-wrap gap-2">
            <x-ui::button href="{{ route('pendaftaran.export') }}" variant="secondary">Export CSV</x-ui::button>
            <x-ui::button href="{{ route('pendaftaran.cetak') }}" variant="outline">Cetak</x-ui::button>
        </div>
    </div>

    {{-- Search --}}
    <x-ui::card>
        <x-ui::card-content>
            <form method="POST" action="{{ route('pendaftaran.search') }}">
                @csrf
                <div class="flex gap-2">
                    <x-ui::input type="text" name="keyword" placeholder="Cari nama, NIM, atau UKM..." value="{{ request('keyword') }}" class="flex-1" />
                    <x-ui::button type="submit">Cari</x-ui::button>
                    <x-ui::button href="{{ route('pendaftaran.index') }}" variant="outline">Reset</x-ui::button>
                </div>
            </form>
        </x-ui::card-content>
    </x-ui::card>

    <x-ui::card>
        <x-ui::card-header>
            <x-ui::card-title>Daftar Pendaftaran</x-ui::card-title>
            <x-ui::card-description>Kelola pendaftaran anggota UKM</x-ui::card-description>
        </x-ui::card-header>
        <x-ui::card-content class="p-0">
            <x-ui::table>
                <x-ui::table-header>
                    <x-ui::table-row>
                        <x-ui::table-head class="w-12">No</x-ui::table-head>
                        <x-ui::table-head>Nama</x-ui::table-head>
                        <x-ui::table-head>NIM</x-ui::table-head>
                        <x-ui::table-head>UKM</x-ui::table-head>
                        <x-ui::table-head>Status</x-ui::table-head>
                        <x-ui::table-head class="w-10"><span class="sr-only">Actions</span></x-ui::table-head>
                    </x-ui::table-row>
                </x-ui::table-header>
                <x-ui::table-body>
                    @forelse($pendaftaranList as $i => $p)
                    <x-ui::table-row>
                        <x-ui::table-cell>{{ $i + 1 }}</x-ui::table-cell>
                        <x-ui::table-cell class="font-medium">{{ $p->user->nama ?? '-' }}</x-ui::table-cell>
                        <x-ui::table-cell class="font-mono text-xs">{{ $p->user->nim ?? '-' }}</x-ui::table-cell>
                        <x-ui::table-cell>{{ $p->ukm->nama ?? '-' }}</x-ui::table-cell>
                        <x-ui::table-cell>
                            <x-ui::badge variant="{{ $p->status == 'pending' ? 'outline' : ($p->status == 'diterima' ? 'secondary' : 'destructive') }}">
                                {{ ucfirst($p->status) }}
                            </x-ui::badge>
                        </x-ui::table-cell>
                        <x-ui::table-cell class="text-right">
                            @if($p->status == 'pending')
                            <x-ui::dropdown-menu>
                                <x-ui::dropdown-menu-trigger>
                                    <x-ui::button variant="ghost" size="icon-sm" aria-label="Actions for {{ $p->user->nama ?? '-' }}">
                                        <x-lucide-more-horizontal aria-hidden="true" />
                                    </x-ui::button>
                                </x-ui::dropdown-menu-trigger>
                                <x-ui::dropdown-menu-content align="end">
                                    <form method="POST" action="{{ route('pendaftaran.setujui', $p->id) }}">
                                        @csrf
                                        <x-ui::dropdown-menu-item type="submit">
                                            <x-lucide-check class="size-4" />
                                            Setujui
                                        </x-ui::dropdown-menu-item>
                                    </form>
                                    <x-ui::dropdown-menu-separator />
                                    <form method="POST" action="{{ route('pendaftaran.tolak', $p->id) }}">
                                        @csrf
                                        <x-ui::dropdown-menu-item type="submit" variant="destructive">
                                            <x-lucide-x class="size-4 text-destructive" />
                                            Tolak
                                        </x-ui::dropdown-menu-item>
                                    </form>
                                </x-ui::dropdown-menu-content>
                            </x-ui::dropdown-menu>
                            @else
                            <span class="text-xs text-muted-foreground">Selesai</span>
                            @endif
                        </x-ui::table-cell>
                    </x-ui::table-row>
                    @empty
                    <x-ui::table-row>
                        <x-ui::table-cell colspan="6" class="text-center text-muted-foreground py-8">
                            Belum ada data pendaftaran
                        </x-ui::table-cell>
                    </x-ui::table-row>
                    @endforelse
                </x-ui::table-body>
            </x-ui::table>
        </x-ui::card-content>
    </x-ui::card>
</div>
@endsection
