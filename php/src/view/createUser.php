<body>
    <? if(isset($errormessage)){
        require __DIR__."errorpopup.php";
    } ?>
    <h1 class="titlecreateuser" > Créer un utilisateur </h1>
    <form action="index.php" method="get">
        <input type="hidden" name="action" value="createNewUser">
        <input type="hidden" name="controller" value="LDAP">
        <input type="text" name="user" placeholder="username">
        <input type="text" name="nom" placeholder=" Nom " >
        <input type="text" name="prenom" placeholder=" Prénom " >
        <input type="text" name="mail" placeholder=" Mail " >
        <input type="password" name="pass" placeholder="Mot de Passe">
        
        <input type="submit" value="Ajouter">
    </form>
</body>