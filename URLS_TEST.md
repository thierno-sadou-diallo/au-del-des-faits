# 🎯 URLs DE TEST - COPIER/COLLER

## Pages de Diagnostic

```
https://votresite.com/TEST_IMAGES.html
https://votresite.com/admin/storage-diagnostics
```

## Routes de Test d'Image

```
https://votresite.com/storage/posts/test-image-1783002024.png
https://votresite.com/media-storage/posts/test-image-1783002024.png
```

## Admin

```
https://votresite.com/admin/dashboard
https://votresite.com/admin/posts (créer article)
```

---

## ✅ PLAN DE TEST

### Test 1: Diagnostic (2 min)
1. Allez à: `https://votresite.com/TEST_IMAGES.html`
2. Vérifiez que tous les éléments sont ✓ verts

### Test 2: Page Diagnostic Avancée (1 min)
1. Allez à: `https://votresite.com/admin/storage-diagnostics`
2. Vérifiez tous les statuts

### Test 3: Upload Réel d'Image (5 min)
1. Allez à: `https://votresite.com/admin/dashboard`
2. Cliquez: **Articles** → **+ Nouvel article**
3. Remplissez le formulaire
4. **Important:** Cliquez "Choisir un fichier" et sélectionnez une image
5. Cliquez: **Publier**
6. Retournez à l'accueil
7. Ouvrez votre nouvel article
8. **✓ VÉRIFIEZ:** L'image s'affiche

### Test 4: Images du Portfolio (3 min)
1. Allez à: `https://votresite.com/admin/dashboard`
2. Cliquez: **Portfolio** → **+ Nouveau projet**
3. Sélectionnez des images
4. Publiez
5. Vérifiez sur la page portfolio que les images s'affichent

---

## 🔗 Images de Test Disponibles

```
Fichier: test-image-1783002024.png
Localisation: storage/app/public/posts/test-image-1783002024.png
URL directe: /storage/posts/test-image-1783002024.png
URL route: /media-storage/posts/test-image-1783002024.png
```

---

## 📊 Statuts Attendus

| Test | Statut | URL |
|------|--------|-----|
| Page de test | ✓ Visible | `/TEST_IMAGES.html` |
| Dashboard diagnostic | ✓ Visible | `/admin/storage-diagnostics` |
| Symlink | ✓ Fonctionnel | `public/storage` |
| Image test | ✓ Affichée | `/storage/posts/...` |
| Upload nouvel article | ✓ Réussi | `/admin/posts/create` |
| Affichage image article | ✓ Fonctionne | `/articles/...` |

---

## 🚨 En Cas de Problème

### Image n'apparaît pas sur le site
1. Ouvrez la page diagnostic: `https://votresite.com/admin/storage-diagnostics`
2. Vérifiez que tous les éléments sont ✓
3. Si des ✗ rouges: contactez votre hébergeur

### Erreur 404 sur les images
1. Vérifiez que le symlink existe
2. Exécutez: `php artisan storage:verify`
3. Vérifiez les permissions: `chmod -R 755 storage/app/public`

### Erreur de upload
1. Vérifiez les permissions: `chmod -R 755 storage/app/public`
2. Vérifiez l'espace disque
3. Consultez les logs: `storage/logs/laravel.log`

---

## 📝 Fichiers Créés pour le Test

| Fichier | Purpose | URL/Accès |
|---------|---------|-----------|
| `TEST_STORAGE.php` | Diagnostic complet | `php TEST_STORAGE.php` |
| `TEST_UPLOAD.php` | Test d'upload | `php TEST_UPLOAD.php` |
| `CHECK.php` | Vérification rapide | `php CHECK.php` |
| `TEST_IMAGES.html` | Page de test | `/TEST_IMAGES.html` |
| `TEST_RESULTS.md` | Résumé des tests | `README` |
| `URLS_TEST.md` | Ce fichier | `README` |

**Ces fichiers peuvent être supprimés après vérification.**

---

## ✅ Checklist Finale

- [ ] Tous les dossiers existent
- [ ] Symlink fonctionne
- [ ] Page `/TEST_IMAGES.html` accessible
- [ ] Dashboard `/admin/storage-diagnostics` affiche ✓ partout
- [ ] Image test s'affiche
- [ ] Article créé avec image
- [ ] Image article s'affiche
- [ ] Portfolio avec images fonctionne
- [ ] Tout OK, supprimé les fichiers de test

**🎉 PRÊT POUR LA PRODUCTION!**
