FROM php:7.0-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev
RUN apt-get install -y vim
RUN docker-php-ext-install mbstring pdo_mysql tokenizer
RUN apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

CMD php-fpm
