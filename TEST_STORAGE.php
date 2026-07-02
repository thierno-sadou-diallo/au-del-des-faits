<?php
/**
 * Test de diagnostic du système de stockage des images
 */

echo "=== TEST DE STOCKAGE DES IMAGES ===\n\n";

$basePath = __DIR__;

// 1. Vérifier les répertoires
echo "1. VÉRIFICATION DES RÉPERTOIRES\n";
echo "────────────────────────────────\n";

$dirs = [
    'storage/app/public' => 'Dossier principal',
    'storage/app/public/posts' => 'Images des articles',
    'storage/app/public/portfolio' => 'Images du portfolio',
    'public/storage' => 'Symlink vers le stockage',
    'public' => 'Dossier public',
];

foreach ($dirs as $dir => $label) {
    $path = $basePath . '/' . $dir;
    $exists = is_dir($path) || is_link($path);
    $isLink = is_link($path);
    $perms = $exists ? substr(sprintf('%o', fileperms($path)), -4) : 'N/A';
    
    $status = $exists ? '✓' : '✗';
    $linkInfo = $isLink ? ' [SYMLINK]' : '';
    echo sprintf("%-40s %s (perms: %s)%s\n", $label, $status, $perms, $linkInfo);
}

// 2. Vérifier les fichiers
echo "\n2. FICHIERS PRÉSENTS\n";
echo "────────────────────────────────\n";

$postsPath = $basePath . '/storage/app/public/posts';
$portfolioPath = $basePath . '/storage/app/public/portfolio';

$postsFiles = is_dir($postsPath) ? array_diff(scandir($postsPath), ['.', '..']) : [];
$portfolioFiles = is_dir($portfolioPath) ? array_diff(scandir($portfolioPath), ['.', '..']) : [];

echo "Articles (posts): " . (count($postsFiles) > 0 ? count($postsFiles) . " fichier(s)" : "Vide") . "\n";
foreach ($postsFiles as $file) {
    $size = filesize($postsPath . '/' . $file);
    echo "  - $file (" . formatBytes($size) . ")\n";
}

echo "\nPortfolio: " . (count($portfolioFiles) > 0 ? count($portfolioFiles) . " fichier(s)" : "Vide") . "\n";
foreach ($portfolioFiles as $file) {
    $size = filesize($portfolioPath . '/' . $file);
    echo "  - $file (" . formatBytes($size) . ")\n";
}

// 3. Test de lecture/écriture
echo "\n3. TEST DE LECTURE/ÉCRITURE\n";
echo "────────────────────────────────\n";

$testFile = $basePath . '/storage/app/public/test_' . time() . '.txt';
$testContent = 'Test de stockage - ' . date('Y-m-d H:i:s');

if (@file_put_contents($testFile, $testContent)) {
    echo "✓ Écriture: OK\n";
    
    if (file_exists($testFile) && is_readable($testFile)) {
        echo "✓ Lecture: OK\n";
        $content = file_get_contents($testFile);
        unlink($testFile);
        echo "✓ Suppression: OK\n";
    } else {
        echo "✗ Lecture: ÉCHOUÉ\n";
    }
} else {
    echo "✗ Écriture: ÉCHOUÉ (permissions insuffisantes)\n";
}

// 4. Vérifier les fichiers de configuration
echo "\n4. CONFIGURATION LARAVEL\n";
echo "────────────────────────────────\n";

$configFile = $basePath . '/config/filesystems.php';
if (file_exists($configFile)) {
    echo "✓ filesystems.php existe\n";
    
    // Chercher la config du disque 'public'
    $config = file_get_contents($configFile);
    if (strpos($config, "'public'") !== false && strpos($config, 'storage/app/public') !== false) {
        echo "✓ Config du disque 'public' correcte\n";
    }
}

// 5. Test de URLs
echo "\n5. TEST DE GÉNÉRATION D'URLS\n";
echo "────────────────────────────────\n";

// Créer un fichier test pour les URLs
$testDir = $basePath . '/storage/app/public/test';
if (!is_dir($testDir)) {
    @mkdir($testDir, 0755, true);
}
$testImagePath = $testDir . '/test.txt';
file_put_contents($testImagePath, 'test');

$relativePath = 'test/test.txt';
$publicPath = 'storage/' . $relativePath;

echo "Chemin relatif stockage: $relativePath\n";
echo "URL potentielle: /storage/$relativePath\n";
echo "Fichier accessible via PHP:\n";
echo "  - Direct: " . (file_exists($basePath . '/public/storage/' . $relativePath) ? '✓' : '✗') . "\n";

// Nettoyer
@unlink($testImagePath);
@rmdir($testDir);

// 6. Résumé
echo "\n6. RÉSUMÉ\n";
echo "────────────────────────────────\n";

$allGood = (
    is_dir($postsPath) && 
    is_dir($portfolioPath) &&
    (is_dir($basePath . '/public/storage') || is_link($basePath . '/public/storage'))
);

if ($allGood) {
    echo "✓ Système de stockage: OPÉRATIONNEL\n";
} else {
    echo "✗ Système de stockage: ERREUR DÉTECTÉE\n";
}

echo "\n=== FIN DU TEST ===\n";

/**
 * Formater la taille en bytes
 */
function formatBytes($bytes) {
    $units = ['B', 'KB', 'MB', 'GB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= (1 << (10 * $pow));
    
    return round($bytes, 2) . ' ' . $units[$pow];
}
