
<body>

    
        <h1>Bienvenue  <? echo $user ?> </h1>
        <h2>Présentation des services deployés</h2> 

        <ul class="homepage" >
            <li><strong>OpenLDAP</strong>OpenLDAP est un logiciel libre qui implémente le protocole LDAP pour fournir un service d'annuaire. Il est principalement utilisé pour la gestion des informations d'identité des utilisateurs et leur authentification dans les réseaux informatiques. OpenLDAP est optimisé pour la lecture et la recherche de données, supporte des communications sécurisées via TLS/SSL, et est hautement personnalisable pour répondre à divers besoins spécifiques.
            <div class="image-container" id="openldapimg">
                <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fblog.invgate.com%2Fhs-fs%2Fhubfs%2F03%2520-%2520What%2520is%2520LDAP%2520and%2520How%2520Does%2520it%2520Work%2520-%2520Asset%252002.jpg%3Fwidth%3D5003%26name%3D03%2520-%2520What%2520is%2520LDAP%2520and%2520How%2520Does%2520it%2520Work%2520-%2520Asset%252002.jpg&f=1&nofb=1&ipt=544f9759f3d99b60639c1c3d09b7fd5165460235973a0dd75e56288f6d70d0b4&ipo=images" alt="OpenLDAPimg" alt="Description">
            </div>
            </li>
            <li><strong>PHP</strong>Nous avons déployé une application PHP qui présente les services intégrés à OpenLDAP. Cette application offre des fonctionnalités avancées pour la gestion des utilisateurs sur le réseau LDAP. Elle permet la création de nouveaux utilisateurs, ainsi que leur connexion au réseau LDAP. De plus, l'application offre la possibilité de lister tous les utilisateurs existants et de supprimer ceux qui ne sont plus nécessaires.
            <div class="image-container" >
                <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Flogos-download.com%2Fwp-content%2Fuploads%2F2016%2F09%2FPHP_logo.png&f=1&nofb=1&ipt=97539640c0e39a67136983745ab41e1001d65dfbc43b81473988dc3c689093c1&ipo=images" alt="OpenLDAPimg" alt="Description">
            </div>
            </li>
            <li><strong>phpLDAPadmin</strong>
                phpLDAPadmin est une application web PHP qui sert d'interface graphique pour la gestion des serveurs LDAP. Elle permet aux utilisateurs de visualiser, rechercher, créer, modifier et supprimer des données dans un annuaire LDAP, comme les comptes utilisateurs et les groupes. L'outil facilite également la gestion des schémas LDAP, rendant l'administration des serveurs LDAP plus accessible via une interface utilisateur conviviale.
            <div class="image-container" >
                <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Frepository-images.githubusercontent.com%2F3665191%2Fdd213f80-766c-11e9-8117-6b639095ef99&f=1&nofb=1&ipt=c94b584d653bf107380e4e0e6e74bea44a9be5ade9e73c204b05da2394847db9&ipo=images" alt="OpenLDAPimg" alt="Description">
            </div>
            </li>
            <li><strong>MariaDB (db)</strong>Ce service de base de données utilise MariaDB et est configuré spécifiquement pour fonctionner avec Nextcloud. 
                    MariaDB est une base de données open source utilisée pour stocker et gérer des informations. Elle est similaire à MySQL, très populaire, et est conçue pour être rapide et fiable.
            <div class="image-container" >
                <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.wpsysadmin.com%2Fwp-content%2Fuploads%2F2021%2F07%2Fmariadb.png&f=1&nofb=1&ipt=2157fbaab1d79b2c86c84e834420aefc8f1b5cb8bbe7f221cfd424cfdb861073&ipo=images" alt="OpenLDAPimg" alt="Description">
            </div>
            </li>
            <li><strong>Nextcloud</strong> 
                Nextcloud est une plateforme de stockage et de partage de fichiers en ligne. Elle s'appuie sur MariaDB pour gérer les données et utilise un espace de stockage dédié pour sauvegarder les contenus des utilisateurs. Ce service permet aux utilisateurs de stocker, partager et accéder à leurs fichiers de manière sécurisée depuis n'importe quel appareil connecté à Internet.
            <div class="image-container" id="nextcloudimg">
                <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.marksei.com%2Fwp-content%2Fuploads%2F2016%2F12%2FNextcloud_Logo_White-1.jpg&f=1&nofb=1&ipt=c975197f2d406baf96acf6cbe4bf7b7e0d7a627638c18a653f9cb14bfcefb2fd&ipo=images" alt="OpenLDAPimg" alt="Description">
            </div>
            </li>
            <li class="grid-dolphin-logo"><strong>SQL Database Service</strong>Ce service, configuré dans le fichier Docker, met en place une base de données MySQL sur un serveur. Son rôle principal est de stocker, gérer et fournir un accès aux données pour d'autres applications ou services qui nécessitent une base de données SQL. De plus, il conserve les données de manière persistante à travers des volumes Docker.
            <div class="image-container" >
                <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fpngimg.com%2Fuploads%2Fmysql%2Fmysql_PNG19.png&f=1&nofb=1&ipt=1201ce48aaa7ec604b66e887a6ca991ff76e1d3b6f9265ec079b0ff26ff1fb87&ipo=images" alt="OpenLDAPimg" alt="Description">
            </div>
            </li>
            <li><strong>phpMyAdmin</strong>Une interface web pour la gestion de la base de données MySQL. Il est configuré pour se connecter au service de base de données MySQL précédemment mentionné, permettant une gestion facile de la base de données à travers une interface graphique.
            <div class="image-container" >
                <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fassets.stickpng.com%2Fimages%2F610672c22ced4d0004ead4e1.png&f=1&nofb=1&ipt=f001522c66fbe43c90063ac3e070e2aead66bc1e1b8bca2e3226de40572e4786&ipo=images" alt="OpenLDAPimg" alt="Description">
            </div>
            </li>

        

    </body>


 