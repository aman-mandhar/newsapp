<?php

namespace App\Livewire\Admin\Epaper;

use App\Models\EpaperEdition;
use App\Models\EpaperPage;
use App\Models\EpaperRegion;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class EditionMapper extends Component
{
    public $editionId;

    public $currentPageId;

    public $showOutlines = true;

    public $highlightOnHover = true;

    public $selectedRegionId = null;

    public $drawMode = false;

    public function mount($editionId): void
    {
        $this->editionId = $editionId;

        // Set first page as current if available
        if ($this->pages->isNotEmpty()) {
            $this->currentPageId = $this->pages->first()->id;
        }
    }

    #[Computed]
    public function edition()
    {
        return EpaperEdition::findOrFail($this->editionId);
    }

    #[Computed]
    public function pages()
    {
        return EpaperPage::where('edition_id', $this->editionId)
            ->orderBy('page_no')
            ->get();
    }

    #[Computed]
    public function currentPage()
    {
        if (! $this->currentPageId) {
            return null;
        }

        return EpaperPage::with(['regions.article'])
            ->findOrFail($this->currentPageId);
    }

    public function selectPage($pageId): void
    {
        $this->currentPageId = $pageId;
        $this->selectedRegionId = null;
    }

    #[On('region-created')]
    public function handleRegionCreated($x, $y, $w, $h): void
    {
        $region = EpaperRegion::create([
            'page_id' => $this->currentPageId,
            'x' => $x,
            'y' => $y,
            'w' => $w,
            'h' => $h,
            'is_active' => true,
        ]);

        $this->selectedRegionId = $region->id;
        $this->dispatch('region-selected', regionId: $region->id);
    }

    #[On('region-selected')]
    public function handleRegionSelected($regionId): void
    {
        $this->selectedRegionId = $regionId;
    }

    #[On('article-attached')]
    public function handleArticleAttached($regionId, $articleId): void
    {
        $region = EpaperRegion::find($regionId);
        if ($region) {
            $region->update(['article_id' => $articleId]);
        }
    }

    public function deleteRegion($regionId): void
    {
        $region = EpaperRegion::find($regionId);
        if ($region && $region->page_id === $this->currentPageId) {
            $region->delete();
            $this->selectedRegionId = null;
        }
    }

    public function toggleOutlines(): void
    {
        $this->showOutlines = ! $this->showOutlines;
    }

    public function toggleHighlight(): void
    {
        $this->highlightOnHover = ! $this->highlightOnHover;
    }

    public function validateAndPublish(): bool
    {
        // Check if all regions have articles attached
        $unmappedCount = EpaperRegion::whereHas('page', function ($query) {
            $query->where('edition_id', $this->editionId);
        })
            ->whereNull('article_id')
            ->count();

        if ($unmappedCount > 0) {
            session()->flash('error', "Cannot publish: {$unmappedCount} region(s) don't have articles attached.");

            return false;
        }

        $this->edition->update(['status' => 'published']);
        session()->flash('success', 'Edition published successfully!');

        return true;
    }

    public function render()
    {
        return view('livewire.admin.epaper.edition-mapper', [
            'edition' => $this->edition,
            'pages' => $this->pages,
            'currentPage' => $this->currentPage,
        ]);
    }
}
