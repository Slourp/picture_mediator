# Use an official PHP runtime as a parent image
FROM php:8.2-fpm-alpine as app

# Set build arguments
ARG USER_ID
ARG GROUP_ID
ARG USER
ARG DEBUG_MODE=off

# Create a group and user
RUN addgroup -g ${GROUP_ID} -S ${USER} && adduser -u ${USER_ID} -S ${USER} -G ${USER}

# Set the working directory to /var/www/app
WORKDIR "/var/www/app"

# Useful PHP extension installer image, copy binary into your container
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Install php extensions
RUN set -eux && /usr/local/bin/install-php-extensions pdo pdo_mysql

# allow super user - set this if you use Composer as a
# super user at all times like in docker containers
# ENV COMPOSER_ALLOW_SUPERUSER=1

# obtain composer using multi-stage build
# https://docs.docker.com/build/building/multi-stage/
COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer

#Here, we are copying only composer.json and composer.lock (instead of copying the entire source)
# right before doing composer install.
# This is enough to take advantage of docker cache and composer install will
# be executed only when composer.json or composer.lock have indeed changed!-
# https://medium.com/@softius/faster-docker-builds-with-composer-install-b4d2b15d0fff
COPY ./composer.* /var/www/app

RUN chown -R ${USER}:${USER} /var/www/app

# Switch to the created user
USER ${USER}

# run composer dump-autoload --optimize
# RUN composer dump-autoload --optimize

# copy application files to the working directory
COPY ./ /var/www/app
RUN rm -rf /var/www/app/docker

# run composer dump-autoload --optimize
# RUN composer dump-autoload --optimize

# Dev image
# This stage is meant to be target-built into a separate image
# https://docs.docker.com/develop/develop-images/multistage-build/#stop-at-a-specific-build-stage
# https://docs.docker.com/compose/compose-file/#target
FROM app as app_dev

# Set the working directory to /var/www/app
WORKDIR "/var/www/app"

# Xdebug has different modes / functionalities. We can default to 'off' and set to 'debug'
# when we run docker compose up if we need it
ENV XDEBUG_MODE=${DEBUG_MODE}

# Copy xdebug config file into container
COPY ./docker/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Install xdebug
RUN set -eux && install-php-extensions xdebug

# Switch to the created user
USER ${USER}
