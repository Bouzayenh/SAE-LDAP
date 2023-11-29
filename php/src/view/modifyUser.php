<body>
    <h1> Modifier un utilisateur </h1>
    <form action="index.php" method="get">
        <input type="hidden" name="action" value="modifyUser">
        <input type="hidden" name="controller" value="LDAP">
        <input type="hidden" name="dn" value="<?
        if(isset($dn)){
            echo $dn;
        }
        ?>">
        <input type="text" name="user" placeholder=" Utilisateur" value="<?php 
        if(isset($user)){
            echo $user;
        }?>">
        <input type="text" name="nom" placeholder="Nom" value="<?php 
        if(isset($nom)){
            echo $nom;
        }?>">
        <input type="text" name="prenom" placeholder="Prenom" value="<?php 
        if(isset($prenom)){
            echo $prenom;
        } ?>" >
        <input type="text" name="mail" placeholder="Mail" value="<?php 
        if(isset($mail)){
            echo $mail;
        }?>" >
        
        <input type="submit" value="Ajouter">
    </form>
</body>