FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql mysqli

# Si estamos en la raíz, copia backend/
# Si estamos dentro de backend, copia todo
COPY backend/ /var/www/html/
COPY . /var/www/html/

RUN a2enmod rewrite
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
