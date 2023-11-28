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
                        echo "<li><strong>Nom :</strong> " . $cn . "<br><strong>Mail :</strong> " . $mail . "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>Aucun utilisateur trouvé.</p>";
                }
            ?>
        </div>
    </div>
</body>