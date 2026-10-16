#!/bin/bash
PORT=${PORT:-8080}
sed -i "s/__PORT__/$PORT/" /etc/nginx/sites-available/default
php artisan migrate --force
php-fpm -D
nginx -g "daemon off;"
