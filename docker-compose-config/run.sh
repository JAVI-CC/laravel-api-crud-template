#!/bin/sh

php /var/www/artisan migrate
php /var/www/artisan db:seed
php /var/www/artisan test