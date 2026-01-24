FROM php:8.3-fpm-alpine

# =========================
# System dependencies
# =========================
RUN apk add --no-cache \
    nginx \
    supervisor \
    bash \
    curl \
    git \
    unzip \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    zlib-dev \
    postgresql-dev \
    mariadb-dev \
    redis \
    $PHPIZE_DEPS

# =========================
# PHP extensions
# =========================
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    bcmath \
    intl \
    zip \
    opcache \
    pcntl \
    posix \
    fileinfo \
    && pecl install redis \
    && docker-php-ext-enable redis

# =========================
# Composer
# =========================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# =========================
# Working directory
# =========================
WORKDIR /var/www/html

# =========================
# Copy application source
# =========================
COPY . .

# =========================
# Install PHP dependencies
# =========================
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# Ensure no cached config is baked in
RUN rm -f bootstrap/cache/config.php

# =========================
# Laravel runtime directories
# =========================
RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

# Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 storage bootstrap/cache

# =========================
# PHP configuration
# =========================
COPY docker/php-fpm/uploads.ini /usr/local/etc/php/conf.d/uploads.ini

# =========================
# PHP-FPM configuration
# =========================
COPY docker/php-fpm/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY docker/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf

# =========================
# PHP-FPM log directories
# =========================
RUN mkdir -p /var/log/php-fpm \
    && touch /var/log/php-fpm/error.log /var/log/php-fpm/access.log \
    && chown -R www-data:www-data /var/log/php-fpm \
    && chmod -R 755 /var/log/php-fpm

# =========================
# Nginx config
# =========================
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# =========================
# Supervisor config
# =========================
COPY docker/supervisor/supervisord.conf /etc/supervisord.conf

# =========================
# Expose port
# =========================
EXPOSE 8080

# =========================
# Entrypoint
# =========================
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["sh", "/entrypoint.sh"]

# =========================
# Start services
# =========================
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
