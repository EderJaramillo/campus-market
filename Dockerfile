# Usa una imagen oficial de PHP con Apache
FROM php:8.2-apache

# Habilita mod_rewrite si usas rutas amigables
RUN a2enmod rewrite

# Copia el contenido de tu proyecto al contenedor
COPY . /var/www/html/

# Da permisos al contenido (opcional si hay errores de permisos)
RUN chown -R www-data:www-data /var/www/html

# Expone el puerto 80 (Render lo detecta automáticamente)
EXPOSE 80
