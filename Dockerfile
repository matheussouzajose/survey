FROM php:8.1.1-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    openssl \
    libssl-dev

RUN apt-get install -y librdkafka-dev

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

RUN usermod -u 1000 www-data

WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

# Instalar extensão do MongoDB
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

RUN pecl install rdkafka

USER www-data

EXPOSE 9000
