#!/bin/bash

# Attendre que la base de données soit prête avec PHP
wait_for_db() {
  echo "Attente que la base de données soit prête..."
  until php -r "
    try {
      new PDO('mysql:host=${DB_HOST};port=${DB_PORT}', '${DB_USER}', '${DB_PASSWORD}');
      exit(0);
    } catch (Exception \$e) {
      exit(1);
    }
  "; do
    sleep 2
  done
  echo "La base de données est prête !"
}

# Configurer les variables d'environnement
export DB_NAME=${DB_NAME:-adopteundev}
export DB_HOST=${DB_HOST:-db}
export DB_PORT=${DB_PORT:-3306}
export DB_USER=${DB_USER:-root}
export DB_PASSWORD=${DB_PASSWORD:-root}

# Attendre que la base de données soit prête
wait_for_db

# Installer les dépendances PHP
echo "Installation des dépendances avec Composer..."
composer install --no-progress --no-interaction

# Créer la base de données et appliquer les migrations
php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:migrations:migrate --no-interaction

# Insérer les données depuis le fichier SQL
echo "Insertion des données depuis le fichier SQL..."
php -r "
try {
  \$pdo = new PDO('mysql:host=${DB_HOST};port=${DB_PORT};dbname=${DB_NAME}', '${DB_USER}', '${DB_PASSWORD}');
  \$pdo->exec(file_get_contents('/var/www/adopteundev.sql'));
  echo 'Données insérées avec succès !';
} catch (Exception \$e) {
  echo 'Erreur lors de l\'insertion des données : ' . \$e->getMessage();
  exit(1);
}
"

# Lancer le processus principal (php-fpm)
echo "Lancement de php-fpm..."
exec php-fpm -F