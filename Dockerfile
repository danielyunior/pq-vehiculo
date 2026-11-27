FROM php:8.4-cli

WORKDIR /var/www/html

# Instalar dependencias del sistema y extensiones PHP necesarias para Laravel + MySQL
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copiar el código del proyecto (incluyendo vendor si está versionado)
COPY . /var/www/html

# Asegurar carpetas y permisos de escritura para Laravel
RUN mkdir -p storage/framework/sessions \
             storage/framework/views \
             storage/framework/cache \
             storage/logs \
             bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

# Exponer puerto (Render asigna PORT dinámicamente)
EXPOSE 8080

# Arrancar el servidor PHP apuntando a public/ y usando el PORT de Render
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8080} -t public"]