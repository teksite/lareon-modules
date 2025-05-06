<?php

namespace Lareon\Modules\Fence\App\Logic;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Lareon\Modules\Fence\App\Models\RestrictIp;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Handler\Services\FetchDataService;

class IpLogic
{
    private string $filePath;

    public function __construct()
    {
        $this->filePath = storage_path('app/ip_address.php');

        if (!file_exists($this->filePath)) {
            Artisan::call('fence:make-file');
        }
    }

    public function get(mixed $fetchData = [])
    {
        return app(ServiceWrapper::class)(function () use ($fetchData) {
            if ($this->isDatabaseStorage()) {
                return app(FetchDataService::class)(RestrictIp::class, ['ip_address'], ...$fetchData);
            }

            return $this->getFromFile(request()->input('s'));
        }, hasTransaction: false);
    }

    public function register(array $input)
    {

        return app(ServiceWrapper::class)(function () use ($input) {
            if ($this->isDatabaseStorage()) {
                return RestrictIp::create($input);
            }

            $this->storeIpInFile($input['type'], $input['ip_address']);

            return ['status' => 'success', 'ip_address' => $input['ip_address']];
        });
    }


    public function delete(array $input)
    {
        return app(ServiceWrapper::class)(function () use ($input) {
            if ($this->isDatabaseStorage()) {
                return RestrictIp::where('ip_address', $input['ip_address'])
                    ->when(isset($input['type']), fn($query) => $query->where('type', $input['type']))
                    ->delete();
            }

            $this->removeIpFromFile($input['type'], $input['ip_address']);

            return ['status' => 'success', 'ip_address' => $input['ip_address']];
        });
    }


    private function isDatabaseStorage(): bool
    {
        return config('lareon.fence.storage', 'file') === 'database';
    }


    private function getFromFile(?string $search)
    {
        $ipAddresses = collect($this->loadFile())
            ->flatMap(fn ($items, $type) => collect($items)->map(fn ($ip) => [
                'ip_address' => $ip,
                'type' => $type,
            ]));

        return $search ? $ipAddresses->filter(fn ($item) => $item['ip_address'] === trim($search)) : $ipAddresses;
    }


    private function storeIpInFile(string $type, string $ipAddress): void
    {
        try {
            $ipAddresses = $this->loadFile();

            $ipAddresses[$type][] = $ipAddress;

            $this->saveFile($ipAddresses);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to store IP address in file: ' . $e->getMessage());
        }
    }

    private function removeIpFromFile(string $type, string $ipAddress): void
    {
        try {
            $ipAddresses = $this->loadFile();

            if (!isset($ipAddresses[$type])) {
                throw new \RuntimeException("Type '{$type}' not found in IP address file.");
            }

            $ipAddresses[$type] = array_values(array_filter(
                $ipAddresses[$type],
                fn ($ip) => $ip !== $ipAddress
            ));

            if (empty($ipAddresses[$type])) {
                unset($ipAddresses[$type]);
            }

            $this->saveFile($ipAddresses);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to remove IP address from file: ' . $e->getMessage());
        }
    }

    /**
     * Load IP addresses from file.
     *
     * @return array
     * @throws \RuntimeException
     */
    private function loadFile(): array
    {
        if (!file_exists($this->filePath)) {
            throw new \RuntimeException('IP address file does not exist.');
        }

        return require $this->filePath;
    }

    /**
     * Save IP addresses to file.
     *
     * @param  array  $ipAddresses
     * @return void
     * @throws \RuntimeException
     */
    private function saveFile(array $ipAddresses): void
    {
        $content = "<?php\nreturn " . var_export($ipAddresses, true) . ";\n";

        if (File::put($this->filePath, $content, LOCK_EX) === false) {
            throw new \RuntimeException('Failed to write IP address file.');
        }
    }
}

