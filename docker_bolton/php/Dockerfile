FROM php:7.3-fpm-stretch

# Set timezone
ENV TZ=America/Sao_Paulo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update && apt-get -y install apt-transport-https gnupg2

ENV APT_KEY_DONT_WARN_ON_DANGEROUS_USAGE=DontWarn

# Add PHP config
RUN apt update \
    && apt install -y vim libmcrypt-dev zlib1g-dev libpq-dev libxml2-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev libwebp-dev libzip-dev xdot \
    && docker-php-ext-configure gd --with-webp-dir --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install exif pdo pdo_pgsql mbstring -j$(nproc) gd zip pcntl \
    && pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis \
    && cd /usr/src \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt install -y sqlite3

# Clean
RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

WORKDIR /var/www/bolton