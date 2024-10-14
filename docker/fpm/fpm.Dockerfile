FROM php:7.4-fpm

ADD docker/fpm/conf/php.ini /usr/local/etc/php/php.ini

RUN apt-get update \
&& docker-php-ext-install pdo pdo_mysql

RUN apt-get update && apt-get install -y msmtp

ARG GMAIL_USER
ARG GMAIL_PASSWORD
ARG MYSQL_USER
ARG MYSQL_PASSWORD
ARG MYSQL_DATABASE

# Créer le fichier de configuration /etc/msmtprc
RUN echo "defaults\n\
tls on\n\
tls_trust_file /etc/ssl/certs/ca-certificates.crt\n\
logfile /var/log/msmtp.log\n\
\n\
account gmail\n\
host smtp.gmail.com\n\
port 587\n\
auth on\n\
user ${GMAIL_USER}\n\
password ${GMAIL_PASSWORD}\n\
from ${GMAIL_USER}\n\
\n\
account default : gmail" > /etc/msmtprc

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Ajoutez ces lignes à la fin du Dockerfile
RUN mkdir -p /var/www/camagru/src/uploads \
    && chown -R www-data:www-data /var/www/camagru/src/uploads \
    && chmod -R 775 /var/www/camagru/src/uploads
