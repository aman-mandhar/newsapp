<?php

namespace App\Livewire\Admin\Epaper;

use Livewire\Component;

class PageCanvas extends Component
{
    public $page;

    public $regions = [];

    public $showOutlines = true;

    public $highlightOnHover = true;

    public $selectedRegionId = null;

    public $drawMode = false;

    public function mount($page, $regions = [], $showOutlines = true, $highlightOnHover = true, $selectedRegionId = null): void
    {
        $this->page = $page;
        $this->regions = $regions;
        $this->showOutlines = $showOutlines;
        $this->highlightOnHover = $highlightOnHover;
        $this->selectedRegionId = $selectedRegionId;
    }

    public function toggleDrawMode(): void
    {
        $this->drawMode = ! $this->drawMode;
    }

    public function selectRegion($regionId): void
    {
        $this->selectedRegionId = $regionId;
        $this->dispatch('region-selected', regionId: $regionId);
    }

    public function createRegion($x, $y, $w, $h): void
    {
        // Normalize coordinates to 0-1 range
        $this->dispatch('region-created', x: $x, y: $y, w: $w, h: $h);
    }

    public function render()
    {
        return view('livewire.admin.epaper.page-canvas');
    }
}
