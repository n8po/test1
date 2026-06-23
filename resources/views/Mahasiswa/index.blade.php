@extends('layouts.app')
@section('title', 'Data Mahasiswa')
@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-2xl font-bold tracking-tight">Data Mahasiswa</h2>
        <div class="flex flex-wrap gap-2">
            <x-ui::dialog-trigger for="create-dialog">
                <x-ui::button>
                    <x-lucide-plus class="size-4" />
                    Tambah
                </x-ui::button>
            </x-ui::dialog-trigger>
            <x-ui::button href="{{ route('mahasiswa.export') }}" variant="secondary">
                <x-lucide-download class="size-4" />
                Export Excel
            </x-ui::button>
            <x-ui::button href="{{ route('mahasiswa.cetak') }}" variant="outline">
                <x-lucide-printer class="size-4" />
                Cetak
            </x-ui::button>
        </div>
    </div>

    <x-ui::card>
        <x-ui::card-content>
            <form method="POST" action="{{ route('mahasiswa.search') }}">
                @csrf
                <div class="flex gap-2">
                    <x-ui::input type="text" name="keyword" placeholder="Cari nama, NIM, atau kelas..." value="{{ request('keyword') }}" class="flex-1" />
                    <x-ui::button type="submit">Cari</x-ui::button>
                    <x-ui::button href="{{ route('mahasiswa.index') }}" variant="outline">Reset</x-ui::button>
                </div>
            </form>
        </x-ui::card-content>
    </x-ui::card>

    {{-- Table --}}
    <x-ui::card>
        <x-ui::card-content class="p-0">
            <x-ui::table>
                <x-ui::table-header>
                    <x-ui::table-row>
                        <x-ui::table-head>No</x-ui::table-head>
                        <x-ui::table-head>NIM</x-ui::table-head>
                        <x-ui::table-head>Nama</x-ui::table-head>
                        <x-ui::table-head>Kelas</x-ui::table-head>
                        <x-ui::table-head>Prodi</x-ui::table-head>
                        <x-ui::table-head>Status</x-ui::table-head>
                        <x-ui::table-head class="w-10"><span class="sr-only">Actions</span></x-ui::table-head>
                    </x-ui::table-row>
                </x-ui::table-header>
                <x-ui::table-body>
                    @forelse($mahasiswaList as $index => $m)
                    <x-ui::table-row>
                        <x-ui::table-cell>{{ $mahasiswaList->firstItem() + $index }}</x-ui::table-cell>
                        <x-ui::table-cell class="font-mono text-xs">{{ $m->nim }}</x-ui::table-cell>
                        <x-ui::table-cell class="font-medium">{{ $m->nama }}</x-ui::table-cell>
                        <x-ui::table-cell>{{ $m->kelas }}</x-ui::table-cell>
                        <x-ui::table-cell>{{ $m->prodi }}</x-ui::table-cell>
                        <x-ui::table-cell>
                            @if($m->status == 'pending')
                                <x-ui::badge variant="outline">Pending</x-ui::badge>
                            @elseif($m->status == 'approved')
                                <x-ui::badge variant="secondary">Disetujui</x-ui::badge>
                            @else
                                <x-ui::badge variant="destructive">Ditolak</x-ui::badge>
                            @endif
                        </x-ui::table-cell>
                        <x-ui::table-cell class="text-right">
                            <x-ui::dropdown-menu>
                                <x-ui::dropdown-menu-trigger>
                                    <x-ui::button variant="ghost" size="icon-sm" aria-label="Actions for {{ $m->nama }}">
                                        <x-lucide-more-horizontal aria-hidden="true" />
                                    </x-ui::button>
                                </x-ui::dropdown-menu-trigger>
                                <x-ui::dropdown-menu-content align="end">
                                    <x-ui::dropdown-menu-item @click="$dispatch('open-dialog-edit-dialog-{{ $m->id }}')">
                                        <x-lucide-pencil class="size-4" />
                                        Edit
                                    </x-ui::dropdown-menu-item>
                                    <x-ui::dropdown-menu-separator />
                                    <x-ui::dropdown-menu-item variant="destructive" @click="$dispatch('open-alert-dialog-delete-dialog-{{ $m->id }}')">
                                        <x-lucide-trash-2 class="size-4" />
                                        Hapus
                                    </x-ui::dropdown-menu-item>
                                </x-ui::dropdown-menu-content>
                            </x-ui::dropdown-menu>
                        </x-ui::table-cell>
                    </x-ui::table-row>
                    @empty
                    <x-ui::table-row>
                        <x-ui::table-cell colspan="7" class="text-center text-muted-foreground py-8">
                            Belum ada data mahasiswa
                        </x-ui::table-cell>
                    </x-ui::table-row>
                    @endforelse
                </x-ui::table-body>
            </x-ui::table>
        </x-ui::card-content>
    </x-ui::card>

    {{-- Pagination --}}
    @if ($mahasiswaList->hasPages())
        <x-ui::pagination class="mt-6">
            <x-ui::pagination-content>
                @if ($mahasiswaList->onFirstPage())
                    <x-ui::pagination-item class="opacity-50 pointer-events-none">
                        <x-ui::pagination-previous href="#" />
                    </x-ui::pagination-item>
                @else
                    <x-ui::pagination-item>
                        <x-ui::pagination-previous href="{{ $mahasiswaList->previousPageUrl() }}" />
                    </x-ui::pagination-item>
                @endif

                @foreach ($mahasiswaList->getUrlRange(1, $mahasiswaList->lastPage()) as $page => $url)
                    <x-ui::pagination-item>
                        <x-ui::pagination-link href="{{ $url }}" :isActive="$page == $mahasiswaList->currentPage()">
                            {{ $page }}
                        </x-ui::pagination-link>
                    </x-ui::pagination-item>
                @endforeach

                @if ($mahasiswaList->hasMorePages())
                    <x-ui::pagination-item>
                        <x-ui::pagination-next href="{{ $mahasiswaList->nextPageUrl() }}" />
                    </x-ui::pagination-item>
                @else
                    <x-ui::pagination-item class="opacity-50 pointer-events-none">
                        <x-ui::pagination-next href="#" />
                    </x-ui::pagination-item>
                @endif
            </x-ui::pagination-content>
        </x-ui::pagination>
    @endif
