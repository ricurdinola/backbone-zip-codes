#Recibimos Argumentos
ARG php_version

FROM php:${php_version}
LABEL  maintainer="ricurdinola@gmail.com"

#Limpiamos Repos antes de instalar
RUN apt-get clean all && apt-get update && apt-get dist-upgrade -y

RUN apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
		zip unzip libzip-dev \
		libmcrypt-dev \
        tzdata \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install zip

RUN cp /usr/share/zoneinfo/America/Argentina/Buenos_Aires /etc/localtime

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apt-get install -y locales locales-all
RUN apt-get install -y libicu-dev
RUN docker-php-ext-install intl
RUN docker-php-ext-configure intl

RUN chown www-data:www-data -R /var/www/html

#Copiamos de la imagen composer a la maquina local.
COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY ./config/apache2/apache2.conf /etc/apache2/
COPY ./config/apache2/sites-available/000-default.conf /etc/apache2/sites-available/
COPY ./config/php/ /usr/local/etc/php

RUN a2enmod rewrite

#Seteamos el path con el directorio de composer
RUN echo 'export PATH="$PATH:$HOME/.composer/vendor/bin"' >> ~/.bashrc
	
EXPOSE 80 443