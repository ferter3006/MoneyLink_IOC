FROM php:8.2-apache

# Argumentos para UID y GID
ARG UID=1000
ARG GID=1000

# Crear grupo y usuario con los IDs proporcionados
RUN groupadd -g ${GID} appuser \
    && useradd -u ${UID} -g appuser -m appuser

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    libzip-dev \
    autoconf \
    build-essential \
    && docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# Install PECL redis extension (phpredis)
RUN pecl install redis && docker-php-ext-enable redis

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer el directorio de trabajo
WORKDIR /var/www/html



# Copiar los archivos del proyecto y cambiar propietario
COPY . /var/www/html
RUN chown -R appuser:appuser /var/www/html

# Instalar dependencias de PHP como root
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Configurar permisos
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar configuración personalizada de Apache
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Cambiar a usuario appuser para ejecutar Apache
USER appuser

# Exponer el puerto 80
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"]
