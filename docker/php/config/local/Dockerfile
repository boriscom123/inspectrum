FROM php:8.3-fpm

# Application environment
WORKDIR /var/www/app

## Install system packages for PHP extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions \
    @composer \
    gd \
    pdo_mysql \
    zip \
    bcmath \
    mbstring \
    exif \
    gmagick \
    dom \
    iconv \
    intl \
    soap \
    xdebug
#    curl \
#    opcache \
#    mongodb \
#    memcached \
#    amqp \
#    redis \
#    pdo_pgsql \
#    json