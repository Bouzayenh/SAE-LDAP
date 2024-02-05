<body>
    <h1>Profil Utilisateur</h1>
    
    <?php
    if(!isset($uid)){
        echo "UID is not set ! ";
    }

    $user = App\LDAP\controller\ControllerLDAP::getUser($uid);
    
    // Imaginons que vous avez déjà récupéré les données de l'utilisateur dans des variables PHP
    
    $nom = isset($user['sn']) ? htmlspecialchars($user['sn']): "Prenom Inconnu"; 
    $prenom = isset($user['cn']) ? htmlspecialchars($user['cn']): "Utilisateur Inconnu"; 
    $utilisateur = isset($user['uid']) ? htmlspecialchars($user['uid']): "Utilisateur Inconnu"; 
    $email = isset($user['mail']) ? htmlspecialchars($user['mail']) : "Email Inconnu";
    $dn = isset($user['dn']) ? htmlspecialchars($user['dn']) : "Dn Inconnu";
    ?>

    <h2>Modifier les informations</h2>
    
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="modifyUser">
        <input type="hidden" name="controller" value="LDAP">
        <input type="hidden" name="dn" value="<? echo $dn ?>">
        
        <label for="nom">Utilisateur:</label>
        <input type="text" name="user" value="<? echo $uid ?>">

        <label for="nom">Nom:</label>
        <input type="text" name="nom" value="<?php echo $nom; ?>"><br>

        <label for="prenom">Prénom:</label>
        <input type="text" name="prenom" value="<?php echo $prenom; ?>"><br>

        <label for="email">Adresse mail:</label>
        <input type="text" name="mail" value="<?php echo $email; ?>"><br>


        <input type="submit" value="Mettre à jour">
    </form>
</body>
