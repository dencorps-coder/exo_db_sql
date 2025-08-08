<?php
require_once "config/database.php";

$erreur = [];

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $name = trim(htmlspecialchars($_POST["username"] ?? ''));
    $first_name = trim(htmlspecialchars($_POST["first_name"] ?? ''));
    $mail = trim(htmlspecialchars($_POST["mail"] ?? ''));
    $password = $_POST["password"] ?? '';
}
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
            $erreur[] = "password obligatoire";
        }elseif ( strlen($password) < 3 ) {
            $erreur[] = "password trop juste";
}
  if (empty($erreur))  {

              //logique de traitement en db
            $pdo = DbConnexion();

            //verifier si l'adresse mail est utilisé ou non
            $checkEmail = $pdo->prepare("SELECT id FROM users WHERE email = ?");

            //la methode execute de mon objet pdo execute la request préparée
            $checkEmail->execute([$mail]);

            //une condition pour vérifier si je recupere quelque chose
            if ($checkEmail->rowCount() > 0) {
                $erreur[] = "email déja utilisé";
            } else {
                //dans le cas ou tout va bien ! email pas utilisé

                //hashage du mdp avec la fonction password_hash
                $hashPassword = password_hash($password, PASSWORD_DEFAULT);

                //insertion des données en db
                // INSERT INTO users (username, email, password)VALUES ("atif","atif@gmail.com","lijezfoifjerlkjf")
                $insertUser = $pdo->prepare("
                INSERT INTO users (name,first_name, email, password) 
                VALUES (?, ?, ?,?)
                ");

                $insertUser->execute([$name, $mail, $first_name, $hashPassword]);

                $message = "super mega cool vous êtes enregistré $name";
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
            foreach ($erreur as $error) {
                    echo $error;
                }
                if(!empty($message)) 
                    echo $message;
            ?>
            <div>
                <label for="username">Pseudo</label>
                <input type="text" id="username" name="username" placeholder="Entrez votre pseudo" required>
            </div>
            <div>
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