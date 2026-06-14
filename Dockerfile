# Dockerfile untuk SIMPEND: PHP-FPM + Nginx + Supervisord
FROM php:8.2-fpm

# Install ekstensi PHP yang dibutuhkan
RUN docker-php-ext-install mysqli pdo_mysql

# Install Nginx & Supervisor
RUN apt-get update && apt-get install -y nginx supervisor && rm -rf /var/lib/apt/lists/*

# Konfigurasi Nginx
COPY nginx.conf /etc/nginx/sites-available/default
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Konfigurasi Supervisor
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Salin semua file proyek ke direktori web
COPY . /var/www/html/

# Atur izin file
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Port yang digunakan
EXPOSE 8080

# Jalankan Supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

