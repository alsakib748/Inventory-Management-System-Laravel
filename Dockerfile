# Use an appropriate base image
FROM php:7.4-cli

# Install libssl
RUN apt-get update && apt-get install -y libssl1.0.0

# Copy application files
COPY . /app

# Set working directory
WORKDIR /app

# Run the PHP application
CMD ["php", "index.php"]
