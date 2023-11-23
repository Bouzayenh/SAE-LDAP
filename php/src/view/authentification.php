<body>
    <h1> Authentification </h1>
    <form action="index.php" method="get">
        <input type="hidden" name="action" value="checkUser">
        <input type="hidden" name="controller" value="LDAP">
        <input type="text" name="user" placeholder="cn=user">
        <input type="password" name="pass" placeholder="Mot de Passe">
        <input type="submit" value="Se connecter">
    </form>
</body>
