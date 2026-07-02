<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class VerifyStorageLink extends Command
{
    protected $signature = 'storage:verify';
    protected $description = 'Vérifie et crée le symlink de stockage si nécessaire';

    public function handle()
    {
        $filesystem = new Filesystem();
        
        $linkPath = public_path('storage');
        $targetPath = storage_path('app/public');

        // Vérifier si le symlink existe déjà et pointe vers le bon endroit
        if (is_link($linkPath)) {
            $currentTarget = readlink($linkPath);
            $expectedTarget = $targetPath;
            
            if ($currentTarget === $expectedTarget) {
                $this->info('✓ Le symlink storage existe et pointe correctement vers ' . $expectedTarget);
                return Command::SUCCESS;
            }
            
            // Le symlink existe mais pointe vers le mauvais endroit
            $this->warn('⚠ Le symlink existe mais pointe vers un mauvais chemin: ' . $currentTarget);
            $filesystem->delete($linkPath);
        } elseif (file_exists($linkPath)) {
            // Un dossier/fichier existe déjà
            $this->error('✗ Un dossier ou fichier existe déjà à ' . $linkPath);
            $this->line('Supprimez-le manuellement et réexécutez cette commande.');
            return Command::FAILURE;
        }

        // Créer le symlink
        try {
            if (PHP_OS_FAMILY === 'Windows') {
                // Sur Windows, utiliser mklink en mode directory
                $command = "mklink /D \"$linkPath\" \"$targetPath\"";
                exec($command, $output, $returnVar);
                
                if ($returnVar !== 0) {
                    $this->error('✗ Impossible de créer le symlink sur Windows.');
                    $this->error('Exécutez cette commande en tant qu\'administrateur ou créez le lien manuellement:');
                    $this->line("mklink /D \"$linkPath\" \"$targetPath\"");
                    return Command::FAILURE;
                }
            } else {
                // Sur Linux/Mac, utiliser symlink()
                symlink($targetPath, $linkPath);
            }
            
            $this->info('✓ Symlink créé avec succès: ' . $linkPath . ' → ' . $targetPath);
            $this->info('✓ Les fichiers de stockage sont maintenant accessibles.');
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('✗ Erreur lors de la création du symlink: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
