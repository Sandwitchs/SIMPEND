# Dockerfile untuk SIMPEND PHP Native
FROM php:8.2-apache

# Install ekstensi mysqli & pdo_mysql
RUN docker-php-ext-install mysqli pdo_mysql

# Aktifkan mod_rewrite Apache & pastikan hanya satu MPM
RUN a2enmod rewrite && \
    a2dismod mpm_event && \
    a2enmod mpm_prefork

# Salin semua file ke direktori web Apache
COPY . /var/www/html/

# Ubah owner & izin agar Apache bisa baca
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Ganti port Apache ke 8080 (sesuai Railway)
RUN sed -i 's/80/8080/g' /etc/apache2/sites-available/000-default.conf && \
    sed -i 's/80/8080/g' /etc/apache2/ports.conf

