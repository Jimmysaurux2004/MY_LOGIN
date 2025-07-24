# ✅ Imagen base PHP con Apache
FROM php:8.2-apache

# ✅ Instalar extensiones necesarias para MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# ✅ Establecer el directorio de trabajo en Apache
WORKDIR /var/www/html

# ✅ Copiar TODO el backend (ahora incluye api y utils)
COPY backend/ .

# ✅ Activar mod_rewrite para URLs amigables
RUN a2enmod rewrite

# ✅ Evitar warning de ServerName
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# ✅ Exponer el puerto 80 (Railway siempre usa 80)
EXPOSE 80

# ✅ Comando para iniciar Apache en foreground
CMD ["apache2-foreground"]
