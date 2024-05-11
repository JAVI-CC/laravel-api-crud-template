#!/bin/sh

php /var/www/artisan key:generate
php /var/www/artisan storage:link
php /var/www/artisan migrate
php /var/www/artisan db:seed
php /var/www/artisan test