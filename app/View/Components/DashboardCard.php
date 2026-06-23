<?php
/**
 * Module: DashboardCard
 * Created: 2026-06-23
 * Author: Sistem UKM Poliban
 * Synopsis: Komponen card untuk dashboard dengan statistik UKM
 * 
 * Functions:
 *   - __construct(string $title, string $value, string $description, string $icon, string $variant) : void
 * 
 * Input Parameters:
 *   - title : string -> judul card
 *   - value : string -> nilai utama
 *   - description : string -> deskripsi
 *   - icon : string -> nama icon Lucide
 *   - variant : string -> warna variant (default/success/warning/danger/info)
 */

namespace App\View\Components;

use Illuminate\View\Component;

class DashboardCard extends Component
{
    public string $title;
    public string $value;
    public string $description;
    public string $icon;
    public string $variant;
    
    public function __construct(
        string $title, 
        string $value, 
        string $description = '', 
        string $icon = 'users', 
        string $variant = 'default'
    ) {
        $this->title = $title;
        $this->value = $value;
        $this->description = $description;
        $this->icon = $icon;
        $this->variant = $variant;
    }
    
    public function render()
    {
        return view('components.dashboard-card');
    }
}
