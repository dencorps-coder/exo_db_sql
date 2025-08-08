<?php 
// Démarre la session
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['loggin']) || $_SESSION['loggin'] !== true) {
    header('Location: login.php');
    exit();
}

// Déconnexion si demandé
if (isset($_GET['logout']) && $_GET['logout'] === '1') {
    $_SESSION = [];
    session_destroy();
    // Redirige vers la page de connexion après déconnexion
    header('Location: login.php');
    exit();
}

// Récupère les infos utilisateur depuis la session
$user_id = $_SESSION['user_id'] ?? 'inconnu';
$username = $_SESSION['username'] ?? 'non renseigné';
$email = $_SESSION['email'] ?? "pas d'email";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déconnexion</title>
    <link rel="stylesheet" href="asset/style/style.css">
</head>
<body>
    <header>
        <h1>Mon site d'authentification PHP</h1>
        <!-- Message personnalisé avec les infos de la session -->
        <span><?= "Bienvenue " . htmlspecialchars($username) . ", vous êtes connecté avec l'adresse mail " . htmlspecialchars($email); ?></span>
        <nav>
            <ul>
                <li>
                    <a href="home.php">Accueil</a>
                </li>
                <li>
                    <a href="logout.php?logout=1">Déconnexion</a>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Bienvenue sur votre espace personnel</h2>
        <p>Vous pouvez naviguer sur le site ou vous déconnecter.</p>
    </main>
</body>
</html>
                <li>

                    <a href="home.php?logout=1">deco</a>

                </li>

