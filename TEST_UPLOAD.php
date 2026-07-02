<?php
/**
 * Test d'upload d'une image de test
 */

echo "=== TEST D'UPLOAD D'IMAGE ===\n\n";

// Créer une image PNG de test (1x1 pixel, couleur rouge)
$pngData = base64_decode(
    'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8DwHwAFBQIAX8jx0gAAAABJRU5ErkJggg=='
);

$testFilename = 'test-image-' . time() . '.png';
$storagePath = __DIR__ . '/storage/app/public/posts/' . $testFilename;
$publicPath = '/storage/posts/' . $testFilename;
$fileUrl = 'http://localhost' . $publicPath;

// Upload du fichier
if (@file_put_contents($storagePath, $pngData)) {
    echo "✓ Upload du fichier: OK\n";
    echo "  Fichier: $testFilename\n";
    echo "  Chemin stockage: storage/app/public/posts/$testFilename\n";
    echo "  Taille: " . filesize($storagePath) . " bytes\n";
    
    // Vérifier via symlink
    $publicAccess = __DIR__ . '/public/storage/posts/' . $testFilename;
    if (file_exists($publicAccess)) {
        echo "\n✓ Accès via symlink: OK\n";
        echo "  URL: http://votresite.com/storage/posts/$testFilename\n";
        echo "  Route: http://votresite.com/media-storage/posts/$testFilename\n";
    } else {
        echo "\n✗ Accès via symlink: ÉCHOUÉ\n";
    }
    
    // Vérifier la lisibilité
    if (is_readable($storagePath)) {
        echo "✓ Fichier lisible: OUI\n";
    }
    
    // Afficher les données du fichier
    echo "\n--- Contenu du fichier (hex) ---\n";
    echo bin2hex(substr($pngData, 0, 16)) . "... (PNG header)\n";
    
    echo "\n=== INSTRUCTIONS ===\n";
    echo "1. Pour tester, créez un article avec cette image\n";
    echo "2. Le fichier est maintenant dans: storage/app/public/posts/$testFilename\n";
    echo "3. URL d'accès: http://votresite.com/storage/posts/$testFilename\n";
    echo "4. Ou via route: http://votresite.com/media-storage/posts/$testFilename\n";
    echo "\n✓ Images: PRÊT À TESTER\n";
    
} else {
    echo "✗ Upload du fichier: ÉCHOUÉ\n";
    echo "  Vérifiez les permissions du dossier storage/app/public/posts/\n";
}

echo "\n=== FIN ===\n";
