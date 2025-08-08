<?php
require_once "config/database.php";

// Tableau pour stocker les messages d'erreur
$erreur = [];
$message = "";

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération et nettoyage des champs du formulaire
    $mail = trim(htmlspecialchars($_POST["mail"] ?? ''));
    $password = $_POST["password"] ?? '';

    // Vérification de l'email
    if (empty($mail)) {
        $erreur[] = "L'email doit être rempli";
    } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $erreur[] = "Votre adresse email n'est pas valide";
    }

    // Vérification du mot de passe
    if (empty($password)) {
        $erreur[] = "Le mot de passe est obligatoire";
    }

    // Si aucune erreur, on traite la connexion
    if (empty($erreur)) {
        $pdo = DbConnexion();
        $stmt = $pdo->prepare("SELECT id, name, first_name, email, password FROM users WHERE email = ?");
        $stmt->execute([$mail]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Connexion réussie, on démarre la session
            session_start();
            $_SESSION['loggin'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            header('Location: home.php');
            exit();
        } else {
            $erreur[] = "Identifiants invalides";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="asset/style/style.css">
</head>
<body>
    <header>
        <h1>Connexion</h1>
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
                <label for="mail">Email</label>
                <input type="email" id="mail" name="mail" placeholder="Entrez votre email" required>
            </div>
            <div>
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
            </div>
            <div>
                <input type="submit" value="Connexion">
            </div>
        </form>
    </section>
</body>
</html>