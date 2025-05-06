<?php

namespace Lareon\Modules\Fence\App\Console\Command;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MakeFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fence:make-file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make file list';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = storage_path('app/ip_address.php');

        if (Storage::exists($filePath)) {
            $this->warn('The ip_address.php file already exists in storage/app.');
            return 0;
        }

        $content = <<<PHP
<?php

return [
    'blacklist' => [],
    'whitelist' => [],
];
PHP;
        try {
            File::put($filePath , $content);
            $this->info('Successfully created blocked_ips.php in storage/app.');
        } catch (\Exception $e) {
            $this->error('Failed to create blocked_ips.php: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
