FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    unzip \
    wget \
    git \
    curl \
    libzip-dev \
    && docker-php-ext-install zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json ./

RUN composer clear-cache && \
    composer install --no-dev --optimize-autoloader --no-progress --no-interaction || \
    composer install --no-dev --optimize-autoloader --no-progress --no-interaction

COPY . .

RUN a2enmod rewrite

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80