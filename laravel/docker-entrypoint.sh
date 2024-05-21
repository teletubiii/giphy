#!/bin/sh
composer install --no-interaction --optimize-autoloader
php artisan migrate:fresh
php artisan passport:client --personal
php artisan passport:keys
chown -R www-data:www-data storage bootstrap/cache
apachectl -D FOREGROUND
exec "$@"

