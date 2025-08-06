<?php
$erreur = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim(htmlspecialchars($_POST["name"] ?? ''));
    $first_name = trim(htmlspecialchars($_POST["first_name"] ?? ''));
    $mail = trim(htmlspecialchars($_POST["mail"] ?? ''));
    $password = $_POST["password"] ?? '';

    // Vérification du nom
    if (empty($name)) {
        $erreur[] = "Le nom doit être rempli";
    } else {
        if (strlen($name) < 3) {
            $erreur[] = "Veuillez mettre plus de caractères dans le nom";
        }
        if (strlen($name) > 55) {
            $erreur[] = "Limite de caractères dépassée pour le nom";
        }
    }

    // Vérification du prénom
    if (empty($first_name)) {
        $erreur[] = "Le prénom doit être rempli";
    }

    // Vérification de l'email
    if (empty($mail)) {
        $erreur[] = "L'email doit être rempli";
    } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $erreur[] = "Votre adresse email n'est pas valide";
    }

    // Vérification du mot de passe
    if (empty($password)) {
        $erreur[] = "Le mot de passe doit être rempli";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Formulaire</title>
</head>

<body>
    <header>

        <h1>Fomulaire</h1>

    </header>


    <section class="boxform">
        <form action="" method="POST">
            <div>
                <label for="name">nom</label>
                <input type="text" id="name" name="name" required>

                <label for="first_name">Prenom</label>
                <input type="text" id="first_name" name="first_name" required>

                <label for="mail">Mail</label>
                <input type="email" id="mail" name="mail" required>
            </div>
            <div>
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <input type="submit" value="envoyer">
            </div>

        </form>

    </section>



</body>
</html>