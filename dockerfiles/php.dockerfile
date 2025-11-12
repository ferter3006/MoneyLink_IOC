FROM php:8.2-fpm-alpine

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

RUN mkdir -p /var/www/html

WORKDIR /var/www/html


# Permisos correctos para Laravel
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

RUN set -ex && apk --no-cache add libxml2-dev zip libzip-dev libpng-dev jpeg-dev libpq-dev

RUN docker-php-ext-configure gd --with-jpeg && \
    docker-php-ext-install pdo pdo_pgsql pgsql opcache xml soap zip gd

RUN apk add --no-cache autoconf g++ make \
    && pecl install redis \
    && docker-php-ext-enable redis



COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]
