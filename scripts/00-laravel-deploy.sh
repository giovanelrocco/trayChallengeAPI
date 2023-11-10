#!/usr/bin/env bash
echo "Running composer"

# Para rodar em produção
# composer install --no-dev --working-dir=/var/www/html
# composer update --no-dev --working-dir=/var/www/html

composer install
composer update

echo "Clearing caches..."
php artisan optimize:clear

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force

# echo "Running seeder..."
# php artisan db:seed --force --no-interaction

echo "done deploying"