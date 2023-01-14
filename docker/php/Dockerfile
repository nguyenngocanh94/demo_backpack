FROM php:8.1.2-fpm

ENV APCU_VERSION 5.1.21
ENV COMPOSER_ALLOW_SUPERUSER 1
ARG APP_CODE_PATH_CONTAINER
ARG DOCKER_PHP_PATH=./docker/php

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone


RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        libicu-dev \
        libpq-dev \
        libxpm-dev \
        libvpx-dev \
        ssh \
        zip \
        git


RUN docker-php-ext-install mysqli \
        && docker-php-ext-install pdo_mysql

ARG INSTALL_XDEBUG=false

RUN if [ ${INSTALL_XDEBUG} = true ]; then \
   yes | pecl install xdebug; \
   docker-php-ext-enable xdebug \
;fi


# latest composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR ${APP_CODE_PATH_CONTAINER}

COPY ./app .
RUN mkdir -p public/build

COPY ${DOCKER_PHP_PATH}/conf/development.ini /usr/local/etc/php/conf.d/production.ini
COPY ${DOCKER_PHP_PATH}/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

CMD ["docker-entrypoint", "php-fpm"]