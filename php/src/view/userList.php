<body>
    <div class="users-container">
        <h1>Liste des Utilisateurs</h1>
        <div>
            <a href="index.php?action=createNewUser&controller=Default"><img src="/web/photos/add.svg" alt="ajouter utilisateur"></a>
        </div>
        <div class="users-list">
            <?php
                require_once('../src/controller/ControllerLDAP.php');

                $users = App\LDAP\controller\ControllerLDAP::listUsers();
                if (!empty($users)) {
                    echo "<ul>";
                    foreach ($users as $user) {
                        $cn = isset($user['cn']) ? htmlspecialchars($user['cn']) : "Nom Inconnu";
                        $mail = isset($user['mail']) ? htmlspecialchars($user['mail']) : "Email Inconnu";
                        echo "<li><span><div><strong>Nom :</strong> " . $cn . "</div><div><strong>Mail :</strong> " . $mail . "</div></span> <span> <a href='index.php?controller=Default&action=modifyUser&user=".$user['uid']."&nom=".$user['cn']."&prenom=".$user['sn']."&mail=".$user['mail']."&dn=".$user['dn']."'><img src='/web/photos/modify.png'></a> </span> <span> <a href='index.php?action=deleteUser&controller=LDAP&dn=".$user['dn']."'><img src='/web/photos/delete.png'></a></span></li>";
                        
                    }
                    echo "</ul>";
                } else {
                    echo "<p>Aucun utilisateur trouvé.</p>";
                }
            ?>
        </div>
    </div>
</body>