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

# Copiar los archivos de la aplicación
COPY . /var/www/html/

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html && \
    chmod 644 /var/www/html/.htaccess 2>/dev/null || echo "No se encontró .htaccess, continuando..."

# Configurar el directorio de carga de archivos
RUN mkdir -p /var/www/html/uploads && \
    chown -R www-data:www-data /var/www/html/uploads && \
    chmod -R 755 /var/www/html/uploads

# Configurar el archivo de configuración de Apache
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf
RUN chmod 644 /etc/apache2/sites-available/000-default.conf

# Variables de entorno para la base de datos
ENV DB_HOST=dpg-d4om0ui4d50c73909keg-a
ENV DB_PORT=5432
ENV DB_NAME=everlia
ENV DB_USER=everlia_user
