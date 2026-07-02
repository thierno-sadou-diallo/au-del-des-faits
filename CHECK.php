<?php
/**
 * Vérification rapide - 10 secondes
 */

$checks = [
    'storage/app/public' => 'Dossier principal',
    'storage/app/public/posts' => 'Dossier articles',
    'storage/app/public/portfolio' => 'Dossier portfolio',
    'public/storage' => 'Symlink',
];

echo "\n🔍 VÉRIFICATION RAPIDE - État du Système\n";
echo str_repeat("=", 50) . "\n\n";

$allOk = true;
foreach ($checks as $path => $label) {
    $fullPath = __DIR__ . '/' . $path;
    $exists = file_exists($fullPath) || is_link($fullPath);
    $icon = $exists ? '✓' : '✗';
    $status = $exists ? 'OK' : 'MANQUANT';
    
    echo sprintf("[%s] %-30s %s\n", $icon, $label, $status);
    
    if (!$exists) {
        $allOk = false;
    }
}

echo "\n" . str_repeat("=", 50) . "\n";

if ($allOk) {
    echo "✅ SYSTÈME PRÊT À TESTER LES IMAGES\n";
} else {
    echo "❌ ERREUR DÉTECTÉE - Contactez l'administrateur\n";
}

echo "\n📋 Prochaines étapes:\n";
echo "1. Ouvrir: https://votresite.com/TEST_IMAGES.html\n";
echo "2. Créer un article avec une image\n";
echo "3. Vérifier que l'image s'affiche\n";
echo "\n";
