<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // S'assurer que les répertoires de stockage existent
        $this->ensureStorageDirectoriesExist();
    }

    /**
     * S'assurer que les répertoires de stockage existent avec les bonnes permissions
     */
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
                if (!is_dir($directory)) {
                    mkdir($directory, 0755, true);
                }
                
                // S'assurer que les permissions sont correctes
                chmod($directory, 0755);
            }

            // Vérifier le symlink
            $linkPath = public_path('storage');
            $targetPath = storage_path('app/public');

            if (!file_exists($linkPath) && !is_link($linkPath)) {
                // Créer le symlink si possible
                if (PHP_OS_FAMILY !== 'Windows') {
                    @symlink($targetPath, $linkPath);
                }
            }
        } catch (\Exception $e) {
            // Silencieusement ignorer les erreurs au démarrage
            // Mais on peut les logger en développement
            if (app()->isLocal()) {
                \Log::debug('Storage initialization error: ' . $e->getMessage());
            }
        }
    }
}
