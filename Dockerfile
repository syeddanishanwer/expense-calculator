FROM dunglas/frankenphp:latest-php8.3

# Install necessary system libraries and the PostgreSQL extension
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/lists/*

# Establish the secure cloud container application directory
WORKDIR /app

# Mirror your codebase inside the running container context
COPY . /app

# Download clean Composer dependencies for production
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Grant necessary server permissions for storage write access operations
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

EXPOSE 8080