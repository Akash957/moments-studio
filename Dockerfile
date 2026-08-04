FROM php:8.3-cli AS base

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip xml \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Node.js 20 LTS
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files first (Docker layer caching)
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Copy package files and install node dependencies
COPY package.json package-lock.json ./
RUN npm ci

# Copy the rest of the application
COPY . .

# Run post-autoload-dump scripts
RUN composer dump-autoload --optimize

# Build frontend assets with Vite
RUN npm run build

# Remove node_modules after build to reduce image size
RUN rm -rf node_modules

# Create necessary directories
RUN mkdir -p storage/logs \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache \
    public/uploads/media

# Set permissions
RUN chmod -R 775 storage bootstrap/cache public/uploads

# PHP production config
RUN echo "memory_limit=256M" > /usr/local/etc/php/conf.d/custom.ini \
    && echo "upload_max_filesize=50M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "post_max_size=50M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "max_execution_time=120" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "display_errors=Off" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "log_errors=On" >> /usr/local/etc/php/conf.d/custom.ini

# Expose port (Railway sets PORT env var)
EXPOSE 8080

# Start script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
