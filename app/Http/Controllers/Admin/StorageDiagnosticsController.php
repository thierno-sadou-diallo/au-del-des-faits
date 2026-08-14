<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;

class StorageDiagnosticsController
{
    public function index()
    {
        $diagnostics = $this->checkStorageHealth();

        return view('admin.storage-diagnostics', $diagnostics);
    }

    private function checkStorageHealth(): array
    {
        $data = [
            'media_disk' => config('filesystems.media_disk', 'public'),
            'media_disk_driver' => config('filesystems.disks.'.config('filesystems.media_disk', 'public').'.driver'),
            'storage_path' => storage_path('app/public'),
            'public_path' => public_path(),
            'symlink_path' => public_path('storage'),
            'disk_checks' => [],
            'directory_checks' => [],
            'sample_files' => [],
            'all_ok' => true,
        ];
        $usesLocalMediaDisk = $data['media_disk_driver'] === 'local';

        // Vérifier le symlink
        $data['disk_checks']['symlink_exists'] = is_link($data['symlink_path']);
        $data['disk_checks']['symlink_valid'] = false;
        $data['disk_checks']['symlink_target'] = null;

        if (is_link($data['symlink_path'])) {
            $data['disk_checks']['symlink_target'] = readlink($data['symlink_path']);
            $data['disk_checks']['symlink_valid'] = $data['disk_checks']['symlink_target'] === $data['storage_path'];
        }

        // Vérifier les répertoires
        $directories = [
            'app/public' => storage_path('app/public'),
            'posts' => storage_path('app/public/posts'),
            'portfolio' => storage_path('app/public/portfolio'),
            'public/storage' => public_path('storage'),
        ];

        foreach ($directories as $name => $path) {
            $exists = is_dir($path);
            $writable = $exists && is_writable($path);
            $readable = $exists && is_readable($path);
            
            $data['directory_checks'][$name] = [
                'exists' => $exists,
                'writable' => $writable,
                'readable' => $readable,
                'path' => $path,
            ];

            if ($usesLocalMediaDisk && (!$exists || !$writable)) {
                $data['all_ok'] = false;
            }
        }

        // Lister les fichiers d'exemple
        try {
            $postFiles = glob(storage_path('app/public/posts') . '/*', GLOB_BRACE);
            $portfolioFiles = glob(storage_path('app/public/portfolio') . '/*', GLOB_BRACE);

            $data['sample_files']['posts'] = array_slice(array_map('basename', $postFiles), 0, 5);
            $data['sample_files']['portfolio'] = array_slice(array_map('basename', $portfolioFiles), 0, 5);
        } catch (\Exception $e) {
            $data['sample_files']['error'] = $e->getMessage();
        }

        // Vérifier l'accès via Storage disk
        try {
            $disk = Storage::disk($data['media_disk']);
            $data['disk_checks']['storage_disk_works'] = count($disk->listContents('posts')) >= 0;
        } catch (\Exception $e) {
            $data['disk_checks']['storage_disk_works'] = false;
            $data['disk_checks']['storage_disk_error'] = $e->getMessage();
            $data['all_ok'] = false;
        }

        return $data;
    }
}
