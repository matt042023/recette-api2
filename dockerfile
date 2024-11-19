# Utilise l'image PHP 8.2 avec CLI
FROM php:8.2-cli

# Installer les extensions nécessaires pour Symfony
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libmariadb-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Définir le répertoire de travail
WORKDIR /srv

# Expose le port pour le serveur Symfony
EXPOSE 8000