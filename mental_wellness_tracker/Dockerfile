# Use the official PHP image
FROM php:7.4-apache

# Install PHP extensions
RUN docker-php-ext-install mysqli

# Install msmtp for email sending
RUN apt-get update && apt-get install -y msmtp msmtp-mta

# Copy the source files to the Apache document root
COPY src/ /var/www/html/

# Copy msmtp configuration file to the container
COPY msmtprc /etc/msmtprc
RUN chmod 600 /etc/msmtprc

# Configure PHP to use msmtp for email sending
RUN echo "sendmail_path = /usr/bin/msmtp -t" >> /usr/local/etc/php/conf.d/sendmail.ini

# Expose port 80 for Apache
EXPOSE 80
