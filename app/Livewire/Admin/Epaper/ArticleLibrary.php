<?php

namespace App\Livewire\Admin\Epaper;

use App\Models\EpaperArticle;
use Livewire\Attributes\On;
use Livewire\Component;

class ArticleLibrary extends Component
{
    public $editionId;

    public $selectedRegionId = null;

    public $search = '';

    public $showNewArticleModal = false;

    // New article form
    public $newArticleTitle = '';

    public $newArticleBody = '';

    public $newArticleSection = '';

    public function mount($editionId, $selectedRegionId = null): void
    {
        $this->editionId = $editionId;
        $this->selectedRegionId = $selectedRegionId;
    }

    #[On('region-selected')]
    public function handleRegionSelected($regionId): void
    {
        $this->selectedRegionId = $regionId;
    }

    public function getArticlesProperty()
    {
        $query = EpaperArticle::where('edition_id', $this->editionId);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%'.$this->search.'%')
                    ->orWhere('section', 'like', '%'.$this->search.'%')
                    ->orWhere('body', 'like', '%'.$this->search.'%');
            });
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function attachArticle($articleId): void
    {
        if (! $this->selectedRegionId) {
            session()->flash('article-error', 'Please select a region first.');

            return;
        }

        $this->dispatch('article-attached', regionId: $this->selectedRegionId, articleId: $articleId);
        session()->flash('article-success', 'Article attached successfully!');
    }

    public function openNewArticleModal(): void
    {
        $this->showNewArticleModal = true;
        $this->reset(['newArticleTitle', 'newArticleBody', 'newArticleSection']);
    }

    public function closeNewArticleModal(): void
    {
        $this->showNewArticleModal = false;
        $this->reset(['newArticleTitle', 'newArticleBody', 'newArticleSection']);
    }

    public function createArticle(): void
    {
        $this->validate([
            'newArticleTitle' => 'required|string|max:255',
            'newArticleBody' => 'required|string',
            'newArticleSection' => 'nullable|string|max:100',
        ]);

        $article = EpaperArticle::create([
            'edition_id' => $this->editionId,
            'title' => $this->newArticleTitle,
            'body' => $this->newArticleBody,
            'section' => $this->newArticleSection,
        ]);

        $this->closeNewArticleModal();

        // If a region is selected, attach the article automatically
        if ($this->selectedRegionId) {
            $this->attachArticle($article->id);
        }

        session()->flash('article-success', 'Article created successfully!');
    }

    public function render()
    {
        return view('livewire.admin.epaper.article-library', [
            'articles' => $this->articles,
        ]);
    }
}
