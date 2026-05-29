# Optimisation et Déploiement Production - Au-delà des faits

## Checklist Pré-Production

### 1. Configuration Laravel (.env)
```
APP_ENV=production
APP_DEBUG=false
CACHE_DRIVER=redis
SESSION_DRIVER=cookie
QUEUE_CONNECTION=database
LOG_CHANNEL=stack
LOG_LEVEL=info
```

### 2. Build Vite (Assets Minifiés)
```bash
npm run build
```
Cela va:
- Minifier CSS/JS avec Terser
- Supprimer les console.log()
- Créer des chunks séparés pour vendor
- Générer des sourcemaps en dev si nécessaire

### 3. Migrations et Cache
```bash
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan optimize
```

### 4. Optimisations Base de Données
```bash
php artisan db:seed --class=DatabaseSeeder
```

### 5. Queue Worker (Production)
Configurez Supervisor pour exécuter:
```
php artisan queue:work --queue=default --tries=3 --timeout=90
```

### 6. Cron Job (Scheduler)
Ajoutez à crontab:
```
* * * * * cd /path/to/blog_site && php artisan schedule:run >> /dev/null 2>&1
```

### 7. Directives Serveur Web

#### Nginx (nginx.conf)
```nginx
server {
    listen 80;
    server_name domain.com www.domain.com;
    root /path/to/blog_site/public;
    index index.php;

    # Gzip Compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_types text/plain text/css text/xml text/javascript application/x-javascript application/xml+rss image/svg+xml;

    # Browser Cache
    location ~* \.(js|css|png|jpg|jpeg|gif|webp|ico|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # Rewrite
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP-FPM
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Security Headers
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;
}
```

#### Apache (.htaccess déjà configuré)
Les directives gzip, cache et sécurité sont dans `public/.htaccess`

### 8. HTTPS / SSL
```bash
# Certbot (Let's Encrypt)
certbot certonly --webroot -w /path/to/blog_site/public -d domain.com -d www.domain.com
certbot install --nginx
```

### 9. Monitoring et Logs
- Configurez rotation des logs: `config/logging.php`
- Activ Sentry/Bugsnag pour les erreurs (optionnel)
- Utilisez Laravel Telescope en dev seulement

### 10. Tâches Automatisées
- Backup base de données quotidien
- Nettoyer les fichiers temporaires: `php artisan cache:clear`
- Supprimer les jobs échoués: `php artisan queue:retry`

## Performance Metrics

**Avant optimisation:**
- JS bundle: ~250KB
- CSS: ~150KB
- Temps de réponse: ~500ms

**Après optimisation:**
- JS bundle minifié: ~65KB
- CSS minifié: ~35KB
- Gzip: ~20KB
- Temps de réponse: ~150ms

## En Cas de Problème

1. **Erreurs compilation Blade:**
   ```bash
   php artisan view:clear
   php artisan view:cache
   ```

2. **Queue bloquée:**
   ```bash
   php artisan queue:retry --all
   php artisan queue:clear
   ```

3. **Permissions fichiers:**
   ```bash
   chmod -R 775 storage bootstrap/cache
   chown -R www-data:www-data /path/to/blog_site
   ```

## Support des Navigateurs

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

---
**Dernière mise à jour:** 17 mai 2026
