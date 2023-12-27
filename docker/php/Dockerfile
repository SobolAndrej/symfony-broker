FROM php:8.2-fpm-alpine

COPY php.ini /usr/local/etc/php/conf.d/docker-php-config.ini
COPY php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

RUN apk add --no-cache --upgrade coreutils

RUN apk add --no-cache \
    autoconf \
    g++ \
    libtool \
    make \
    pcre-dev \
    gnupg \
    openssl \
    unzip \
    libzip-dev \
    libpng-dev \
    rabbitmq-c-dev \
    bash \
    openssh-client \
    icu-dev \
    && docker-php-ext-install zip pdo_mysql

RUN docker-php-ext-configure intl && docker-php-ext-install intl

RUN pecl install amqp && docker-php-ext-enable amqp

RUN echo 'alias sf="php bin/console"' >> ~/.bashrc

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer