FROM php:8.2-fpm

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Install Node.js for auto-refresh
RUN apt-get update && apt-get install -y curl git \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm

# Set working directory
WORKDIR /var/www/html
