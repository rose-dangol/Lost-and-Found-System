# Use official PHP with Apache image
FROM php:8.2-apache

# Copy all project files to Apache's web directory
COPY . /var/www/html/

# Give proper permissions (optional but safe)
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 for the web
EXPOSE 80
