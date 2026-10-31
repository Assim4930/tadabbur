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
    libsqlite3-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pdo_sqlite \
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

# Prepare Laravel directories, fallback SQLite file, and dependencies
RUN cp -n .env.example .env || true \
    && mkdir -p \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache/data \
    storage/logs \
    bootstrap/cache \
    database \
    && touch database/database.sqlite \
    && composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --ignore-platform-reqs \
    && chmod -R 775 storage bootstrap/cache database

EXPOSE 10000

# Start Laravel ( Automatically fallback to sqlite if DB_URL is not set for pgsql, and generate APP_KEY if missing )
CMD ["sh", "-c", "if [ -z \"$APP_KEY\" ]; then php artisan key:generate --force; fi && if [ \"$DB_CONNECTION\" = \"pgsql\" ] && [ -z \"$DB_URL\" ] && [ -z \"$DB_HOST\" ]; then export DB_CONNECTION=sqlite; fi && php artisan config:clear && php artisan migrate --force && exec php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"]
