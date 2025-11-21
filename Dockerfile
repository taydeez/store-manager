# Stage 1: Build dependencies
FROM php:8.3-fpm-alpine AS build

RUN apk add --no-cache \
    autoconf gcc g++ make bash \
    libpng-dev oniguruma-dev libzip-dev \
    zip unzip curl git icu-dev zlib-dev mariadb-client

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql bcmath gd zip opcache intl

RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy full app BEFORE composer
COPY . .

RUN composer install --prefer-dist --optimize-autoloader

# DO NOT RUN ANY ARTISAN OPTIMIZE COMMANDS HERE
# Cloud Run needs dynamic env loading


# -----------------------------
# Stage 2: Production image
# -----------------------------
FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    nginx bash mariadb-client \
    libpng-dev oniguruma-dev libzip-dev \
    zip unzip icu-dev zlib-dev curl git

COPY --from=build /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=build /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/
COPY --from=build /usr/bin/composer /usr/bin/composer
COPY --from=build /app/vendor /app/vendor

WORKDIR /app

COPY . .

COPY docker/nginx/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/php/php_dev.ini /usr/local/etc/php/conf.d/custom.ini

RUN chown -R www-data:www-data storage bootstrap/cache

# DO NOT CACHE ROUTES OR CONFIG OR VIEWS
# Cloud Run injects env vars — caching breaks everything

EXPOSE 8080

CMD ["sh", "-c", "php-fpm -F & nginx -g 'daemon off;'"]
