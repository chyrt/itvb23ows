FROM php:7.4-apache
LABEL authors="Geert Perton"
RUN docker-php-ext-install mysqli
COPY src/ /var/www/html/
EXPOSE 80
