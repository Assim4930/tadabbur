
# Stage 1: Build frontend assets
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY . .
RUN npm run build


# Stage 2: Laravel / PHP
FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install \
    pdo_pgsql \
    mbstring \
    bcmath \
    xml \
    dom \
    zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy Laravel application
COPY . .

# Copy compiled frontend
COPY --from=frontend /app/public/build ./public/build

# Prepare Laravel directories and dependencies
RUN mkdir -p \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache/data \
    storage/logs \
    bootstrap/cache \
    && composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 10000

# Start Laravel
CMD ["sh", "-c", "php artisan migrate --force && php artisan config:cache && exec php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"]
