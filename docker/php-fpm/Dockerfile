FROM php:8.1-fpm-alpine

WORKDIR /app

# install xdebug
RUN set -eux; \
	apk add --no-cache --virtual .build-deps $PHPIZE_DEPS linux-headers ; \
	pecl install xdebug ; \
	pecl clear-cache; \
	docker-php-ext-enable xdebug ; \
    apk del .build-deps

#RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

#COPY . /app

#RUN set -eux; \
#	composer install --prefer-dist --no-progress;
