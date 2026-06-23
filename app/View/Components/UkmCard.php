<?php
/**
 * Module: UkmCard
 * Created: 2026-06-23
 * Author: Sistem UKM Poliban
 * Synopsis: Komponen card untuk menampilkan informasi UKM
 * 
 * Functions:
 *   - __construct(string $name, string $description, int $memberCount, bool $showJoinButton) : void
 * 
 * Input Parameters:
 *   - name : string -> nama UKM
 *   - description : string -> deskripsi UKM
 *   - memberCount : int -> jumlah anggota
 *   - showJoinButton : bool -> tampilkan tombol gabung
 */

namespace App\View\Components;

use Illuminate\View\Component;

class UkmCard extends Component
{
    public string $name;
    public string $description;
    public int $memberCount;
    public bool $showJoinButton;
    
    public function __construct(
        string $name, 
        string $description = '', 
        int $memberCount = 0, 
        bool $showJoinButton = true
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->memberCount = $memberCount;
        $this->showJoinButton = $showJoinButton;
    }
    
    public function render()
    {
        return view('components.ukm-card');
    }
}
