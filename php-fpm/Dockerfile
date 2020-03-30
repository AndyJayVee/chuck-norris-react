FROM php:7.3-fpm


ENV DEBIAN_FRONTEND noninteractive

# Install PHP extensions and PECL modules.
#ADD assets/locale.gen /etc/locale.gen
RUN apt-get update && apt-get install -y --no-install-recommends apt-utils
RUN buildDeps=" \
        apt-utils \
        libbz2-dev \
        default-libmysqlclient-dev \
        locales \
    " \
    runtimeDeps=" \
        curl \
        git \
        libfreetype6-dev \
        libicu-dev \
        libjpeg-dev \
        libmcrypt-dev \
        libpng-dev \
        libpq-dev \
        libexif-dev \
        libxml2-dev \
        libzip-dev \
    " \
    && apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y $buildDeps $runtimeDeps
RUN docker-php-ext-install bz2
RUN docker-php-ext-install calendar
RUN docker-php-ext-install intl
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install pdo pdo_pgsql
#RUN docker-php-ext-install pgsql
RUN docker-php-ext-install sockets
RUN docker-php-ext-install zip
RUN docker-php-ext-install bcmath
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install gd
RUN docker-php-ext-install exif
RUN docker-php-ext-install soap
RUN pecl install xdebug
RUN pecl install igbinary
RUN docker-php-ext-enable xdebug
RUN apt-get purge -y --auto-remove $buildDeps
RUN rm -r /var/lib/apt/lists/*

# locales
RUN echo 'nl_NL.UTF-8 UTF-8' >> /etc/locale.gen \
    && locale-gen

ENV LC_ALL nl_NL.UTF-8
ENV LANG nl_NL.UTF-8
ENV LANGUAGE nl_NL.UTF-8

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Amsterdam /etc/localtime
RUN "date"

# Type docker-php-ext-install to see available extensions
RUN apt-get update
RUN apt-get -y install nano
RUN apt-get -y install ffmpeg
RUN apt-get install -y iptables
RUN apt-get install -y net-tools

RUN echo 'alias sf="php app/console"' >> ~/.bashrc
RUN echo 'alias sf3="php bin/console"' >> ~/.bashrc

# PHP timezone settings
RUN echo "date.timezone = \"Europe/Amsterdam\"" > /usr/local/etc/php/conf.d/timezone.ini

# Add APPLICATION_ENV to .bashrc
RUN echo "export APPLICATION_ENV=\"development\"" >> /root/.bashrc

#ADD ssh/id_rsa /root/.ssh/
#ADD ssh/id_rsa.pub /root/.ssh/
#RUN chmod 400 /root/.ssh/id_rsa
RUN mkdir /var/log/xdebug
RUN touch '/var/log/xdebug/xdebug.log'
WORKDIR /var/www/src

EXPOSE 21
EXPOSE 20
