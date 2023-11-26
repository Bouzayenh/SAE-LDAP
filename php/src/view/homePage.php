
<body>
    <h1>Bienvenue  <? echo $user ?> </h1>
    <h2>Présentation des services deployés</h2>

    <ul class="homepage" >
        <li><strong>OpenLDAP</strong>Ce service d'annuaire léger utilise des ports standard LDAP (389) et LDAPS (636) pour la communication. Il stocke ses données et configurations dans des volumes persistants, assurant ainsi la sécurité et la persistance des informations. Le service est configuré avec un mot de passe administrateur et un DN de base personnalisés, et utilise des certificats TLS pour une communication sécurisée.</li>
        <li><strong>PHP</strong>Ce conteneur PHP est configuré pour interagir avec OpenLDAP, indiqué par la dépendance déclarée dans docker-compose. Il est accessible via le port 80 et utilise un volume partagé pour le code PHP, permettant une modification et une mise à jour facile du code.</li>
        <li><strong>phpLDAPadmin</strong>Une interface web (accessible via le port 90) pour la gestion de l'annuaire OpenLDAP. Elle est configurée pour se connecter au service OpenLDAP et n'utilise pas HTTPS, ce qui facilite l'accès et la gestion de l'annuaire dans un environnement de développement ou de test.</li>
        <li><strong>MariaDB (db)</strong>Ce service de base de données utilise MariaDB et est configuré spécifiquement pour fonctionner avec Nextcloud. Il inclut des paramètres d'environnement pour le mot de passe root, la base de données Nextcloud, et l'utilisateur de base de données, tout en stockant les données dans un volume pour la persistance.</li>
        <li><strong>Nextcloud</strong>Un service de stockage et de partage de fichiers accessible via le port 8080. Il est lié à MariaDB pour le stockage des données et utilise un volume pour stocker le contenu de Nextcloud. Les paramètres d'environnement indiquent les détails de la connexion à la base de données.</li>
        <li><strong>SQL Database Service</strong>Un service de stockage et de partage de fichiers accessible via le port 8080. Il est lié à MariaDB pour le stockage des données et utilise un volume pour stocker le contenu de Nextcloud. Les paramètres d'environnement indiquent les détails de la connexion à la base de données.</li>
        <li><strong>phpMyAdmin</strong>Une interface web pour la gestion de la base de données MySQL, accessible via le port 8081. Il est configuré pour se connecter au service de base de données MySQL précédemment mentionné, permettant une gestion facile de la base de données à travers une interface graphique.</li>
    </ul>

</body>


