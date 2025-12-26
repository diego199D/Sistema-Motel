FROM php:8.2-apache

# Instalación de extensiones necesarias
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip libzip-dev unzip git && docker-php-ext-install pdo_mysql gd zip
RUN a2enmod rewrite

# Configuración de Apache para Laravel (Solución CSS y Error 403)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

COPY . /var/www/html
WORKDIR /var/www/html

# Instalación de dependencias de PHP
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --optimize-autoloader

# Permisos de carpetas
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

ENV PORT=80
EXPOSE 80

# Comando final: Migraciones (se ejecutan al iniciar el contenedor con red activa)
CMD php artisan migrate --force && apache2-foreground
 