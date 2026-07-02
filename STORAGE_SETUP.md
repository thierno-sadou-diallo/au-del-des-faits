# Configuration du Stockage des Images en Production

## Problème identifié
Les images n's'affichent pas après upload par l'admin. Cela est généralement dû à:
1. Le symlink `public/storage` n'existe pas
2. Les permissions du dossier `storage/app/public` ne sont pas correctes
3. Le chemin du fichier n'est pas accessible

## Solution implémentée

### 1. Vérifier l'état du stockage (Immédiat)
Allez sur: `https://votresite.com/admin/storage-diagnostics`

Cette page vous montre:
- ✓ Si le symlink existe
- ✓ Si les répertoires ont les bonnes permissions
- ✓ Les fichiers qui ont été uploadés

### 2. Créer le symlink (Important!)

**Sur Linux/Mac (shell/SSH):**
```bash
php artisan storage:link
# OU
php artisan storage:verify
```

**Sur Windows (avec Git Bash ou PowerShell):**
```bash
php artisan storage:verify
```

**Sinon, manuellement:**
Le lien symbolique doit pointer:
- De: `public/storage`
- Vers: `storage/app/public`

### 3. Permissions (Important!)

Assurez-vous que les répertoires ont les bonnes permissions:

**Sur Linux/Mac (shell/SSH):**
```bash
chmod -R 755 storage/app/public
chmod -R 755 storage/logs
chmod -R 755 public/storage
```

### 4. Tester l'upload

1. Admin → Articles → Créer un nouvel article
2. Remplir le formulaire
3. Choisir une image
4. Publier
5. Cliquer sur "Lire" → L'image doit s'afficher

Si l'image n'apparaît pas:
1. Allez à `/admin/storage-diagnostics`
2. Vérifiez que tous les éléments sont ✓ (vert)
3. Contactez votre hébergeur si les permissions ne peuvent pas être changées

## Fichiers modifiés

- `app/Models/Post.php` - Meilleure gestion des URLs d'images
- `app/Models/Portfolio.php` - Meilleure gestion des URLs d'images
- `routes/web.php` - Routes de stockage plus robustes
- `app/Providers/AppServiceProvider.php` - Vérification automatique au démarrage
- `app/Console/Commands/VerifyStorageLink.php` - Nouvelle commande artisan
- `app/Http/Controllers/Admin/StorageDiagnosticsController.php` - Page de diagnostic
- `resources/views/admin/storage-diagnostics.blade.php` - Vue de diagnostic

## Commandes à exécuter une fois

En production, exécutez ces commandes une seule fois:

```bash
# Créer le symlink
php artisan storage:link

# OU si la première commande ne fonctionne pas
php artisan storage:verify

# Fixer les permissions
chmod -R 755 storage/app/public
chmod -R 755 public/storage
```

## Support

Si vous avez toujours des problèmes:
1. Vérifiez la page `/admin/storage-diagnostics`
2. Contactez votre hébergeur pour les permissions de fichiers
3. Vérifiez que l'espace disque n'est pas plein
