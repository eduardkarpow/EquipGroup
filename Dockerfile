FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    nodejs \
    npm \
    git \
    build-base \
    autoconf \
    libzip-dev \
    libpng-dev \
    jpeg-dev \
    freetype-dev \
    libwebp-dev \
    libjpeg-turbo-dev \
    mariadb-client \
    icu-dev \
    oniguruma-dev

RUN docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    zip \
    gd \
    exif \
    bcmath \
    opcache \
    pcntl \
    mbstring \
    intl

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN chmod +x /usr/local/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

COPY . .

RUN chown -R www-data:www-data /var/www/html/storage \
    /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage \
    /var/www/html/bootstrap/cache

EXPOSE 9000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]