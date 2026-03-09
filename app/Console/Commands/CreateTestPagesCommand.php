<?php

namespace App\Console\Commands;

use App\Models\EpaperEdition;
use App\Models\EpaperPage;
use Illuminate\Console\Command;

class CreateTestPagesCommand extends Command
{
    protected $signature = 'epaper:create-test-pages {edition_id}';

    protected $description = 'Create test pages for an edition (for testing without Imagick)';

    public function handle(): int
    {
        $editionId = $this->argument('edition_id');
        $edition = EpaperEdition::find($editionId);

        if (! $edition) {
            $this->error("Edition #{$editionId} not found!");

            return 1;
        }

        $this->info("Creating test pages for edition: {$edition->edition_name}");

        for ($i = 1; $i <= 5; $i++) {
            EpaperPage::create([
                'edition_id' => $edition->id,
                'page_no' => $i,
                'image_path' => "epaper/test/page{$i}.png",
                'thumb_path' => "epaper/test/thumb{$i}.jpg",
                'width' => 1200,
                'height' => 1600,
            ]);
        }

        $edition->update(['total_pages' => 5]);

        $this->info('5 test pages created successfully!');
        $this->info('You can now access the mapper.');

        return 0;
    }
}
