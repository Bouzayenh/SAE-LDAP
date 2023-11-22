<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><? echo $Pagetitle ?></title>
</head>
<body>
    <h1> Authentification <? echo $directory ?></h1>
    <form action="index.php" method="get">
        <input type="hidden" name="action" value="checkUser">
        <input type="hidden" name="controller" value="LDAP">
        <input type="text" name="user" placeholder="cn=user">
        <input type="password" name="pass" placeholder="Mot de Passe">
        <input type="submit" value="Se connecter">
    </form>
</body>
</html>