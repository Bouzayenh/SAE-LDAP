<body>
    <div class="users-container">
        <h1>Liste des Utilisateurs</h1>
        <div class="users-list">
            <?php
                require_once('../src/controller/ControllerLDAP.php');

                $users = App\LDAP\controller\ControllerLDAP::listUsers();
                if (!empty($users)) {
                    echo "<ul>";
                    foreach ($users as $user) {
                        $cn = isset($user['cn']) ? htmlspecialchars($user['cn']) : "Nom Inconnu";
                        $mail = isset($user['mail']) ? htmlspecialchars($user['mail']) : "Email Inconnu";
                        echo "<li><span><div><strong>Nom :</strong> " . $cn . "</div><div><strong>Mail :</strong> " . $mail . "</div></span> <span> <a href='index.php?controller=Default&action=modifyUser&user=".$user['uid']."&nom=".$user['cn']."&prenom=".$user['sn']."&mail=".$user['mail']."'><img src='". "/web/photos/modify.png"  ."'></a> </span> <span> <img src='". "/web/photos/delete.png"  ."'> </span> </li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>Aucun utilisateur trouvé.</p>";
                }
            ?>
        </div>
    </div>
</body>