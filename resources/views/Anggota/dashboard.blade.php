@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <x-ui:card>
        <x-ui:card-header>
            <x-ui:card-title>Profil Saya</x-ui:card-title>
        </x-ui:card-header>
        <x-ui:card-content>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div><strong>Nama:</strong> {{ auth()->user()->nama }}</div>
                <div><strong>NIM:</strong> {{ auth()->user()->nim }}</div>
                <div><strong>Kelas:</strong> {{ auth()->user()->kelas }}</div>
                <div><strong>Prodi:</strong> {{ auth()->user()->prodi }}</div>
                <div><strong>Jurusan:</strong> {{ auth()->user()->jurusan }}</div>
            </div>
        </x-ui:card-content>
    </x-ui:card>

    <x-ui:card>
        <x-ui:card-header>
            <x-ui:card-title>Pendaftaran Saya</x-ui:card-title>
        </x-ui:card-header>
        <x-ui:card-content>
            <x-ui:table>
                <x-ui:table-header>
                    <x-ui:table-row>
                        <x-ui:table-head>UKM</x-ui:table-head>
                        <x-ui:table-head>Status</x-ui:table-head>
                        <x-ui:table-head>Tanggal</x-ui:table-head>
                    </x-ui:table-row>
                </x-ui:table-header>
                <x-ui:table-body>
                    @foreach($pendaftaran as $p)
                    <x-ui:table-row>
                        <x-ui:table-cell>{{ $p->ukm->nama }}</x-ui:table-cell>
                        <x-ui:table-cell>
                            @if($p->status === 'pending')
                                <x-ui:badge variant="warning">Pending</x-ui:badge>
                            @elseif($p->status === 'diterima')
                                <x-ui:badge variant="success">Diterima</x-ui:badge>
                            @else
                                <x-ui:badge variant="danger">Ditolak</x-ui:badge>
                            @endif
                        </x-ui:table-cell>
                        <x-ui:table-cell>{{ $p->created_at->format('d-m-Y') }}</x-ui:table-cell>
                    </x-ui:table-row>
                    @endforeach
                </x-ui:table-body>
            </x-ui:table>
        </x-ui:card-content>
    </x-ui:card>

    <div class="flex gap-4">
        <x-ui:button href="{{ route('anggota.ukm.index') }}">Daftar UKM Baru</x-ui:button>
        <x-ui:button href="{{ route('anggota.profil') }}" variant="outline">Lihat Profil</x-ui:button>
    </div>
</div>
@endsection
