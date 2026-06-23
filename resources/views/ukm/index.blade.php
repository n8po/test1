@extends('layouts.app')
@section('title', 'Data Unit Kegiatan Mahasiswa')
@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-2xl font-bold tracking-tight">Data Unit Kegiatan Mahasiswa (UKM)</h2>
        <div class="flex flex-wrap gap-2">
            @if(auth()->user()->isAdmin())
            <x-ui::dialog-trigger for="create-ukm-dialog">
                <x-ui::button>
                    <x-lucide-plus class="size-4" />
                    Tambah UKM
                </x-ui::button>
            </x-ui::dialog-trigger>
            @endif
            <x-ui::button href="{{ route('ukm.export') }}" variant="secondary">
                <x-lucide-download class="size-4" />
                Export Excel
            </x-ui::button>
            <x-ui::button href="{{ route('ukm.cetak') }}" variant="outline">
                <x-lucide-printer class="size-4" />
                Cetak
            </x-ui::button>
        </div>
    </div>

    {{-- Search --}}
    <x-ui::card>
        <x-ui::card-content>
            <form method="POST" action="{{ route('ukm.search') }}">
                @csrf
                <div class="flex gap-2">
                    <x-ui::input type="text" name="keyword" placeholder="Cari nama UKM..." class="flex-1" />
                    <x-ui::button type="submit">
                        <x-lucide-search class="size-4" />
                        Cari
                    </x-ui::button>
                    <x-ui::button href="{{ route('ukm.index') }}" variant="outline">Reset</x-ui::button>
                </div>
            </form>
        </x-ui::card-content>
    </x-ui::card>

    {{-- UKM Display View --}}
    @if(auth()->user()->isAdmin())
    {{-- UKM Flip-Card Grid (Administrator Only) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($ukmList as $ukm)
        @php
            $canManage = auth()->user()->isAdmin() || (!auth()->user()->isAdmin() && auth()->user()->getUkmId() == $ukm->id);
        @endphp
        
        <x-ui::flip-card trigger="hover" height="14rem">
            <x-slot:front class="flex flex-col justify-center h-full bg-card rounded-xl border p-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-primary/10 p-2.5 text-primary shrink-0">
                        <x-lucide-building-2 class="size-6" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-base font-bold truncate text-foreground">{{ $ukm->nama }}</h3>
                        <span class="inline-flex items-center gap-1.5 text-xs text-muted-foreground mt-1.5 font-medium">
                            <x-lucide-users class="size-3.5 text-primary" />
                            {{ $ukm->anggota_count ?? 0 }} Anggota
                        </span>
                    </div>
                </div>
            </x-slot:front>
            
            <x-slot:back class="flex flex-col justify-between h-full bg-card rounded-xl border p-6 shadow-sm">
                <div class="flex-1 overflow-y-auto pr-1 text-sm text-muted-foreground leading-relaxed">
                    <p>{{ $ukm->deskripsi ?: 'Tidak ada deskripsi.' }}</p>
                </div>
                <x-ui::separator class="my-3 shrink-0" />
                <div class="flex justify-end gap-1.5 shrink-0">
                    <x-ui::dialog-trigger for="overview-dialog-{{ $ukm->id }}">
                        <x-ui::button size="sm" variant="outline">
                            <x-lucide-eye class="size-3.5 mr-1" />
                            Overview
                        </x-ui::button>
                    </x-ui::dialog-trigger>

                    @if($canManage)
                    <x-ui::dialog-trigger for="edit-ukm-dialog-{{ $ukm->id }}">
                        <x-ui::button size="sm" variant="outline" title="Edit UKM">
                            <x-lucide-pencil class="size-3.5" />
                        </x-ui::button>
                    </x-ui::dialog-trigger>
                    @endif

                    @if(auth()->user()->isAdmin())
                    <x-ui::alert-dialog-trigger for="delete-ukm-dialog-{{ $ukm->id }}">
                        <x-ui::button size="sm" variant="destructive" title="Hapus UKM">
                            <x-lucide-trash-2 class="size-3.5" />
                        </x-ui::button>
                    </x-ui::alert-dialog-trigger>
                    @endif
                </div>
            </x-slot:back>
        </x-ui::flip-card>

        @empty
        <div class="col-span-full">
            <x-ui::card>
                <x-ui::card-content class="text-center py-12">
                    <x-lucide-building-2 class="size-12 mx-auto text-muted-foreground mb-4" />
                    <p class="text-muted-foreground">Belum ada data UKM</p>
                    @if(auth()->user()->isAdmin())
                    <x-ui::dialog-trigger for="create-ukm-dialog">
                        <x-ui::button class="mt-4">Tambah UKM Baru</x-ui::button>
                    </x-ui::dialog-trigger>
                    @endif
                </x-ui::card-content>
            </x-ui::card>
        </div>
        @endforelse
    </div>
    @else
    {{-- UKM Table View (Ketua & Sekretaris Only) --}}
    <x-ui::alert>
        <x-lucide-info class="size-4" />
        <x-ui::alert-description>
            Anggota baru yang ditambahkan akan masuk sebagai <strong>Pendaftaran (Pending)</strong> dan perlu disetujui oleh admin.
        </x-ui::alert-description>
    </x-ui::alert>

    <x-ui::card class="mt-4">
        <x-ui::card-content class="p-0">
            <x-ui::table>
                <x-ui::table-header>
                    <x-ui::table-row>
                        <x-ui::table-head class="w-12">No</x-ui::table-head>
                        <x-ui::table-head>Nama UKM</x-ui::table-head>
                        <x-ui::table-head>Jumlah Anggota</x-ui::table-head>
                        <x-ui::table-head>Deskripsi</x-ui::table-head>
                        <x-ui::table-head class="w-24 text-right">Aksi</x-ui::table-head>
                    </x-ui::table-row>
                </x-ui::table-header>
                <x-ui::table-body>
                    @forelse($ukmList as $i => $ukm)
                    @php
                        $canManage = auth()->user()->isAdmin() || (!auth()->user()->isAdmin() && auth()->user()->getUkmId() == $ukm->id);
                    @endphp
                    <x-ui::table-row>
                        <x-ui::table-cell>{{ $ukmList->firstItem() + $i }}</x-ui::table-cell>
                        <x-ui::table-cell class="font-medium">{{ $ukm->nama }}</x-ui::table-cell>
                        <x-ui::table-cell>
                            <span class="inline-flex items-center gap-1.5 text-sm font-medium">
                                <x-lucide-users class="size-4 text-primary" />
                                {{ $ukm->anggota_count ?? 0 }} Anggota
                            </span>
                        </x-ui::table-cell>
                        <x-ui::table-cell class="max-w-xs truncate" title="{{ $ukm->deskripsi }}">
                            {{ $ukm->deskripsi ?: '-' }}
                        </x-ui::table-cell>
                        <x-ui::table-cell class="text-right">
                            <div class="flex justify-end gap-1.5">
                                <x-ui::dialog-trigger for="overview-dialog-{{ $ukm->id }}">
                                    <x-ui::button size="sm" variant="outline">
                                        <x-lucide-eye class="size-3.5 mr-1" />
                                        Overview
                                    </x-ui::button>
                                </x-ui::dialog-trigger>

                                @if($canManage)
                                <x-ui::dialog-trigger for="edit-ukm-dialog-{{ $ukm->id }}">
                                    <x-ui::button size="sm" variant="outline" title="Edit UKM">
                                        <x-lucide-pencil class="size-3.5" />
                                    </x-ui::button>
                                </x-ui::dialog-trigger>
                                @endif
                            </div>
                        </x-ui::table-cell>
                    </x-ui::table-row>
                    @empty
                    <x-ui::table-row>
                        <x-ui::table-cell colspan="5" class="text-center text-muted-foreground py-8">
                            Belum ada data UKM
                        </x-ui::table-cell>
                    </x-ui::table-row>
                    @endforelse
                </x-ui::table-body>
            </x-ui::table>
        </x-ui::card-content>
    </x-ui::card>
    @endif

    {{-- Pagination --}}
    @if ($ukmList->hasPages())
        <x-ui::pagination class="mt-6">
            <x-ui::pagination-content>
                @if ($ukmList->onFirstPage())
                    <x-ui::pagination-item class="opacity-50 pointer-events-none">
                        <x-ui::pagination-previous href="#" />
                    </x-ui::pagination-item>
                @else
                    <x-ui::pagination-item>
                        <x-ui::pagination-previous href="{{ $ukmList->previousPageUrl() }}" />
                    </x-ui::pagination-item>
                @endif

                @foreach ($ukmList->getUrlRange(1, $ukmList->lastPage()) as $page => $url)
                    <x-ui::pagination-item>
                        <x-ui::pagination-link href="{{ $url }}" :isActive="$page == $ukmList->currentPage()">
                            {{ $page }}
                        </x-ui::pagination-link>
                    </x-ui::pagination-item>
                @endforeach

                @if ($ukmList->hasMorePages())
                    <x-ui::pagination-item>
                        <x-ui::pagination-next href="{{ $ukmList->nextPageUrl() }}" />
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

{{-- Place ALL Modals/Dialogs outside the grid at the bottom to prevent layout bugs --}}
@foreach($ukmList as $ukm)
@php
    $canManage = auth()->user()->isAdmin() || (!auth()->user()->isAdmin() && auth()->user()->getUkmId() == $ukm->id);
@endphp

    {{-- Modal Overview UKM --}}
    <x-ui::dialog id="overview-dialog-{{ $ukm->id }}">
        <x-ui::dialog-content class="sm:max-w-2xl">
            <div x-data="{ showAddForm: false }">
                {{-- Default view: List of members --}}
                <div x-show="!showAddForm">
                    <x-ui::dialog-header>
                        <x-ui::dialog-title>Overview: {{ $ukm->nama }}</x-ui::dialog-title>
                        <x-ui::dialog-description>
                            Daftar anggota aktif dan manajemen keanggotaan
                        </x-ui::dialog-description>
                    </x-ui::dialog-header>

                    <div class="mt-6 flex justify-between items-center gap-2">
                        <h3 class="text-sm font-semibold">Anggota Aktif ({{ $ukm->anggota->count() }})</h3>
                        @if($canManage)
                        <x-ui::button type="button" size="sm" @click="showAddForm = true">
                            <x-lucide-plus class="size-4 mr-1" /> Tambah Anggota
                        </x-ui::button>
                        @endif
                    </div>

                    <div class="mt-3 border rounded-lg overflow-hidden max-h-60 overflow-y-auto">
                        <x-ui::table>
                            <x-ui::table-header>
                                <x-ui::table-row>
                                    <x-ui::table-head class="py-2">No</x-ui::table-head>
                                    <x-ui::table-head class="py-2">Nama</x-ui::table-head>
                                    <x-ui::table-head class="py-2">NIM</x-ui::table-head>
                                    <x-ui::table-head class="py-2">Kelas</x-ui::table-head>
                                    <x-ui::table-head class="py-2">Jabatan</x-ui::table-head>
                                    @if($canManage)
                                    <x-ui::table-head class="py-2 text-right">Aksi</x-ui::table-head>
                                    @endif
                                </x-ui::table-row>
                            </x-ui::table-header>
                            <x-ui::table-body>
                                @forelse($ukm->anggota as $idx => $a)
                                <x-ui::table-row>
                                    <x-ui::table-cell class="py-2">{{ $idx + 1 }}</x-ui::table-cell>
                                    <x-ui::table-cell class="py-2 font-medium">{{ $a->user->nama }}</x-ui::table-cell>
                                    <x-ui::table-cell class="py-2 font-mono text-xs">{{ $a->user->nim }}</x-ui::table-cell>
                                    <x-ui::table-cell class="py-2">{{ $a->user->kelas }}</x-ui::table-cell>
                                    <x-ui::table-cell class="py-2">
                                        @if($canManage)
                                        <form method="POST" action="{{ route('admin.anggota.updateJabatan', $a->id) }}"
                                            x-data="{ lastVal: @js($a->jabatan) }"
                                            x-init="
                                                const input = $el.querySelector('input[name=jabatan]');
                                                if (input) {
                                                    setInterval(() => {
                                                        if (input.value !== '' && input.value !== lastVal) {
                                                            lastVal = input.value;
                                                            $el.submit();
                                                        }
                                                    }, 300);
                                                }
                                            "
                                        >
                                            @csrf @method('PUT')
                                            <x-ui::combobox
                                                name="jabatan"
                                                width="w-[140px]"
                                                placeholder="Pilih..."
                                                :searchable="false"
                                                :value="$a->jabatan"
                                                :options="[
                                                    ['value' => 'ketua', 'label' => 'Ketua'],
                                                    ['value' => 'sekretaris', 'label' => 'Sekretaris'],
                                                    ['value' => 'anggota', 'label' => 'Anggota'],
                                                ]"
                                            />
                                        </form>
                                        @else
                                            @if($a->jabatan === 'ketua')
                                                <x-ui::badge variant="default" class="text-xs">Ketua</x-ui::badge>
                                            @elseif($a->jabatan === 'sekretaris')
                                                <x-ui::badge variant="secondary" class="text-xs">Sekretaris</x-ui::badge>
                                            @else
                                                <x-ui::badge variant="outline" class="text-xs">Anggota</x-ui::badge>
                                            @endif
                                        @endif
                                    </x-ui::table-cell>
                                    @if($canManage)
                                    <x-ui::table-cell class="py-2 text-right">
                                        <form method="POST" action="{{ route('admin.anggota.destroy', $a->id) }}" class="inline" onsubmit="return confirm('Keluarkan anggota ini dari UKM?')">
                                            @csrf @method('DELETE')
                                            <x-ui::button type="submit" size="xs" variant="destructive">
                                                Keluarkan
                                            </x-ui::button>
                                        </form>
                                    </x-ui::table-cell>
                                    @endif
                                </x-ui::table-row>
                                @empty
                                <x-ui::table-row>
                                    <x-ui::table-cell colspan="{{ $canManage ? 6 : 5 }}" class="text-center text-muted-foreground py-6 text-sm">
                                        Belum ada anggota terdaftar.
                                    </x-ui::table-cell>
                                </x-ui::table-row>
                                @endforelse
                            </x-ui::table-body>
                        </x-ui::table>
                    </div>

                    <x-ui::dialog-footer class="mt-6">
                        <x-ui::dialog-close>
                            <x-ui::button type="button" variant="outline" size="sm">Tutup</x-ui::button>
                        </x-ui::dialog-close>
                    </x-ui::dialog-footer>
                </div>

                {{-- Form View: Add Member --}}
                @if($canManage)
                <div x-show="showAddForm" x-cloak>
                    <x-ui::dialog-header>
                        <x-ui::dialog-title>Tambah Anggota ke {{ $ukm->nama }}</x-ui::dialog-title>
                        <x-ui::dialog-description>
                            Pilih mahasiswa untuk dimasukkan sebagai anggota baru.
                        </x-ui::dialog-description>
                    </x-ui::dialog-header>

                    <form method="POST" action="{{ route('admin.anggota.store') }}" class="space-y-4 mt-4">
                        @csrf
                        <input type="hidden" name="ukm_id" value="{{ $ukm->id }}">
                        
                        @php
                            $mahasiswaOptions = $mahasiswaList->map(fn($m) => [
                                'value' => (string) $m->id,
                                'label' => $m->nama . ' (' . $m->nim . ' - Kelas ' . $m->kelas . ')',
                            ])->values()->toArray();
                        @endphp

                        <x-ui::field>
                            <x-ui::field-label>Pilih Mahasiswa</x-ui::field-label>
                            <x-ui::combobox
                                name="user_id"
                                width="w-full"
                                placeholder="Pilih Mahasiswa..."
                                searchPlaceholder="Cari nama / NIM..."
                                empty="Mahasiswa tidak ditemukan."
                                :options="$mahasiswaOptions"
                                :teleport="false"
                            />
                        </x-ui::field>

                        @php
                            $hasKetua = $ukm->anggota->where('jabatan', 'ketua')->count() > 0;
                            $hasSekretaris = $ukm->anggota->where('jabatan', 'sekretaris')->count() > 0;
                            $jabatanOptions = [
                                ['value' => 'ketua', 'label' => 'Ketua' . ($hasKetua ? ' (Sudah terisi)' : '')],
                                ['value' => 'sekretaris', 'label' => 'Sekretaris' . ($hasSekretaris ? ' (Sudah terisi)' : '')],
                                ['value' => 'anggota', 'label' => 'Anggota'],
                            ];
                        @endphp

                        <x-ui::field>
                            <x-ui::field-label>Jabatan</x-ui::field-label>
                            <x-ui::combobox
                                name="jabatan"
                                width="w-full"
                                placeholder="Pilih Jabatan..."
                                searchPlaceholder="Cari jabatan..."
                                empty="Tidak ditemukan."
                                :options="$jabatanOptions"
                                :teleport="false"
                            />
                        </x-ui::field>

                        <x-ui::dialog-footer class="mt-6 flex justify-end gap-2">
                            <x-ui::button type="button" variant="outline" size="sm" @click="showAddForm = false">Kembali</x-ui::button>
                            <x-ui::button type="submit" size="sm">Tambah</x-ui::button>
                        </x-ui::dialog-footer>
                    </form>
                </div>
                @endif
            </div>
        </x-ui::dialog-content>
    </x-ui::dialog>

    {{-- Modal Edit UKM --}}
    @if($canManage)
    <x-ui::dialog id="edit-ukm-dialog-{{ $ukm->id }}" :open="$errors->any() && old('edit_id') == $ukm->id">
        <x-ui::dialog-content class="sm:max-w-md">
            <x-ui::dialog-header>
                <x-ui::dialog-title>Edit UKM</x-ui::dialog-title>
                <x-ui::dialog-description>Ubah data unit kegiatan mahasiswa</x-ui::dialog-description>
            </x-ui::dialog-header>

            <form method="POST" action="{{ route('ukm.update', $ukm->id) }}" class="space-y-4">
                @csrf @method('PUT')
                <input type="hidden" name="edit_id" value="{{ $ukm->id }}">
                
                <x-ui::field>
                    <x-ui::field-label for="edit-nama-{{ $ukm->id }}">Nama UKM</x-ui::field-label>
                    <x-ui::input id="edit-nama-{{ $ukm->id }}" type="text" name="nama" value="{{ old('nama', $ukm->nama) }}" required />
                    <x-ui::field-error :messages="$errors->get('nama')" />
                </x-ui::field>

                <x-ui::field>
                    <x-ui::field-label for="edit-deskripsi-{{ $ukm->id }}">Deskripsi</x-ui::field-label>
                    <x-ui::textarea id="edit-deskripsi-{{ $ukm->id }}" name="deskripsi" rows="4">{{ old('deskripsi', $ukm->deskripsi) }}</x-ui::textarea>
                    <x-ui::field-error :messages="$errors->get('deskripsi')" />
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
    @endif

    {{-- Modal Hapus UKM (Alert Dialog) --}}
    @if(auth()->user()->isAdmin())
    <x-ui::alert-dialog id="delete-ukm-dialog-{{ $ukm->id }}">
        <x-ui::alert-dialog-content>
            <x-ui::alert-dialog-header>
                <x-ui::alert-dialog-title>Hapus UKM?</x-ui::alert-dialog-title>
                <x-ui::alert-dialog-description>
                    Apakah Anda yakin ingin menghapus Unit Kegiatan Mahasiswa <strong>{{ $ukm->nama }}</strong>? Seluruh data anggota aktif dan pendaftaran dalam UKM ini juga akan ikut terhapus. Tindakan ini tidak dapat dibatalkan.
                </x-ui::alert-dialog-description>
            </x-ui::alert-dialog-header>
            <x-ui::alert-dialog-footer class="flex justify-end gap-2 mt-4">
                <x-ui::alert-dialog-cancel>Batal</x-ui::alert-dialog-cancel>
                <form method="POST" action="{{ route('ukm.destroy', $ukm->id) }}" class="inline">
                    @csrf @method('DELETE')
                    <x-ui::button type="submit" variant="destructive" size="sm">Hapus</x-ui::button>
                </form>
            </x-ui::alert-dialog-footer>
        </x-ui::alert-dialog-content>
    </x-ui::alert-dialog>
    @endif
@endforeach

{{-- Modal Tambah UKM --}}
@if(auth()->user()->isAdmin())
<x-ui::dialog id="create-ukm-dialog" :open="$errors->any() && !old('edit_id')">
    <x-ui::dialog-content class="sm:max-w-md">
        <x-ui::dialog-header>
            <x-ui::dialog-title>Tambah UKM</x-ui::dialog-title>
            <x-ui::dialog-description>Tambah unit kegiatan mahasiswa baru</x-ui::dialog-description>
        </x-ui::dialog-header>

        <form method="POST" action="{{ route('ukm.store') }}" class="space-y-4">
            @csrf
            <x-ui::field>
                <x-ui::field-label for="create-nama">Nama UKM</x-ui::field-label>
                <x-ui::input id="create-nama" type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama UKM" required />
                <x-ui::field-error :messages="$errors->get('nama')" />
            </x-ui::field>

            <x-ui::field>
                <x-ui::field-label for="create-deskripsi">Deskripsi</x-ui::field-label>
                <x-ui::textarea id="create-deskripsi" name="deskripsi" placeholder="Deskripsi UKM" rows="4">{{ old('deskripsi') }}</x-ui::textarea>
                <x-ui::field-error :messages="$errors->get('deskripsi')" />
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
@endif
@endsection
