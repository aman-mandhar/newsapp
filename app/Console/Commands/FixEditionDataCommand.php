<?php

namespace App\Console\Commands;

use App\Models\EpaperEdition;
use Illuminate\Console\Command;

class FixEditionDataCommand extends Command
{
    protected $signature = 'epaper:fix-edition-data {editionId}';

    protected $description = 'Fix edition total_pages to match actual page count';

    public function handle()
    {
        $editionId = $this->argument('editionId');
        $edition = EpaperEdition::findOrFail($editionId);

        $actualPages = $edition->pages()->count();
        $edition->total_pages = $actualPages;
        $edition->save();

        $this->info("Edition {$edition->edition_name} updated:");
        $this->info("- Total pages: {$actualPages}");

        return Command::SUCCESS;
    }
}
