# Usa la imagen oficial de PHP con Apache
FROM php:8.1-apache

# Instala las extensiones necesarias y las herramientas faltantes
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql zip \
    && docker-php-ext-enable mysqli

# Habilita el módulo rewrite de Apache
RUN a2enmod rewrite

# Copia el código de la aplicación
COPY public/ /var/www/html/
COPY src/ /var/www/src/
COPY config/php.ini /usr/local/etc/php/php.ini
COPY composer.json /var/www/
COPY composer.lock /var/www/

# Crear el directorio de caché y asignar permisos
RUN mkdir -p /var/www/cache && chmod -R 777 /var/www/cache

# Instala Composer
WORKDIR /var/www
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Permite la ejecución de Composer como superusuario y luego instala las dependencias
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install
