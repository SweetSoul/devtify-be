FROM php:8.0-apache

RUN apt update
RUN apt install -y \
            g++ \
            libicu-dev \
            libpq-dev \
            libzip-dev \
            zip \
            zlib1g-dev
RUN docker-php-ext-install \
            intl \
            opcache \
            pdo \
            pdo_pgsql \
            pgsql \
            pdo_mysql \
            mysqli
RUN a2enmod rewrite
RUN service apache2 restart
WORKDIR /var/www/devtify
