FROM php:8.1-fpm-alpine
RUN docker-php-ext-install mysqli pdo_mysql
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
