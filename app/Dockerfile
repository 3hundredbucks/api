FROM php:7-fpm

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
    && pecl install xdebug \
        && docker-php-ext-enable xdebug

# Куда же без composer'а.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get install tzdata

RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

ENV TZ Europe/Moscow

ADD ./php.ini /usr/local/etc/php/php.ini

# Указываем рабочую директорию для PHP
WORKDIR /var/www/test.dev
