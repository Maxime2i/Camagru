# Utiliser une image Apache/PHP
FROM php:7.4-apache


# Copier les fichiers de l'application dans le conteneur
COPY . /var/www/html/

# Copier le fichier php.ini personnalisé dans le conteneur
COPY ./php.ini /usr/local/etc/php/conf.d/php.ini

# Exposer le port 80 pour le serveur web
EXPOSE 80