<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs LDAP</title>
    <link rel="stylesheet" type="text/css" href="../src/assets/styles.css">
</head>
<body>
    <h1>Liste des Utilisateurs</h1>
    <div class="users-list">
        <?php
            require_once('../src/controller/ControllerLDAP.php');

            $users = App\LDAP\controller\ControllerLDAP::listUsers();
            if (!empty($users)) {
                echo "<ul>";
                foreach ($users as $user) {
                    echo "<li>" . htmlspecialchars($user['cn'][0]) . " (" . htmlspecialchars($user['mail'][0]) . ")</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>Aucun utilisateur trouvé.</p>";
            }
        ?>
    </div>
</body>
</html>
