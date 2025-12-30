FROM php:8.3-fpm

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY php.ini /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www/html
