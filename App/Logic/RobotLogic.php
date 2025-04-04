<?php

namespace Lareon\Modules\Seo\App\Logic;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Teksite\Handler\Actions\ServiceResult;
use Teksite\Handler\Actions\ServiceWrapper;

class RobotLogic
{
    private const ROBOTS_FILE_PATH = 'robots.txt';

    private string $filePath;

    public function __construct()
    {
        $this->filePath = public_path(self::ROBOTS_FILE_PATH);
    }

    /**
     * Retrieves the contents of the robots.txt file
     *
     * @return ServiceResult The file contents
     */
    public function getContent() :ServiceResult
    {
        return app(ServiceWrapper::class)(function () {
            $this->ensureFileExists();
            return File::get($this->filePath);
        }, hasTransaction: false);
    }

    /**
     * Updates the contents of the robots.txt file
     *
     * @param array $inputs Array containing the new content under 'content' key
     * @return ServiceResult The updated file contents
     */
    public function changeContent(array $inputs) :ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            $filename = public_path("robots.txt");
            File::put($this->filePath, $inputs['content']);
            return File::get($filename);

        });
    }


    /**
     * Ensures the robots.txt file exists, creating it if necessary
     *
     * @return void
     */
    private function ensureFileExists(): void
    {
        $appUrl=url();
        $adminUrl=route('admin.dashboard');
        if (!File::exists($this->filePath)) {
            $defaultContent = <<<EOT
User-agent: *
Disallow: /$adminUrl/
Disallow: /login/
Allow: /

#Sitemap:

# Prevent crawling of search results pages
Disallow: /search/

# Block crawling of common temporary or cache files
Disallow: /*.php$
Disallow: /*.tmp

# Crawl delay for politeness (optional)
Crawl-delay: 10

# Host directive (optional, for some search engines)
Host: $appUrl
EOT;

            File::put($this->filePath, $defaultContent);
        }
    }
}

