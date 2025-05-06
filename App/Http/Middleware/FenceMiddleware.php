<?php

namespace Lareon\Modules\Fence\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Lareon\Modules\Fence\App\Models\RestrictIp;
use Symfony\Component\HttpFoundation\Response;

class FenceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $type=$this->fenceType();
        $ip=$request->ip();
        if ($this->isDatabaseStorage()) {
            $isExist =$this->searchInDatabase($ip, $type);
        }else{
            $isExist=$this->searchInFile($ip, $type);
        }
        if ($type === 'whitelist' && $isExist ) {
            return $next($request);
        }
        if ($type === 'blacklist' && !$isExist ) {
            return $next($request);
        }
       abort(403 ,'your ip is limited,');
    }

    private function isDatabaseStorage(): bool
    {
        return config('lareon.fence.storage', 'file') === 'database';
    }

    private function fenceType(): string
    {
        return config('lareon.fence.type', 'blacklist');
    }

    private function searchInDatabase(string $ip ,string $type='black'): bool
    {
        return RestrictIp::query()->where('ip_address', $ip)->where('type',$type)->exists();
    }

    private function searchInFile(string $ip ,string $type='black'): bool
    {

        $filePath = storage_path('app/ip_address.php');
        $ips=require $filePath;
        return in_array($ip, $ips[$type]);

    }
}
