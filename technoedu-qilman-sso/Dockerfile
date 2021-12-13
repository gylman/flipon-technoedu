# FROM httpd:2.4
FROM php:7.4-apache

# COPY ./my-httpd.conf /usr/local/apache2/conf/httpd.conf
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf
# COPY ./php.ini /usr/local/etc/php

RUN docker-php-ext-install mysqli \
    && docker-php-ext-enable mysqli

WORKDIR /app

COPY . .

# RUN ./load_facelink.sh
# RUN mysql -uroot -p < facelink.sql
# mysql -uadmin -pLBS9AqTifmCz -h<host> -P<port>
