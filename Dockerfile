# syntax=docker/dockerfile:1

# ---- Stage 1: build frontend assets (Vite / React / Tailwind) ----
FROM node:20-alpine AS assets
WORKDIR /app
# Cloudinary cloud name is baked into the JS bundle at build time (Vite import.meta.env)
ARG VITE_CLOUDINARY_CLOUD_NAME=
ENV VITE_CLOUDINARY_CLOUD_NAME=$VITE_CLOUDINARY_CLOUD_NAME
COPY package.json package-lock.json ./
RUN npm ci
COPY . .
RUN npm run build

# ---- Stage 2: PHP dependencies (no dev) ----
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction
COPY . .
RUN composer dump-autoload --optimize --no-dev --no-scripts

# ---- Stage 3: production runtime (nginx + php-fpm + supervisor) ----
FROM php:8.2-fpm-alpine AS app

# php extensions Laravel/Filament/GD-image need + web server + process manager
COPY --from=mlocati/php-extension-installer:latest /usr/bin/install-php-extensions /usr/local/bin/
RUN apk add --no-cache nginx supervisor \
 && install-php-extensions pdo_mysql gd zip bcmath exif intl opcache pcntl

WORKDIR /var/www/html

# app code + vendor from stage 2, built assets from stage 1
COPY --from=vendor /app ./
COPY --from=assets /app/public/build ./public/build

# runtime config
COPY docker/php.ini           /usr/local/etc/php/conf.d/zzz-app.ini
COPY docker/nginx.conf        /etc/nginx/nginx.conf
COPY docker/supervisord.conf  /etc/supervisord.conf
COPY docker/entrypoint.sh     /usr/local/bin/entrypoint

RUN chmod +x /usr/local/bin/entrypoint \
 && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80
ENTRYPOINT ["entrypoint"]
CMD ["supervisord", "-c", "/etc/supervisord.conf"]
