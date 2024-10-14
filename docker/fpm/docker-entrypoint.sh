#!/bin/sh
set -e

# Assurez-vous que le dossier uploads existe et a les bonnes permissions
mkdir -p /var/www/camagru/src/uploads
chown -R www-data:www-data /var/www/camagru/src/uploads
chmod -R 775 /var/www/camagru/src/uploads

# Exécutez la commande originale
exec "$@"

