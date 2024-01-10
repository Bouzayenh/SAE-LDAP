<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $Pagetitle; ?></title>
    <link rel="stylesheet" type="text/css" href="../src/assets/styles.css">
</head>
<body>
    
    <?php 
        if (isset($errormessage)){
            include __DIR__."/errorpopup.php";
        }
        if(isset($_SESSION)) {
            session_destroy();
        }
    ?>

    <h1  id="login"  > Authentification </h1>
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="checkUser">
        <input type="hidden" name="controller" value="LDAP">
        <input type="text" name="user" placeholder="cn=user">
        <input type="password" name="pass" placeholder="Mot de Passe">
        <input type="submit" value="Se connecter">
    </form>
</body>
</html>
