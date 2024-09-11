FROM php:8.2-fpm

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /app

RUN apt-get update \
    && apt-get install -y supervisor \
    && apt-get install -y libmemcached-dev zlib1g-dev libssl-dev \
    && yes '' | pecl install -f memcached-3.2.0 \
    && docker-php-ext-enable memcached

ARG UNAME=docker
ARG GID=1000
ARG UID=1000
RUN groupadd -g $GID -o $UNAME
RUN useradd -m -u $UID -g $GID -o -s /bin/bash $UNAME

RUN mkdir -p "/etc/supervisor/logs"

COPY supervisord.conf /etc/supervisor/supervisord.conf

CMD ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/supervisord.conf"]
