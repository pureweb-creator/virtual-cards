FROM php:8.2-fpm

WORKDIR /app
ARG APP_ENV

RUN apt-get update \
    && apt-get install -y libmemcached-dev zlib1g-dev libssl-dev \
    && yes '' | pecl install -f memcached-3.2.0 \
    && docker-php-ext-enable memcached \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && apt-get install -y curl && apt-get clean -y \
    && cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer \
    && apt-get install -y \
    git \
    zip \
    unzip \
    vim

RUN if [ "$APP_ENV" != "production" ]; then \
        pecl install xdebug && \
        docker-php-ext-enable xdebug; \
    fi

COPY conf.d/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

ARG UNAME=docker
ARG GID=1000
ARG UID=1000
RUN groupadd -g $GID -o $UNAME
RUN useradd -m -u $UID -g $GID -o -s /bin/bash $UNAME
