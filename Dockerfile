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

# Configure Apache to serve .htm files as directory indexes
RUN echo "<Directory /var/www/html>" >> /etc/apache2/apache2.conf && \
    echo "    DirectoryIndex index.html index.htm index.php" >> /etc/apache2/apache2.conf && \
    echo "    Options -Indexes +FollowSymLinks" >> /etc/apache2/apache2.conf && \
    echo "    AllowOverride All" >> /etc/apache2/apache2.conf && \
    echo "    Require all granted" >> /etc/apache2/apache2.conf && \
    echo "</Directory>" >> /etc/apache2/apache2.conf

# Enable headers module for security headers
RUN a2enmod headers

# Copy files (maintain local structure)
COPY public/ /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Enable Apache modules
RUN a2enmod rewrite

# Configure PHP error handling and security settings
RUN echo "display_errors = Off" >> /usr/local/etc/php/conf.d/security.ini && \
    echo "log_errors = On" >> /usr/local/etc/php/conf.d/security.ini && \
    echo "error_log = /var/log/php_errors.log" >> /usr/local/etc/php/conf.d/security.ini && \
    echo "expose_php = Off" >> /usr/local/etc/php/conf.d/security.ini && \
    echo "allow_url_fopen = Off" >> /usr/local/etc/php/conf.d/security.ini && \
    echo "allow_url_include = Off" >> /usr/local/etc/php/conf.d/security.ini && \
    echo "max_execution_time = 30" >> /usr/local/etc/php/conf.d/security.ini && \
    echo "max_input_time = 30" >> /usr/local/etc/php/conf.d/security.ini && \
    echo "memory_limit = 128M" >> /usr/local/etc/php/conf.d/security.ini && \
    echo "post_max_size = 8M" >> /usr/local/etc/php/conf.d/security.ini && \
    echo "upload_max_filesize = 2M" >> /usr/local/etc/php/conf.d/security.ini

EXPOSE 80