</div>

{{-- All Modals placed outside table to avoid layout issues --}}

{{-- Modal Tambah Mahasiswa --}}
<x-ui::dialog id="create-dialog" :open="$errors->any() && !old('edit_id')">
    <x-ui::dialog-content class="sm:max-w-md">
        <x-ui::dialog-header>
            <x-ui::dialog-title>Tambah Mahasiswa</x-ui::dialog-title>
            <x-ui::dialog-description>Isi data mahasiswa baru</x-ui::dialog-description>
        </x-ui::dialog-header>

        <form method="POST" action="{{ route('mahasiswa.store') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <x-ui::field>
                    <x-ui::field-label for="create-nim">NIM</x-ui::field-label>
                    <x-ui::input id="create-nim" type="text" name="nim" value="{{ old('nim') }}" placeholder="Masukkan NIM" required />
                    <x-ui::field-error :messages="$errors->get('nim')" />
                </x-ui::field>
                <x-ui::field>
                    <x-ui::field-label for="create-nama">Nama Lengkap</x-ui::field-label>
                    <x-ui::input id="create-nama" type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama" required />
                    <x-ui::field-error :messages="$errors->get('nama')" />
                </x-ui::field>
            </div>

            <x-ui::field>
                <x-ui::field-label for="create-kelas">Kelas</x-ui::field-label>
                <x-ui::input id="create-kelas" type="text" name="kelas" value="{{ old('kelas') }}" placeholder="Contoh: TI-1A" required />
                <x-ui::field-error :messages="$errors->get('kelas')" />
            </x-ui::field>

            <div class="grid grid-cols-2 gap-4">
                <x-ui::field>
                    <x-ui::field-label for="create-prodi">Prodi</x-ui::field-label>
                    <x-ui::input id="create-prodi" type="text" name="prodi" value="{{ old('prodi') }}" placeholder="Contoh: Teknik Informatika" required />
                    <x-ui::field-error :messages="$errors->get('prodi')" />
                </x-ui::field>
                <x-ui::field>
                    <x-ui::field-label for="create-jurusan">Jurusan</x-ui::field-label>
                    <x-ui::input id="create-jurusan" type="text" name="jurusan" value="{{ old('jurusan') }}" placeholder="Contoh: Teknologi Informasi" required />
                    <x-ui::field-error :messages="$errors->get('jurusan')" />
                </x-ui::field>
            </div>

            <x-ui::field orientation="horizontal" class="py-2">
                <x-ui::switch id="create-status" name="status" value="approved" :checked="old('status') === 'approved'" />
                <x-ui::field-label for="create-status">Disetujui</x-ui::field-label>
            </x-ui::field>

            <x-ui::dialog-footer class="mt-6 flex justify-end gap-2">
                <x-ui::dialog-close>
                    <x-ui::button type="button" variant="outline" size="sm">Batal</x-ui::button>
                </x-ui::dialog-close>
                <x-ui::button type="submit" size="sm">Simpan</x-ui::button>
            </x-ui::dialog-footer>
        </form>
    </x-ui::dialog-content>
</x-ui::dialog>

