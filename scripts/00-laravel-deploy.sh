#!/usr/bin/env bash
echo "Running composer"

source .env

if [ ${APP_ENV} = 'local' ]; then
    echo 'Configurando Deploy local'
    composer install
    composer update
else
    echo 'Configurando Deploy Producao'
    composer install --no-dev --working-dir=/var/www/html
    composer update --no-dev --working-dir=/var/www/html
fi

echo "Generate Key"
php artisan key:generate

echo "Clearing caches..."
php artisan optimize:clear

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force

echo "done deploying"