FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    cron \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN crontab -l | { cat; echo "30 8 * * * /bin/bash -c 'cd /var/www/html && /usr/local/bin/php artisan schedule:run > /var/log/cron.log 2>&1'";} | crontab -

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD cron && docker-php-entrypoint php-fpm
