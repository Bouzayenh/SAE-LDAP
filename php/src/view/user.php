<body>
    <h1>Profil Utilisateur</h1>
    
    <?php
    // Imaginons que vous avez déjà récupéré les données de l'utilisateur dans des variables PHP
    $nom = "Nom de l'Utilisateur"; // Remplacer par la variable appropriée
    $prenom = "Prénom de l'Utilisateur"; // Remplacer par la variable appropriée
    $email = "email@exemple.com"; // Remplacer par la variable appropriée
    $motdepasse = "motdepasse"; // Remplacer par la variable appropriée
    ?>

    <h2>Informations de l'utilisateur</h2>
    <ul>
        <li>Nom: <?php echo $nom; ?></li>
        <li>Prénom: <?php echo $prenom; ?></li>
        <li>Adresse mail: <?php echo $email; ?></li>
        <li>Mot de passe: <?php echo $motdepasse; ?></li>
    </ul>

    <h2>Modifier les informations</h2>
    <form action="chemin_du_script_de_traitement.php" method="post">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="<?php echo $nom; ?>"><br>

        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo $prenom; ?>"><br>

        <label for="email">Adresse mail:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>"><br>

        <label for="motdepasse">Nouveau mot de passe:</label>
        <input type="password" id="motdepasse" name="motdepasse"><br>

        <input type="submit" value="Mettre à jour">
    </form>
</body>

