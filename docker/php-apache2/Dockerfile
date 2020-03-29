# Base image
FROM php:7.3-apache

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Run apt update and install some dependancies needed for docker-php-ext
RUN apt-get update && apt-get install -y apt-utils
RUN apt-get update && apt-get install -y mariadb-client
RUN apt-get update && apt-get install -y pngquant
RUN apt-get update && apt-get install -y unzip
RUN apt-get update && apt-get install -y zip
RUN apt-get update && apt-get install -y libpng-dev
RUN apt-get update && apt-get install -y libmcrypt-dev
RUN apt-get update && apt-get install -y libicu-dev
RUN apt-get update && apt-get install -y libxml2-dev
RUN apt-get update && apt-get install -y libssl-dev
RUN apt-get update && apt-get install -y libcurl3-dev
RUN apt-get update && apt-get install -y libsqlite3-dev
RUN apt-get update && apt-get install -y libsqlite3-0
RUN apt-get update && apt-get install -y libzip-dev


# Install PHP extensions
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install gd intl
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip
RUN docker-php-ext-install opcache

# Update web root to public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable mod_rewrite
RUN a2enmod rewrite