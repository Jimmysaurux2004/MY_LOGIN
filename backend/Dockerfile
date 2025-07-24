FROM php:8.2-apache

# Instalar extensiones necesarias para MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# ✅ Copiamos SOLO el backend como raíz del servidor web
COPY backend/ /var/www/html/

# ✅ Habilitamos mod_rewrite (por si usas URLs amigables)
RUN a2enmod rewrite

# ✅ Evitamos warning de ServerName
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
