FROM php:8.2-apache

# Instalar extensiones necesarias para MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copiar SOLO el backend como raíz del servidor
COPY backend/ /var/www/html/

# Habilitar mod_rewrite para URLs limpias
RUN a2enmod rewrite

# Opcional: agregar un ServerName para evitar warnings
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
