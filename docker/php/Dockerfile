FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    git zip unzip libzip-dev libonig-dev

RUN docker-php-ext-install pdo_mysql zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY php.ini /usr/local/etc/php/