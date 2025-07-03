# Использование официального образа PHP с FPM
FROM php:8.3-fpm-alpine

# Установка системных зависимостей и PHP-расширений, необходимых для Laravel
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
    # Добавьте mariadb-client для MySQL/MariaDB
    mariadb-client \
    icu-dev \
    oniguruma-dev

# Установка PHP-расширений
# Убедитесь, что список соответствует зависимостям вашего Laravel проекта
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

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Установка прав для Composer
RUN chmod +x /usr/local/bin/composer

# Установка рабочего каталога внутри контейнера
WORKDIR /var/www/html

# Копирование файлов приложения
# Мы копируем composer.json и composer.lock отдельно, чтобы кэшировать слои Composer
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Копирование всего остального кода приложения
COPY . .

# Генерация ключа приложения Laravel (если еще не сгенерирован)
# Важно: В продакшене ключ должен быть установлен через .env или переменные окружения,
# а не генерироваться при сборке образа.
# RUN php artisan key:generate

# Установка прав на директории Laravel
RUN chown -R www-data:www-data /var/www/html/storage \
    /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage \
    /var/www/html/bootstrap/cache

# Открытие порта для PHP-FPM (обычно 9000)
EXPOSE 9000

# Команда запуска PHP-FPM
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]