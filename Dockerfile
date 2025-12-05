FROM php:8.2-apache

# Install system dependencies required for PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zlib1g-dev \
    libwebp-dev \
    && rm -rf /var/lib/apt/lists/*

# Install required PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install mysqli pdo pdo_mysql gd

# Suppress Apache warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy files (maintain local structure)
COPY public/ /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Enable Apache modules
RUN a2enmod rewrite

# Configure PHP error handling (security)
RUN echo "display_errors = Off" >> /usr/local/etc/php/conf.d/error-handling.ini && \
    echo "log_errors = On" >> /usr/local/etc/php/conf.d/error-handling.ini && \
    echo "error_log = /var/log/php_errors.log" >> /usr/local/etc/php/conf.d/error-handling.ini

EXPOSE 80

