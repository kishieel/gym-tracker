FROM php:8.0-fpm-alpine AS core

RUN docker-php-ext-install pdo pdo_mysql

RUN apk --update --virtual build-deps add $PHPIZE_DEPS \
    bash \
    bash-completion \
    shadow \
    git

RUN curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin && \
    composer clear-cache

COPY .docker/ /tmp/docker
RUN cp -r /tmp/docker/* / && rm -rf /tmp/docker

ARG USER_ID=1000
ARG GROUP_ID=1000

USER root:root
RUN userdel -f www-data && \
    groupadd -g ${GROUP_ID} www-data && \
    useradd -u ${USER_ID} -g www-data www-data && \
    install -d -m 0755 -o www-data -g www-data /home/www-data

CMD ["php-fpm"]
EXPOSE 80 443

WORKDIR /var/www/html
COPY --chown=www-data:www-data ./ ./
ENV PATH=$PATH:/var/www/html:/var/www/html/vendor/bin
