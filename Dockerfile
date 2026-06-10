FROM php:8.2-apache

# 1. Install dependensi sistem dan extension PHP untuk SQLite
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_sqlite bcmath

# 2. Aktifkan module Apache Rewrite (penting untuk routing Laravel)
RUN a2enmod rewrite

# 3. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Set directory kerja
WORKDIR /var/www/html

# 5. Salin semua file proyek ke dalam container
COPY . .

# 6. Atur kepemilikan folder storage & cache agar bisa ditulis oleh web server
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 7. Install dependensi composer (tanpa dev tools untuk produksi)
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader

# 8. Konfigurasi Document Root Apache agar mengarah ke folder /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 9. Buat file database SQLite kosong di dalam container & beri hak akses
RUN touch /var/www/html/database/database.sqlite && chown www-data:www-data /var/www/html/database/database.sqlite

# 10. Lakukan caching Laravel untuk optimasi
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# 11. Expose port 80
EXPOSE 80

# 12. Jalankan migrasi database, seeding, lalu nyalakan Apache saat container mulai berjalan
CMD php artisan migrate --force && php artisan db:seed --force && apache2-foreground
