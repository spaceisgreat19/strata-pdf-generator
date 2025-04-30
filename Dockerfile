# Use an official PHP runtime as a parent image
FROM php:8.0-apache

# Set the working directory in the container
WORKDIR /var/www/html

# Install necessary PHP extensions (if any, such as for PDF generation)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Copy the current directory contents into the container at /var/www/html
COPY . /var/www/html/

# Install Composer for managing PHP dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install the PHP dependencies using Composer (if you have a composer.json)
RUN composer install --no-dev --optimize-autoloader

# Expose port 80 to the outside world
EXPOSE 80

# Start the Apache server when the container runs
CMD ["apache2-foreground"]