<?php

namespace App\Console\Commands;

use App\Models\EpaperPage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CreatePlaceholderImagesCommand extends Command
{
    protected $signature = 'epaper:create-placeholder-images';

    protected $description = 'Create placeholder images for epaper pages that are missing images';

    public function handle()
    {
        $pages = EpaperPage::whereNotNull('image_path')->get();
        $created = 0;

        foreach ($pages as $page) {
            $fullPath = Storage::disk('public')->path($page->image_path);

            if (! file_exists($fullPath)) {
                $directory = dirname($fullPath);

                if (! is_dir($directory)) {
                    mkdir($directory, 0755, true);
                }

                // Create a simple placeholder image (A4 size: 2480x3508 pixels)
                $width = 2480;
                $height = 3508;
                $image = imagecreatetruecolor($width, $height);

                // Set background color (light gray)
                $bgColor = imagecolorallocate($image, 240, 240, 245);
                imagefill($image, 0, 0, $bgColor);

                // Add text
                $textColor = imagecolorallocate($image, 100, 100, 120);
                $text = "Page {$page->page_no}";

                // Use a built-in font
                imagestring($image, 5, $width / 2 - 40, $height / 2, $text, $textColor);

                // Add border
                $borderColor = imagecolorallocate($image, 200, 200, 210);
                imagerectangle($image, 10, 10, $width - 10, $height - 10, $borderColor);

                // Save the image
                imagepng($image, $fullPath);

                $created++;
                $this->info("Created placeholder image: {$page->image_path}");
            }
        }

        $this->info("Created {$created} placeholder images.");

        return Command::SUCCESS;
    }
}
