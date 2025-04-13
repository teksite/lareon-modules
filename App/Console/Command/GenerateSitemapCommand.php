<?php

namespace Lareon\Modules\Seo\App\Console\Command;

use Illuminate\Console\Command;
use Lareon\Modules\Seo\App\Logic\SitemapLogic;
use Lareon\Modules\Seo\App\Logic\SitemapScannerLogic;

class GenerateSitemapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:regenerate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '(re)generate the sitemap for the app';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        (new SitemapScannerLogic())->scan();
        (new SitemapLogic())->generateSitemaps();
    }
}