{{-- Edit & Delete modals per mahasiswa --}}
@foreach($mahasiswaList as $m)
    {{-- Modal Edit Mahasiswa --}}
    <x-ui::dialog id="edit-dialog-{{ $m->id }}" :open="$errors->any() && old('edit_id') == $m->id">
        <x-ui::dialog-content class="sm:max-w-md">
            <x-ui::dialog-header>
                <x-ui::dialog-title>Edit Mahasiswa</x-ui::dialog-title>
                <x-ui::dialog-description>Ubah data mahasiswa</x-ui::dialog-description>
            </x-ui::dialog-header>

            <form method="POST" action="{{ route('mahasiswa.update', $m->id) }}" class="space-y-4">
                @csrf @method('PUT')
                <input type="hidden" name="edit_id" value="{{ $m->id }}">
                
                <div class="grid grid-cols-2 gap-4">
                    <x-ui::field>
                        <x-ui::field-label for="edit-nim-{{ $m->id }}">NIM</x-ui::field-label>
                        <x-ui::input id="edit-nim-{{ $m->id }}" type="text" name="nim" value="{{ old('nim', $m->nim) }}" required />
                        <x-ui::field-error :messages="$errors->get('nim')" />
                    </x-ui::field>
                    <x-ui::field>
                        <x-ui::field-label for="edit-nama-{{ $m->id }}">Nama Lengkap</x-ui::field-label>
                        <x-ui::input id="edit-nama-{{ $m->id }}" type="text" name="nama" value="{{ old('nama', $m->nama) }}" required />
                        <x-ui::field-error :messages="$errors->get('nama')" />
                    </x-ui::field>
                </div>

                <x-ui::field>
                    <x-ui::field-label for="edit-kelas-{{ $m->id }}">Kelas</x-ui::field-label>
                    <x-ui::input id="edit-kelas-{{ $m->id }}" type="text" name="kelas" value="{{ old('kelas', $m->kelas) }}" required />
                    <x-ui::field-error :messages="$errors->get('kelas')" />
                </x-ui::field>

                <div class="grid grid-cols-2 gap-4">
                    <x-ui::field>
                        <x-ui::field-label for="edit-prodi-{{ $m->id }}">Prodi</x-ui::field-label>
                        <x-ui::input id="edit-prodi-{{ $m->id }}" type="text" name="prodi" value="{{ old('prodi', $m->prodi) }}" required />
                        <x-ui::field-error :messages="$errors->get('prodi')" />
                    </x-ui::field>
                    <x-ui::field>
                        <x-ui::field-label for="edit-jurusan-{{ $m->id }}">Jurusan</x-ui::field-label>
                        <x-ui::input id="edit-jurusan-{{ $m->id }}" type="text" name="jurusan" value="{{ old('jurusan', $m->jurusan) }}" required />
                        <x-ui::field-error :messages="$errors->get('jurusan')" />
                    </x-ui::field>
                </div>

                <x-ui::field orientation="horizontal" class="py-2">
                    <x-ui::switch id="edit-status-{{ $m->id }}" name="status" value="approved" :checked="old('edit_id') == $m->id ? old('status') === 'approved' : $m->status === 'approved'" />
                    <x-ui::field-label for="edit-status-{{ $m->id }}">Disetujui</x-ui::field-label>
                </x-ui::field>

                <x-ui::dialog-footer class="mt-6 flex justify-end gap-2">
                    <x-ui::dialog-close>
                        <x-ui::button type="button" variant="outline" size="sm">Batal</x-ui::button>
                    </x-ui::dialog-close>
                    <x-ui::button type="submit" size="sm">Update</x-ui::button>
                </x-ui::dialog-footer>
            </form>
        </x-ui::dialog-content>
    </x-ui::dialog>

    {{-- Modal Hapus Mahasiswa --}}
    <x-ui::alert-dialog id="delete-dialog-{{ $m->id }}">
        <x-ui::alert-dialog-content>
            <x-ui::alert-dialog-header>
                <x-ui::alert-dialog-title>Hapus Mahasiswa?</x-ui::alert-dialog-title>
                <x-ui::alert-dialog-description>
                    Apakah Anda yakin ingin menghapus data mahasiswa <strong>{{ $m->nama }}</strong>? Tindakan ini tidak dapat dibatalkan.
                </x-ui::alert-dialog-description>
            </x-ui::alert-dialog-header>
            <x-ui::alert-dialog-footer class="flex justify-end gap-2 mt-4">
                <x-ui::alert-dialog-cancel>Batal</x-ui::alert-dialog-cancel>
                <form method="POST" action="{{ route('mahasiswa.destroy', $m->id) }}" class="inline">
                    @csrf @method('DELETE')
                    <x-ui::button type="submit" variant="destructive" size="sm">Hapus</x-ui::button>
                </form>
            </x-ui::alert-dialog-footer>
        </x-ui::alert-dialog-content>
    </x-ui::alert-dialog>
@endforeach
@endsection
