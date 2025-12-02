#!/bin/sh

cp .env.example .env

composer install --optimize-autoloader --ignore-platform-reqs

php artisan sail:install

php artisan key:generate

php artisan storage:unlink

php artisan storage:link

./vendor/bin/sail up -d
