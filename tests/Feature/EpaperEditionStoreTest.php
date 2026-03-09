<?php

namespace Tests\Feature;

use App\Jobs\GenerateEditionPagesJob;
use App\Models\EpaperEdition;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EpaperEditionStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_edition_with_pdf(): void
    {
        Storage::fake('public');
        Queue::fake();

        /** @var User $user */
        $user = User::factory()->create();

        $pdf = UploadedFile::fake()->create('test-edition.pdf', 1024, 'application/pdf');

        $response = $this
            ->actingAs($user)
            ->post(route('admin.epaper.editions.store'), [
                'edition_name' => 'Ludhiana Morning',
                'issue_date' => '2026-02-06',
                'pdf' => $pdf,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseCount('epaper_editions', 1);

        $edition = EpaperEdition::query()->first();
        $this->assertEquals('Ludhiana Morning', $edition->edition_name);
        $this->assertEquals('2026-02-06', $edition->issue_date->format('Y-m-d'));
        $this->assertEquals('draft', $edition->status);
        $this->assertTrue(Storage::disk('public')->exists($edition->pdf_path));

        Queue::assertPushed(GenerateEditionPagesJob::class, function ($job) use ($edition) {
            return $job->editionId === $edition->id;
        });
    }

    public function test_edition_creation_requires_edition_name(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $pdf = UploadedFile::fake()->create('test.pdf', 1024, 'application/pdf');

        $response = $this
            ->actingAs($user)
            ->post(route('admin.epaper.editions.store'), [
                'issue_date' => '2026-02-06',
                'pdf' => $pdf,
            ]);

        $response->assertSessionHasErrors('edition_name');
    }

    public function test_edition_creation_requires_issue_date(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $pdf = UploadedFile::fake()->create('test.pdf', 1024, 'application/pdf');

        $response = $this
            ->actingAs($user)
            ->post(route('admin.epaper.editions.store'), [
                'edition_name' => 'Test Edition',
                'pdf' => $pdf,
            ]);

        $response->assertSessionHasErrors('issue_date');
    }

    public function test_edition_creation_requires_pdf_file(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('admin.epaper.editions.store'), [
                'edition_name' => 'Test Edition',
                'issue_date' => '2026-02-06',
            ]);

        $response->assertSessionHasErrors('pdf');
    }

    public function test_edition_creation_requires_valid_pdf_mime_type(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $notPdf = UploadedFile::fake()->image('test.jpg');

        $response = $this
            ->actingAs($user)
            ->post(route('admin.epaper.editions.store'), [
                'edition_name' => 'Test Edition',
                'issue_date' => '2026-02-06',
                'pdf' => $notPdf,
            ]);

        $response->assertSessionHasErrors('pdf');
    }

    public function test_pdf_is_stored_in_correct_directory_structure(): void
    {
        Storage::fake('public');
        Queue::fake();

        /** @var User $user */
        $user = User::factory()->create();
        $pdf = UploadedFile::fake()->create('test.pdf', 1024, 'application/pdf');

        $this
            ->actingAs($user)
            ->post(route('admin.epaper.editions.store'), [
                'edition_name' => 'Test Edition',
                'issue_date' => '2026-02-06',
                'pdf' => $pdf,
            ]);

        $edition = EpaperEdition::query()->first();

        $this->assertEquals("epaper/editions/{$edition->id}/source.pdf", $edition->pdf_path);
        $this->assertTrue(Storage::disk('public')->exists($edition->pdf_path));
    }
}
