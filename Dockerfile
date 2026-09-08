FROM php:8.1-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Enable Apache mod_rewrite if needed by the app
RUN a2enmod rewrite

# Restart Apache (handled by the base image)
