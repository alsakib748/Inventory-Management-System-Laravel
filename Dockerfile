# Use an official PHP image with the necessary version
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y libssl1.0.0

# Set up the application
WORKDIR /app
COPY . /app

# Install composer and Laravel dependencies
RUN curl -sS https://getcomposer.org/installer | php && \
    php composer.phar install --no-dev --optimize-autoloader

# Set up the Laravel environment
RUN php artisan key:generate

# Expose port 80 for the Laravel server
EXPOSE 80

# Run the Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
