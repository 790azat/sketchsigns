<?php

namespace App\Console\Commands;

use App\Services\WooImporter;
use Illuminate\Console\Command;

class ImportCatalog extends Command
{
    protected $signature = 'catalog:import {--per-page=10}';

    protected $description = 'Import categories, products, variations and images from the old WooCommerce site';

    public function handle(WooImporter $importer): int
    {
        $this->info('Categories: '.$importer->importCategories());

        $page = 1;
        do {
            $result = $importer->importProducts($page, (int) $this->option('per-page'));
            $this->info("Products page {$result['page']}/{$result['total_pages']}: {$result['imported']} imported");
            $page++;
        } while ($page <= $result['total_pages']);

        return self::SUCCESS;
    }
}
