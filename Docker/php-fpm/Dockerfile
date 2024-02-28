FROM php:8.2.7-fpm-bullseye
ARG USER_ID=1000
ENV USER_NAME=www-data
ARG GROUP_NAME=www-data

RUN apt-get update && \ 
    apt-get -y upgrade && \
    apt-get -y install bash libicu-dev locales libpng-dev libjpeg-dev libpng-dev autoconf libzip-dev openssl bash && \
    docker-php-ext-install pdo pdo_mysql exif bcmath intl && \
    docker-php-ext-configure gd --with-jpeg=/usr/include/ && \
    docker-php-ext-install -j$(nproc) gd && \
    docker-php-ext-install zip && \
    pecl install xdebug && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

COPY ./php.ini /usr/local/etc/php/conf.d/
COPY ./xlaravel.pool.conf /usr/local/etc/php-fpm.d/
COPY ./entrypoint.sh /entrypoint.sh

USER root

WORKDIR /var/www
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    rm -rf /tmp/src

RUN usermod -u ${USER_ID} ${USER_NAME}
RUN groupmod -g ${USER_ID} ${GROUP_NAME}
RUN chown -R ${USER_NAME}:${GROUP_NAME} /var/www && \
    chown -R ${USER_NAME}:${GROUP_NAME} /var/log/ && \
    #   chown -R ${USER_NAME}:${GROUP_NAME} /etc/supervisor/conf.d/ && \
    chown -R ${USER_NAME}:${GROUP_NAME} $PHP_INI_DIR/conf.d/ && \
    chown -R ${USER_NAME}:${GROUP_NAME} /tmp

EXPOSE 9000
CMD ["/entrypoint.sh"]