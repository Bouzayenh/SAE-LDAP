# SAE-LDAP

## Presentation du Projet

Le projet SAE-LDAP est notre projet principal du semestre 5, au sein de notre formation en Informatique à l'IUT de Montpellier, spécialisation DACS: Déploiement d'applications communicantes et sécurisées.

Ce projet à comme objectif de régrouper trois services dans un même réseaux de manière communicante et sécurisée. Chaque service possède son unique fonctionalité, lui rendant utile et ajoutant de la valeur au réseau.

Chaque service doit communiquer avec d'autres services du même réseau pour garantir son correct fonctionnement.

Et finalement, ce réseau de services est protegée par un groupe de services garantissant leur integrité.

## Technologies Utilisées au sein du Projet

Ce projet utilise plusieurs technologies permettant de déployer, sécuriser et maintenir le service actualisé.

On pourrait par commencer à nommer les technologies nous permetant de déployer la totalité du projet:

- Docker
- Docker Compose
- Docker Networks/Volumes
- Image PHP-Apache
- Image Nexcloud
- Image RocketChat

Pour la sécurisation de l'application on utilise principalement, deux utils:

- Open LDAP
- KeyCloak

Ces deux services travaillent en harmonie afin de permettre une authentification, et une session sécurisé

De plus, notre application utilise la technoligie HTTPS et des certificats TLS afin de preserver une communication entre divers serveurs de manière sécurisée.

Finalement, toute cette architecture est récuverte par un reverse proxy. Permettant de centraliser toute connexion, ou tentative de connexion à l'application SAE-LDAP.

On va vous présenter de manière détaillée chacun des services, ainsi que les fonctionnalités dont ils sont munis.

### Service PHP

Ce service est essentiel pour la creation, visualisation, modification et elimination (CRUD) des utilisateurs faisant partie de notre repertoire LDAP.
Il nous permet aussi, grâce à l'authentification Keycloak de modifier notre utilisateur.

### Service Nexcloud

Logiciel Cloud permettant l'autohebergement de documents. C'est une solution de stockage qui est en compétition avec des solutions comme AWS, Google Drive etc... Cette solution devient si attractive en vue de son fonctionnement open-source. Offrant une version gratuite, ainsi qu'une version pro payante.

### Service Rocket Chat

Plateforme de collaboration open-source. Ce service possède une communauté énorme, il est quasi totalement personalisable, actualisé et donne une très grande importance a la sécurité. C'est la plateforme de collaboration pour les organisations qui traitent de données sensibles.

## Comment déployer l'application

Ce projet à été conçu pour être déployé de la manière la plus simple et rapide possible.

C'est pour cela une fois que vous avez "clone" notre projet

`git clone git@github.com:Bouzayenh/SAE-LDAP.git`

vous devriez executer uniquement cette commande:

`./run.sh`

Peut être celle-la aussi:

`chmod +x ./run.sh`

### To do

- [x] ProxyPHP
- [x] ProxyNextcloud
- [x] Docker secrets
- [ ] .env -> Chiffrement
- [ ] Reffinement Keycloak
- [ ] Automatisation Nextcloud
- [ ] Identifier les elements à sauvegarder
- [ ] Réfinement application Sauvegarde
- [ ] Déploiement de la totalité de l'application dans le HUB
- [ ] Déploiement de la totalité de l'application à l'IUT
- [ ] Tests d'infiltation
