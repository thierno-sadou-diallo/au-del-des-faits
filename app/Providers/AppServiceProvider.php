<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->configureRateLimiting();
        $this->ensureStorageDirectoriesExist();
    }

    private function configureRateLimiting(): void
    {
        RateLimiter::for('public-form', fn (Request $request) => [
            Limit::perMinute(5)->by($request->ip()),
        ]);

        RateLimiter::for('appointment-request', fn (Request $request) => [
            Limit::perMinute(3)->by($request->ip()),
        ]);

        RateLimiter::for('like-action', fn (Request $request) => [
            Limit::perMinute(20)->by($request->ip()),
        ]);

        RateLimiter::for('translation', fn (Request $request) => [
            Limit::perHour(20)->by($request->ip()),
        ]);
    }

    private function ensureStorageDirectoriesExist(): void
    {
        try {
            $directories = [
                storage_path('app/public'),
                storage_path('app/public/posts'),
                storage_path('app/public/portfolio'),
                storage_path('logs'),
            ];

            foreach ($directories as $directory) {
                if (! is_dir($directory)) {
                    mkdir($directory, 0755, true);
                }

                chmod($directory, 0755);
            }

            $linkPath = public_path('storage');
            $targetPath = storage_path('app/public');

            if (! file_exists($linkPath) && ! is_link($linkPath) && PHP_OS_FAMILY !== 'Windows') {
                @symlink($targetPath, $linkPath);
            }
        } catch (\Throwable $e) {
            if (app()->isLocal()) {
                \Log::debug('Storage initialization error: '.$e->getMessage());
            }
        }
    }
}
