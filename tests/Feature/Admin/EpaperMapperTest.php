<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Epaper\EditionMapper;
use App\Models\EpaperArticle;
use App\Models\EpaperEdition;
use App\Models\EpaperPage;
use App\Models\EpaperRegion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EpaperMapperTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected EpaperEdition $edition;

    protected EpaperPage $page;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->edition = EpaperEdition::factory()->create();
        $this->page = EpaperPage::factory()->create([
            'edition_id' => $this->edition->id,
            'page_no' => 1,
        ]);
    }

    public function test_mapper_page_loads_successfully(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.epaper.editions.mapper', $this->edition));

        $response->assertStatus(200);
        $response->assertSeeLivewire('admin.epaper.edition-mapper');
    }

    public function test_edition_mapper_component_mounts_correctly(): void
    {
        Livewire::actingAs($this->user)
            ->test(EditionMapper::class, ['editionId' => $this->edition->id])
            ->assertSet('editionId', $this->edition->id)
            ->assertSet('currentPageId', $this->page->id)
            ->assertCount('pages', 1);
    }

    public function test_can_create_region_on_page(): void
    {
        Livewire::actingAs($this->user)
            ->test(EditionMapper::class, ['editionId' => $this->edition->id])
            ->dispatch('region-created', x: 0.1, y: 0.2, w: 0.3, h: 0.4)
            ->assertDispatched('region-selected');

        $this->assertDatabaseHas('epaper_regions', [
            'page_id' => $this->page->id,
            'x' => 0.1,
            'y' => 0.2,
            'w' => 0.3,
            'h' => 0.4,
        ]);
    }

    public function test_can_attach_article_to_region(): void
    {
        $region = EpaperRegion::factory()->create([
            'page_id' => $this->page->id,
        ]);

        $article = EpaperArticle::factory()->create([
            'edition_id' => $this->edition->id,
        ]);

        Livewire::actingAs($this->user)
            ->test(EditionMapper::class, ['editionId' => $this->edition->id])
            ->dispatch('article-attached', regionId: $region->id, articleId: $article->id);

        $this->assertDatabaseHas('epaper_regions', [
            'id' => $region->id,
            'article_id' => $article->id,
        ]);
    }

    public function test_can_delete_region(): void
    {
        $region = EpaperRegion::factory()->create([
            'page_id' => $this->page->id,
        ]);

        Livewire::actingAs($this->user)
            ->test(EditionMapper::class, ['editionId' => $this->edition->id])
            ->call('deleteRegion', $region->id);

        $this->assertDatabaseMissing('epaper_regions', [
            'id' => $region->id,
        ]);
    }

    public function test_can_switch_between_pages(): void
    {
        $page2 = EpaperPage::factory()->create([
            'edition_id' => $this->edition->id,
            'page_no' => 2,
        ]);

        Livewire::actingAs($this->user)
            ->test(EditionMapper::class, ['editionId' => $this->edition->id])
            ->assertSet('currentPageId', $this->page->id)
            ->call('selectPage', $page2->id)
            ->assertSet('currentPageId', $page2->id);
    }

    public function test_cannot_publish_edition_with_unmapped_regions(): void
    {
        // Create region without article
        EpaperRegion::factory()->create([
            'page_id' => $this->page->id,
            'article_id' => null,
        ]);

        Livewire::actingAs($this->user)
            ->test(EditionMapper::class, ['editionId' => $this->edition->id])
            ->call('validateAndPublish');

        // Check that edition status is still draft
        $this->assertDatabaseHas('epaper_editions', [
            'id' => $this->edition->id,
            'status' => 'draft',
        ]);
    }

    public function test_can_publish_edition_when_all_regions_mapped(): void
    {
        $article = EpaperArticle::factory()->create([
            'edition_id' => $this->edition->id,
        ]);

        EpaperRegion::factory()->create([
            'page_id' => $this->page->id,
            'article_id' => $article->id,
        ]);

        Livewire::actingAs($this->user)
            ->test(EditionMapper::class, ['editionId' => $this->edition->id])
            ->call('validateAndPublish');

        $this->assertDatabaseHas('epaper_editions', [
            'id' => $this->edition->id,
            'status' => 'published',
        ]);
    }

    public function test_can_toggle_display_options(): void
    {
        Livewire::actingAs($this->user)
            ->test(EditionMapper::class, ['editionId' => $this->edition->id])
            ->assertSet('showOutlines', true)
            ->call('toggleOutlines')
            ->assertSet('showOutlines', false)
            ->assertSet('highlightOnHover', true)
            ->call('toggleHighlight')
            ->assertSet('highlightOnHover', false);
    }
}
