# Imagen oficial de PHP 8.2 con soporte CLI
FROM php:8.2-cli

# Instalar dependencias del sistema necesarias para Laravel, DomPDF, QR y ZIP
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer 2
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Definir directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Copiar todos los archivos del proyecto
COPY . .

# Instalar dependencias de Laravel para producción
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Crear carpetas necesarias de almacenamiento y asignar permisos
RUN mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Exponer el puerto dinámico de Render y arrancar Laravel
CMD php artisan storage:link || true && php -S 0.0.0.0:${PORT:-8000} -t public