#!/bin/sh

chmod -R 777 /var/www/storage /var/www/bootstrap/cache
php /var/www/artisan migrate
php /var/www/artisan db:seed
php /var/www/artisan test