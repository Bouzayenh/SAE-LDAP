
<body>
    <h1>Bienvenue  <? echo $user ?> </h1>
    <h2>Présentation des services deployés</h2> 

    <ul class="homepage" >
        <li><strong>OpenLDAP</strong>Ce service d'annuaire léger utilise des ports standard LDAP (389) et LDAPS (636) pour la communication. Il stocke ses données et configurations dans des volumes persistants, assurant ainsi la sécurité et la persistance des informations. Le service est configuré avec un mot de passe administrateur et un DN de base personnalisés, et utilise des certificats TLS pour une communication sécurisée.
        <div class="image-container" id="openldapimg">
            <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fblog.invgate.com%2Fhs-fs%2Fhubfs%2F03%2520-%2520What%2520is%2520LDAP%2520and%2520How%2520Does%2520it%2520Work%2520-%2520Asset%252002.jpg%3Fwidth%3D5003%26name%3D03%2520-%2520What%2520is%2520LDAP%2520and%2520How%2520Does%2520it%2520Work%2520-%2520Asset%252002.jpg&f=1&nofb=1&ipt=544f9759f3d99b60639c1c3d09b7fd5165460235973a0dd75e56288f6d70d0b4&ipo=images" alt="OpenLDAPimg" alt="Description">
         </div>
        </li>
        <li><strong>PHP</strong>Ce conteneur PHP est configuré pour interagir avec OpenLDAP, indiqué par la dépendance déclarée dans docker-compose. Il est accessible via le port 80 et utilise un volume partagé pour le code PHP, permettant une modification et une mise à jour facile du code.
        <div class="image-container" >
            <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Flogos-download.com%2Fwp-content%2Fuploads%2F2016%2F09%2FPHP_logo.png&f=1&nofb=1&ipt=97539640c0e39a67136983745ab41e1001d65dfbc43b81473988dc3c689093c1&ipo=images" alt="OpenLDAPimg" alt="Description">
         </div>
        </li>
        <li><strong>phpLDAPadmin</strong>Une interface web (accessible via le port 90) pour la gestion de l'annuaire OpenLDAP. Elle est configurée pour se connecter au service OpenLDAP et n'utilise pas HTTPS, ce qui facilite l'accès et la gestion de l'annuaire dans un environnement de développement ou de test.
        <div class="image-container" >
            <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Frepository-images.githubusercontent.com%2F3665191%2Fdd213f80-766c-11e9-8117-6b639095ef99&f=1&nofb=1&ipt=c94b584d653bf107380e4e0e6e74bea44a9be5ade9e73c204b05da2394847db9&ipo=images" alt="OpenLDAPimg" alt="Description">
         </div>
        </li>
        <li><strong>MariaDB (db)</strong>Ce service de base de données utilise MariaDB et est configuré spécifiquement pour fonctionner avec Nextcloud. Il inclut des paramètres d'environnement pour le mot de passe root, la base de données Nextcloud, et l'utilisateur de base de données, tout en stockant les données dans un volume pour la persistance.
        <div class="image-container" >
            <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.wpsysadmin.com%2Fwp-content%2Fuploads%2F2021%2F07%2Fmariadb.png&f=1&nofb=1&ipt=2157fbaab1d79b2c86c84e834420aefc8f1b5cb8bbe7f221cfd424cfdb861073&ipo=images" alt="OpenLDAPimg" alt="Description">
         </div>
        </li>
        <li><strong>Nextcloud</strong>Un service de stockage et de partage de fichiers accessible via le port 8080. Il est lié à MariaDB pour le stockage des données et utilise un volume pour stocker le contenu de Nextcloud. Les paramètres d'environnement indiquent les détails de la connexion à la base de données.
        <div class="image-container" id="nextcloudimg">
            <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.marksei.com%2Fwp-content%2Fuploads%2F2016%2F12%2FNextcloud_Logo_White-1.jpg&f=1&nofb=1&ipt=c975197f2d406baf96acf6cbe4bf7b7e0d7a627638c18a653f9cb14bfcefb2fd&ipo=images" alt="OpenLDAPimg" alt="Description">
         </div>
        </li>
        <li class="grid-dolphin-logo"><strong>SQL Database Service</strong>Un service de stockage et de partage de fichiers accessible via le port 8080. Il est lié à MariaDB pour le stockage des données et utilise un volume pour stocker le contenu de Nextcloud. Les paramètres d'environnement indiquent les détails de la connexion à la base de données.
        <div class="image-container" >
            <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fpngimg.com%2Fuploads%2Fmysql%2Fmysql_PNG19.png&f=1&nofb=1&ipt=1201ce48aaa7ec604b66e887a6ca991ff76e1d3b6f9265ec079b0ff26ff1fb87&ipo=images" alt="OpenLDAPimg" alt="Description">
         </div>
        </li>
        <li><strong>phpMyAdmin</strong>Une interface web pour la gestion de la base de données MySQL, accessible via le port 8081. Il est configuré pour se connecter au service de base de données MySQL précédemment mentionné, permettant une gestion facile de la base de données à travers une interface graphique.
        <div class="image-container" >
            <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fassets.stickpng.com%2Fimages%2F610672c22ced4d0004ead4e1.png&f=1&nofb=1&ipt=f001522c66fbe43c90063ac3e070e2aead66bc1e1b8bca2e3226de40572e4786&ipo=images" alt="OpenLDAPimg" alt="Description">
         </div>
        </li>

    

</body>


