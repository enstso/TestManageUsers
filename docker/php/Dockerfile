FROM php:8.2-apache
# Activer les modules Apache
RUN a2enmod rewrite headers
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html
RUN docker-php-ext-install mysqli pdo_mysql

# Configurer le serveur Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Mettre à jour les paquets et installer les dépendances nécessaires
RUN apt-get update \
    && apt-get install -qq -y --no-install-recommends \
    cron \
    vim \
    locales \
    coreutils \
    apt-utils \
    git \
    libicu-dev \
    g++ \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    libxslt-dev \
    wget \
    xz-utils

# Installer une version récente de 7-Zip
RUN wget https://www.7-zip.org/a/7z2107-linux-x64.tar.xz \
    && mkdir /usr/local/7z \
    && tar -xvf 7z2107-linux-x64.tar.xz -C /usr/local/7z \
    && ln -s /usr/local/7z/7zz /usr/local/bin/7zz

# Configurer les locales
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen

# Installer Composer
RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
    mv composer.phar /usr/local/bin/composer

# Configurer et installer les extensions PHP
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql mysqli gd opcache intl zip calendar dom mbstring xsl && a2enmod rewrite

# Installer PHPUnit
RUN wget -O phpunit https://phar.phpunit.de/phpunit-10.phar \
    && chmod +x phpunit \
    && mv phpunit /usr/local/bin/phpunit

# Installer APCu
RUN pecl install apcu && docker-php-ext-enable apcu

# Ajouter l'installateur d'extensions PHP et installer amqp
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions amqp
# Redémarrer le service Apache
RUN service apache2 restart

#docker exec -it  taskmanagertest-api-1 bash


#Lancer un test: phpunit tests ou ./vendor/bin/phpunit tests (composer)

#Debug composer dump-autoload -o