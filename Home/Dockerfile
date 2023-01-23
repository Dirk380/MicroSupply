

FROM php:7.4.33-apache
WORKDIR /app/
RUN docker-php-ext-install mysqli
RUN docker-php-ext-enable mysqli
RUN apachectl restart

COPY . /var/www/html