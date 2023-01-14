#!/bin/sh
# general good practice (stop on error):
set -e

if [ "${1#-}" != "$1" ]; then
set -- php-fpm "$@"
fi
cp .env.example .env
#Call composer with the updated arguments.
if [ "$1" = 'php-fpm' ] || [ "$1" = 'php artisan' ]; then
    if [ ! -d "./vendor" ]; then
        composer install --prefer-dist --no-progress --no-suggest --no-interaction --optimize-autoloader
    fi
    php artisan migrate
fi

exec "$@"
