#!/bin/sh

composer dump-autoload -o
chmod -R 777 ./storage ./bootstrap/cache
php /var/www/artisan migrate
php /var/www/artisan db:seed
php /var/www/artisan test