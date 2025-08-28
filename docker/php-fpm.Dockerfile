FROM php:8.3-fpm
RUN apt-get update && apt-get install -y git curl libzip-dev unzip libonig-dev libxml2-dev libpng-dev     && docker-php-ext-install pdo pdo_mysql zip     && pecl install redis     && docker-php-ext-enable redis     && rm -rf /var/lib/apt/lists/*
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
RUN composer create-project laravel/laravel . --no-interaction --prefer-dist
RUN composer require guzzlehttp/guzzle:^7.9 symfony/dom-crawler:^7.0 symfony/css-selector:^7.0 --no-interaction
RUN chown -R www-data:www-data /var/www/html && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
EXPOSE 9000
CMD ["php-fpm"]
