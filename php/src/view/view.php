<?php
if(!session_id())
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $Pagetitle; ?></title>
    <link rel="stylesheet" type="text/css" href="../src/assets/styles.css">
</head>
<body>
<?
    echo "Before Session Check";
    if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        require __DIR__."/notificationpopup.php";
    }
    if(isset($_SESSION['error_message'])){
        echo $_SESSION['error_message'];
        require __DIR__."/errorpopup.php";
    }
    ?>

    <header class="main-header">
        <a class="site-title" href="index.php?action=homepage&controller=Default">
            <h1>SAE-LDAP</h1>
        </a>
        <nav class="main-nav">
            <ul class="nav-list">
                <li class="nav-item"><a href="index.php?action=createNewUser&controller=Default" class="nav-link">Ajouter un utilisateur</a></li>
                <li class="nav-item"><a href="index.php?action=listAllUsers&controller=Default" class="nav-link">Liste des utilisateurs</a></li>
                <li class="nav-item"><a class="nav-link" id="logoutButton">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

        <?php 
            
            require __DIR__ . "/{$cheminVueBody}";
        
        ?>

</body>

<script src="http://localhost:8082/js/keycloak.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@beta/dist/js.cookie.min.js"></script>
<script src="../web/js/keycloak-auth.js" type="module" async></script>

</html>
