# Use the official PHP image
FROM php:7.4-apache

# Install PHP extensions
RUN docker-php-ext-install mysqli

# Copy the source files to the Apache document root
COPY src/ /var/www/html/

# Expose port 80 for Apache
EXPOSE 80
