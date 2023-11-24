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
        <h1 class="site-title">SAE-LDAP</h1>
        <nav class="main-nav">
            <ul class="nav-list">
                <li class="nav-item"><a href="index.php?action=homepage&controller=Default" class="nav-link">HomePage</a></li>
                <li class="nav-item"><a href="index.php?action=authentification&controller=Default" class="nav-link">Authentification</a></li>
                <li class="nav-item"><a href="index.php?action=createNewUser&controller=Default" class="nav-link">Ajouter un nouveau utilisateur</a></li>
            </ul>
        </nav>
    </header>
        <?php 
        
            require __DIR__ . "/{$cheminVueBody}"    

        ?>

</body>
</html>

