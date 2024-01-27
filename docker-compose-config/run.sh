#!/bin/sh

chmod -R 777 /var/www/storage
php /var/www/artisan key:generate
php /var/www/artisan storage:link
php /var/www/artisan migrate
php /var/www/artisan db:seed
php /var/www/artisan test
chmod -R 777 /var/www/storage/app/user-avatars