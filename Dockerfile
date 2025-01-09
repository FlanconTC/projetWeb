# Utiliser l'image PHP 8.2-FPM comme base
FROM php:8.2-fpm

# Installer les dépendances nécessaires du système
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    git \
    libonig-dev \
    libzip-dev \
    unzip \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Installer les extensions PHP nécessaires pour Symfony
RUN docker-php-ext-install pdo_mysql zip mbstring

# Installer Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Définir le répertoire de travail
WORKDIR /var/www

# Exposer le port par défaut (optionnel, pour documentation)
EXPOSE 9000

# Commande par défaut
CMD ["php-fpm"]
