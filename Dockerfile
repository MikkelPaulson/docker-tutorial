FROM php:7.2-cli-alpine

#RUN apk add --no-cache autoconf build-base

#RUN pecl install redis && docker-php-ext-enable redis

COPY web/index.php /web/index.php

CMD php -S 0.0.0.0:80 /web/index.php
