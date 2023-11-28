<?php 
if (!isset($_SESSION)){
    session_start();
}
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
    <header class="main-header">
        <a class="site-title" href="index.php?action=homepage&controller=Default">
            <h1>SAE-LDAP</h1>
        </a>
        <nav class="main-nav">
            <ul class="nav-list">
                <li class="nav-item"><a href="index.php?action=createNewUser&controller=Default" class="nav-link">Ajouter un utilisateur</a></li>
                <li class="nav-item"><a href="index.php?action=listAllUsers&controller=Default" class="nav-link">Liste des utilisateurs</a></li>
            </ul>
        </nav>
    </header>

        <?php 
            use App\LDAP\controller\ControllerDefault;

            if(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']){
                require __DIR__ . "/{$cheminVueBody}";
            }
            else {
                ControllerDefault::authentification("Votre session à expiré <br> Veuillez vous connecter à nouveaux");
            }

        ?>

</body>
</html>

