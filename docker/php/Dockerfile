FROM php:8.2-apache
# Activer les modules Apache
RUN a2enmod rewrite headers
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html
RUN docker-php-ext-install mysqli pdo_mysql
# Redémarrer le service Apache
RUN service apache2 restart