FROM php:latest

RUN docker-php-ext-install mysqli

COPY src/webapp/ ./
CMD ["php", "-S", "0.0.0.0:80"]