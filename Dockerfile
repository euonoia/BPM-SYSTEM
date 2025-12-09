# ==============================
# Stage 0: PHP + system deps
# ==============================
FROM php:8.4-fpm

# Arguments for non-root user
ARG UID=1000
ARG GID=1000

# Set working directory
WORKDIR /var/www

# Install system dependencies + Node.js + Yarn + PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip zip libpng-dev libonig-dev libxml2-dev curl vim sudo gnupg \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install --global yarn \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Create non-root user
RUN groupadd -g $GID laravel \
    && useradd -u $UID -ms /bin/bash -g laravel laravel \
    && chown -R laravel:laravel /var/www

# Switch to non-root user
USER laravel

# Expose ports for Laravel and Vite (hot reload)
EXPOSE 8000 5173

# Start command: Laravel dev server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
