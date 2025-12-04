# Usar la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# Habilitar módulos de Apache necesarios
RUN a2enmod rewrite headers

# Configurar el directorio de trabajo
WORKDIR /var/www/html

# Crear directorio de la aplicación
RUN mkdir -p /var/www/html/DWES_P3_LUCIAI

# Copiar los archivos de la aplicación
COPY . /var/www/html/DWES_P3_LUCIAI/

# Configurar el directorio de carga de archivos
RUN mkdir -p /var/www/html/DWES_P3_LUCIAI/uploads \
    && chown -R www-data:www-data /var/www/html/DWES_P3_LUCIAI \
    && chmod -R 755 /var/www/html/DWES_P3_LUCIAI

# Configurar el archivo de configuración de Apache
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf

# Variables de entorno para la base de datos
ENV DB_HOST=dpg-d4om0ui4d50c73909keg-a
ENV DB_PORT=5432
ENV DB_NAME=everlia
ENV DB_USER=everlia_user
ENV DB_PASSWORD=2mIbsUXJxMFFSIc15ZAbphqlC6Z4wX0c

# Exponer el puerto 80
EXPOSE 80

# Comando de inicio
CMD ["apache2-foreground"]
