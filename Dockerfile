# Use the official PHP image with the CLI version as the base image
FROM php:latest

# Install system dependencies required for Composer and PHP extensions
RUN apt-get update && \
    apt-get install -y git zip unzip && \
    docker-php-ext-install mysqli && \
    docker-php-ext-enable mysqli

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory to /app
WORKDIR /app

# Copy the application's composer.json and composer.lock to /app
COPY src/webapp/composer.json src/webapp/composer.lock ./

# Run Composer install to install the dependencies
# --no-scripts and --no-autoloader for optimized autoloader and ensuring scripts don't run at this stage
RUN composer install --no-scripts

# Copy the rest of the application code to /app
COPY src/webapp/ ./

# Finish Composer setup by dumping the autoloader
RUN composer dump-autoload --optimize

# Make PHPUnit executable (should already be executable from composer install)
RUN chmod +x vendor/bin/phpunit

# Specify the command to run the PHP built-in server
CMD ["php", "-S", "0.0.0.0:80"]
