<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><? echo $Pagetitle ?> </title>
    <link rel="stylesheet" href="styles.css"></link>
</head>
<body>
    <header class="main-header">
        <h1 class="site-title">SAE-LDAP</h1>
        <nav class="main-nav">
            <ul class="nav-list">
                <li class="nav-item"><a href="index.php?action=homepage&controller=Default" class="nav-link">HomePage</a></li>
                <li class="nav-item"><a href="index.php?action=authentification&controller=Default" class="nav-link">Authentification</a></li>
                <li class="nav-item"><a href="index.php?action=createNewUser&controller=Default">Ajouter un nouveau utilisateur</a></li>
            </ul>
        </nav>
    </header>
        <?php 
        
            require __DIR__ . "/{$cheminVueBody}"    

        ?>

</body>
</html>

