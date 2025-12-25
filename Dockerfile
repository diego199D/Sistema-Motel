FROM php:8.2-apache
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip libzip-dev unzip git && docker-php-ext-install pdo_mysql gd zip
RUN a2enmod rewrite
COPY . /var/www/html
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --optimize-autoloader --no-dev
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
ENV PORT=80
EXPOSE 80
CMD php artisan migrate --force && apache2-foreground