FROM php:8.2-fpm

RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update \
    && apt-get install -y supervisor \
    && apt-get install -y libmemcached-dev zlib1g-dev libssl-dev \
    && yes '' | pecl install -f memcached-3.2.0 \
    && docker-php-ext-enable memcached

RUN mkdir -p "/etc/supervisor/logs"

COPY supervisord.conf /etc/supervisor/supervisord.conf

CMD ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/supervisord.conf"]
