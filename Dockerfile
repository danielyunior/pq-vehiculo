# Usar PHP 8.4 para cumplir con los requisitos de tus dependencias
FROM php:8.4-cli

# Instalar dependencias del sistema y extensiones necesarias para Laravel, DomPDF, QR y ZIP
RUN apt-get update && apt-get install -y \
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

# Definir directorio de trabajo
WORKDIR /var/www/html

# Copiar todos los archivos del proyecto (incluyendo vendor)
COPY . .

# Crear carpetas de almacenamiento y asignar permisos
RUN mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Arrancar el servidor web en el puerto de Render apuntando a public
CMD php -S 0.0.0.0:${PORT:-8000} -t public