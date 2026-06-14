# Dockerfile untuk SIMPEND PHP Native (Paling Sederhana!)
FROM php:8.2-apache

# Install ekstensi mysqli & pdo_mysql
RUN docker-php-ext-install mysqli pdo_mysql && a2enmod rewrite

# Ganti port Apache ke 8080 (sesuai Railway)
RUN sed -i 's/Listen 80/Listen 8080/g' /etc/apache2/ports.conf && \
    sed -i 's/<VirtualHost *:80>/<VirtualHost *:8080>/g' /etc/apache2/sites-available/000-default.conf

# Salin semua file ke direktori web Apache
COPY . /var/www/html/

# Ubah owner & izin
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

