# Dockerfile untuk SIMPEND PHP Native (PHP-FPM + Nginx + Supervisord)
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache nginx supervisor curl

# Install ekstensi PHP yang dibutuhkan
RUN docker-php-ext-install mysqli pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Salin semua file proyek (PHP Native)
COPY . /var/www/html

# Copy Nginx config
COPY nginx.conf /etc/nginx/nginx.conf

# Copy supervisor config
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Atur izin file
RUN chown -R nobody:nobody /var/www/html && chmod -R 755 /var/www/html

# Expose port
EXPOSE 8080

# Start supervisord as PID 1
ENTRYPOINT ["/usr/bin/supervisord"]
CMD ["-c", "/etc/supervisor/conf.d/supervisord.conf"]

