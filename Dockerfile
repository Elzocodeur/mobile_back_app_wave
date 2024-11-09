FROM php:8.2-fpm

# Installez les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install pdo_pgsql zip

# Installez Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www

# Copiez les fichiers Laravel dans le conteneur
COPY . .

# Installez les dépendances PHP avec Composer
RUN composer install --no-scripts --optimize-autoloader

# Exposez le port 9000 pour PHP-FPM
EXPOSE 9001

# Lancez les migrations
RUN php artisan migrate

CMD ["php-fpm"]
