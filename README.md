
---> dans le docker pour donner le droit de creer 'uploads'

chown -R www-data:www-data /var/www/camagru/src/uploads
chmod -R 775 /var/www/camagru/src/uploads
