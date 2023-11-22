<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><? echo $Pagetitle ?></title>
    </head>
    <body>
        <form action="index.php" method="get">
            <p> Choissisez S'il vous plait le service LDAP à utiliser </p>
            <input type="hidden" name="action" value="choixRepertoire">
            <input type="hidden" name="controller" value="LDAP">
            <select name = "dirOptions" id="choose_LDAP"> 
                <option value="Local"> LDAP Local </option>
                <option value="IUT"> LDAP de l'IUT </option>
            </select>
            <input type="submit">Choisir</button>
        </form>
    </body>
</html>