
FROM php:8.2-apache

# Mise à jour et installation des dépendances nécessaires
RUN apt-get update && \
    apt-get install -y libldap2-dev default-mysql-client && \
    rm -rf /var/lib/apt/lists/*

# Configuration et installation des extensions PHP
RUN docker-php-ext-configure ldap && \
    docker-php-ext-install ldap pdo_mysql

# Activation du module SSL d'Apache et configuration site
RUN a2enmod ssl && \
    a2ensite default-ssl

# Copie des certificats SSL dans l'image
COPY ./src/certs/localhost.crt /etc/ssl/certs/localhost.crt
COPY ./src/certs/localhost.key /etc/ssl/private/localhost.key

# Configuration du VirtualHost par défaut pour utiliser SSL
RUN echo '<VirtualHost *:443>\n\
    SSLEngine on\n\
    SSLCertificateFile /etc/ssl/certs/localhost.crt\n\
    SSLCertificateKeyFile /etc/ssl/private/localhost.key\n\
    DocumentRoot /var/www/html\n\
</VirtualHost>' > /etc/apache2/sites-available/default-ssl.conf

RUN a2ensite default-ssl

# Copie de votre application PHP dans l'image
WORKDIR /var/www/html
COPY . /var/www/html/

# Exposer le port 443 pour SSL
EXPOSE 443

RUN service apache2 restart
