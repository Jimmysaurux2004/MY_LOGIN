FROM php:8.2-apache

# Instalar extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copiar archivos al contenedor
COPY . /var/www/html/

# Habilitar mod_rewrite (opcional para APIs limpias)
RUN a2enmod rewrite
