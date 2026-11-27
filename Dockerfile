FROM php:8.3-cli

# Instalar dependencias del sistema y extensiones PHP habituales en Laravel
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
    libicu-dev \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip intl opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer 2
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar archivos del proyecto
COPY . .

# Crear carpetas necesarias y permisos
RUN mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Instalar dependencias sin ejecutar scripts que requieren .env durante el build
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Al arrancar: descubrir paquetes, enlazar storage y levantar servidor web
CMD php artisan package:discover --ansi && php artisan storage:link || true && php -S 0.0.0.0:${PORT:-8000} -t public