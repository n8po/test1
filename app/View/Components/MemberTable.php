<?php
/**
 * Module: MemberTable
 * Created: 2026-06-23
 * Author: Sistem UKM Poliban
 * Synopsis: Komponen tabel untuk menampilkan daftar anggota UKM
 * 
 * Functions:
 *   - __construct(Collection $members, string $title, bool $showActions) : void
 * 
 * Input Parameters:
 *   - members : Collection -> koleksi data anggota
 *   - title : string -> judul tabel
 *   - showActions : bool -> tampilkan tombol aksi
 */

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Collection;

class MemberTable extends Component
{
    public Collection $members;
    public string $title;
    public bool $showActions;
    
    public function __construct(
        Collection $members, 
        string $title = 'Anggota UKM', 
        bool $showActions = true
    ) {
        $this->members = $members;
        $this->title = $title;
        $this->showActions = $showActions;
    }
    
    public function render()
    {
        return view('components.member-table');
    }
}
