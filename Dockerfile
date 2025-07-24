# ✅ Imagen base PHP con Apache
FROM php:8.2-apache

# ✅ Instalar extensiones necesarias para MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# ✅ Copiar SOLO el backend al contenedor
WORKDIR /var/www/html
COPY backend/ . 

# ✅ Activar mod_rewrite para URLs amigables
RUN a2enmod rewrite

# ✅ Configuración recomendada de Apache para evitar problemas
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# ✅ Exponer el puerto 80 (Railway espera que sea este)
EXPOSE 80

# ✅ Comando de inicio
CMD ["apache2-foreground"]
