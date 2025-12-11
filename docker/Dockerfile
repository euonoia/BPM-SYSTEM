# Base image with PHP-FPM
FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory inside the container
WORKDIR /var/www

# Copy application files first (optimized layer cache)
COPY . .

# Install Laravel backend dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Install frontend dependencies
RUN npm install && npm run build

# Permissions fix for storage & cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose port (Laravel dev server)
EXPOSE 8000
