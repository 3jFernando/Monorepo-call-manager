FROM php:8.4-fpm

# Dependencias del sistema y extensione
RUN apt-get update && apt-get install -y git curl libpng-dev libonig-dev libxml2-dev libpq-dev zip unzip

# Limpiar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Extensiones para Postgres y Pdo
RUN docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd

RUN pecl install redis && docker-php-ext-enable redis

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www/html

# Puerto
EXPOSE 8000