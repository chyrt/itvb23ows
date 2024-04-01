FROM php:latest

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

COPY src/webapp/ ./
RUN chmod +x vendor/bin/phpunit
CMD ["php", "-S", "0.0.0.0:80"]