FROM php:8.1-apache

WORKDIR /var/www/html/
COPY ./../ ./

RUN docker-php-ext-install mysqli
RUN a2enmod rewrite

RUN sed -i -e 's|/var/www/html|/var/www/html/frontend/web|g' /etc/apache2/sites-available/000-default.conf
RUN sed -i -e 's|ssl:warn|ssl:warn AllowOverride All|g' /etc/apache2/sites-available/000-default.conf
