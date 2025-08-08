<?php
require_once "config/database.php";

// Tableau pour stocker les messages d'erreur
$erreur = [];
$message = "";

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération et nettoyage des champs du formulaire
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
        $erreur[] = "Le mot de passe est obligatoire";
    } elseif (strlen($password) < 3) {
        $erreur[] = "Le mot de passe est trop court";
    }

    // Si aucune erreur, on traite l'inscription
    if (empty($erreur)) {
        // Connexion à la base de données
        $pdo = DbConnexion();

        // Vérifier si l'adresse mail est déjà utilisée
        $checkEmail = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $checkEmail->execute([$mail]);

        if ($checkEmail->rowCount() > 0) {
            $erreur[] = "Email déjà utilisé";
        } else {
            // Hashage du mot de passe
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insertion des données en base
            $insertUser = $pdo->prepare("
                INSERT INTO users (name, first_name, email, password)
                VALUES (?, ?, ?, ?)
            ");
            $insertUser->execute([$name, $first_name, $mail, $hashPassword]);

            $message = "Super, vous êtes enregistré $name !";
        }
    }
}


?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/style/style.css">
    <title>Formulaire</title>
</head>

<body>
    <header>

        <h1>Fomulaire</h1>

    </header>


    <section class="boxform">
        <form action="" method="POST">
            <?php
            // Affichage des erreurs
            foreach ($erreur as $error) {
                echo '<div class="error">' . htmlspecialchars($error) . '</div>';
            }
            // Affichage du message de succès
            if (!empty($message)) {
                echo '<div class="success">' . htmlspecialchars($message) . '</div>';
            }
            ?>

            <div>
                <label for="name">Nom</label>
                <input type="text" id="name" name="name" placeholder="Entrez votre nom" required>
            </div>
            <div>
                <label for="first_name">Prénom</label>
                <input type="text" id="first_name" name="first_name" placeholder="Entrez votre prénom" required>
            </div>
            <div>
                <label for="mail">Email</label>
                <input type="email" id="mail" name="mail" placeholder="Entrez votre email" required>
            </div>
            <div>
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
            </div>
            <div>
                <input type="submit" value="Envoyer">
            </div>

        </form>

    </section>



</body>
</html>