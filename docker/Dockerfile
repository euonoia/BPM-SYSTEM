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

# Install Yarn globally
RUN npm install -g yarn

# Set working directory
WORKDIR /var/www

# Expose port (Laravel dev server)
EXPOSE 8000
