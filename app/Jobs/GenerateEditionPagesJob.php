<?php

namespace App\Jobs;

use App\Models\EpaperEdition;
use App\Models\EpaperPage;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Imagick as ImagickLib;

class GenerateEditionPagesJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $editionId
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $edition = EpaperEdition::query()->findOrFail($this->editionId);

        try {
            // Get the full path to the PDF
            $pdfPath = Storage::disk('public')->path($edition->pdf_path);

            if (! file_exists($pdfPath)) {
                throw new Exception("PDF file not found: {$pdfPath}");
            }

            // Initialize Imagick
            /** @var \Imagick $imagick */
            $imagick = new ImagickLib;
            $imagick->setResolution(150, 150); // Set DPI for better quality
            $imagick->readImage($pdfPath);

            $totalPages = $imagick->getNumberImages();

            // Process each page
            foreach ($imagick as $pageNumber => $page) {
                $pageNo = $pageNumber + 1; // 1-based numbering

                // Set image format
                $page->setImageFormat('png');
                $page->setImageCompressionQuality(90);

                // Get dimensions
                $width = $page->getImageWidth();
                $height = $page->getImageHeight();

                // Save full-size page image
                $pagePath = "epaper/editions/{$edition->id}/pages/".str_pad((string) $pageNo, 2, '0', STR_PAD_LEFT).'.png';
                Storage::disk('public')->put($pagePath, $page->getImageBlob());

                // Create thumbnail
                $thumb = clone $page;
                $thumb->thumbnailImage(200, 0); // 200px wide, maintain aspect ratio
                $thumb->setImageFormat('jpg');
                $thumb->setImageCompressionQuality(85);

                $thumbPath = "epaper/editions/{$edition->id}/thumbs/".str_pad((string) $pageNo, 2, '0', STR_PAD_LEFT).'.jpg';
                Storage::disk('public')->put($thumbPath, $thumb->getImageBlob());

                // Create page record
                EpaperPage::query()->create([
                    'edition_id' => $edition->id,
                    'page_no' => $pageNo,
                    'image_path' => $pagePath,
                    'thumb_path' => $thumbPath,
                    'width' => $width,
                    'height' => $height,
                ]);

                // Clean up
                $thumb->clear();
                $thumb->destroy();
            }

            // Clean up Imagick
            $imagick->clear();
            $imagick->destroy();

            // Update edition
            $edition->update([
                'total_pages' => $totalPages,
                'generated_at' => now(),
            ]);

            Log::info("Successfully generated {$totalPages} pages for edition #{$edition->id}");
        } catch (Exception $e) {
            Log::error("Failed to generate pages for edition #{$edition->id}: {$e->getMessage()}");
            throw $e;
        }
    }
}
