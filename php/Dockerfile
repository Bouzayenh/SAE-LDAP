FROM php:8.2-apache
   

RUN apt-get update && \
    apt-get install -y libldap2-dev default-mysql-client && \
    rm -rf /var/lib/apt/lists/*
    
RUN docker-php-ext-configure ldap && \
    docker-php-ext-install ldap pdo_mysql

WORKDIR /var/www/html
COPY . /var/www/html/
