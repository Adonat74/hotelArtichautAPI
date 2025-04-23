#!/bin/sh

dos2unix /usr/local/bin/entrypoint.sh


chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache


php artisan config:cache
php artisan route:cache
php artisan view:cache || true

exec docker-php-entrypoint php-fpm
