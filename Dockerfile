# Use official PHP with Apache
FROM php:8.2-apache

# Copy project files to Apache's web directory
COPY . /var/www/html/

# Make sure Apache can read and execute files
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Enable Apache rewrite module (optional, useful for URLs)
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80
