# Partimos de la imagen php en su versión 8.2.13
FROM php:8.2.13-fpm

# Copiamos los archivos package.json composer.json a /var/www/
COPY composer*.json /var/www/

# Copiamos el archivo de configuración supervisor
COPY ./docker-compose-config/supervisor/supervisord.conf /etc/supervisord/supervisord.conf

# Nos movemos a /var/www/
WORKDIR /var/www/

# Instalamos las dependencias necesarias
RUN apt-get update && apt-get install -y \
    build-essential \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    git \
    curl

# Instalamos extensiones de PHP y supervisor
RUN docker-php-ext-install pdo_mysql zip exif pcntl bcmath \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && apt-get update \
    && apt-get install -y --no-install-recommends supervisor

# Instalamos composer
COPY --from=composer:2.6.6 /usr/bin/composer /usr/bin/composer

# Instalamos dependendencias de composer
RUN composer install --no-ansi --no-interaction --no-progress --optimize-autoloader --no-scripts

# Copiamos todos los archivos de la carpeta actual de nuestra 
# computadora (los archivos de laravel) a /var/www/
COPY . .

RUN composer dump-autoload -o

# Exponemos el puerto 9000 a la network
EXPOSE 9000

# Corremos el comando php-fpm para ejecutar PHP
CMD ["supervisord", "-c", "/etc/supervisord/supervisord.conf"]