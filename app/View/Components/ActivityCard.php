<?php
/**
 * Module: ActivityCard
 * Created: 2026-06-23
 * Author: Sistem UKM Poliban
 * Synopsis: Komponen card untuk menampilkan informasi kegiatan
 * 
 * Functions:
 *   - __construct(string $title, string $date, string $ukm, string $description, string $status) : void
 * 
 * Input Parameters:
 *   - title : string -> judul kegiatan
 *   - date : string -> tanggal pelaksanaan
 *   - ukm : string -> nama UKM
 *   - description : string -> deskripsi kegiatan
 *   - status : string -> status kegiatan (upcoming/ongoing/completed)
 */

namespace App\View\Components;

use Illuminate\View\Component;

class ActivityCard extends Component
{
    public string $title;
    public string $date;
    public string $ukm;
    public string $description;
    public string $status;
    
    public function __construct(
        string $title, 
        string $date, 
        string $ukm, 
        string $description = '', 
        string $status = 'upcoming'
    ) {
        $this->title = $title;
        $this->date = $date;
        $this->ukm = $ukm;
        $this->description = $description;
        $this->status = $status;
    }
    
    public function render()
    {
        return view('components.activity-card');
    }
}
