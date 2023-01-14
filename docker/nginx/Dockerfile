FROM nginx:1.23-alpine

COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

ARG PHP_UPSTREAM_CONTAINER
ARG PHP_UPSTREAM_PORT
ARG APP_CODE_PATH_HOST
ARG APP_CODE_PATH_CONTAINER

RUN echo "upstream php-upstream { server ${PHP_UPSTREAM_CONTAINER}:${PHP_UPSTREAM_PORT}; }" \
    > /etc/nginx/conf.d/upstream.conf

COPY ${APP_CODE_PATH_HOST}/public ${APP_CODE_PATH_CONTAINER}/public
