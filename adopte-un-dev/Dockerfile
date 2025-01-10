# Utiliser l'image PHP 8.2-FPM comme base
FROM php:8.2-fpm

# Installer les dépendances nécessaires du système et les extensions PHP nécessaires pour Symfony
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    git \
    libonig-dev \
    libzip-dev \
    unzip \
    zip \
    && rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-install pdo_mysql zip mbstring && \
    curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony*/bin/symfony /usr/local/bin/symfony && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copier le script entrypoint
COPY adopteundev.sql /var/www/adopteundev.sql
COPY entrypoint.sh /var/www/entrypoint.sh

# Donner les permissions d'exécution au script entrypoint
RUN chmod +x /var/www/entrypoint.sh

# Définir le répertoire de travail
WORKDIR /var/www

# Exposer le port par défaut (optionnel, pour documentation)
EXPOSE 9000

# Commande par défaut
CMD ["php-fpm"]
