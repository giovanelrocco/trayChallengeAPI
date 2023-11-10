#!/usr/bin/env bash
echo "Running composer"

echo "Buscando arquivo .env"
if test -f .env; then
    echo "Lendo arquivo .env"
    source .env
elif test -f /etc/secrets/.env; then
    echo "Lendo arquivo /etc/secrets/.env"
    source /etc/secrets/.env
fi

source /etc/secrets/.env

echo "${APP_NAME} ${APP_ENV}"

if [ ${APP_ENV} = 'production' ]; then
    echo 'Configurando Deploy Producao'
    composer install --no-dev --working-dir=/var/www/html
    composer update --no-dev --working-dir=/var/www/html
    cp /etc/secrets/.env .env
else
    echo 'Configurando Deploy local'
    composer install
    composer update
fi
git 
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