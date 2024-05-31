# Utiliser une image PHP avec Apache et Composer
FROM php:8.1-fpm

# Installer les extensions nécessaires et Composer
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd mysqli pdo pdo_mysql zip

# Install Composer
RUN apt-get install -y zip unzip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Copy composer.json and composer.lock
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-scripts --no-autoloader
# Copy the rest of the application
COPY . .

# Generate optimized autoload files
RUN composer dump-autoload --optimize

# Expose port 8000 and start php-fpm server
EXPOSE 8080

CMD ["/usr/local/bin/symfony", "local:server:start" , "--port=8080", "--no-tls"]


