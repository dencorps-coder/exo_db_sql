<?php
    // 1. J'inclus le fichier de connexion à la base de données, qui me donne accès à la fonction DbConnexion()
    require_once "config/database.php";

    // 2. J'initialise un tableau vide pour stocker mes erreurs (par ex : mauvais email, mauvais mot de passe)
    $errors = [];

    // 3. J'initialise une variable $message pour stocker un éventuel message de retour à l'utilisateur (succès, etc.)
    $message = "";

    // 4. Je vérifie si le formulaire a été soumis en POST (c'est-à-dire si l'utilisateur a cliqué sur "Se connecter")
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        // 5. Je récupère l'email envoyé dans le formulaire, je supprime les espaces et j'échappe les caractères spéciaux HTML
        $email = trim(htmlspecialchars($_POST["email"]) ?? '');

        // 6. Je récupère le mot de passe envoyé dans le formulaire (pas de htmlspecialchars car c'est un mdp)
        $password = $_POST["password"] ?? '';
        
        // 7. Je vérifie que le mot de passe n'est pas vide, sinon j'ajoute une erreur au tableau
        if(empty($password)) {
            $errors[] = "le mdp est obligatoire";
        }

        // 8. Je vérifie que l'email n'est pas vide, sinon j'ajoute une erreur
        if(empty($email)) {
            $errors[] = "l'email est obligatoire";
        // 9. Je vérifie que l'email respecte bien le format "email" grâce à la fonction native filter_var()
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[] = "votre adresse ne correspond au format mail classique";
        }

// 10. Si aucune erreur, je poursuis la connexion
if (empty($errors)) {
    try {
        // 11. J'appelle la fonction de connexion à la base de données pour obtenir l'objet PDO
        $pdo = DbConnexion();
        // 12. Je prépare ma requête SQL pour trouver un utilisateur avec cet email
        $sql = "SELECT * FROM users WHERE email = ?";
        // 13. Je prépare la requête (protection contre les injections SQL)
        $requestDb = $pdo->prepare($sql);
        // 14. J'exécute la requête en passant l'email comme paramètre
        $requestDb->execute([$email]);
        // 15. Je récupère la première ligne trouvée sous forme de tableau associatif (ou false si rien trouvé)
        $user = $requestDb->fetch();

        // 16. Si j'ai bien trouvé un utilisateur avec cet email...
        if ($user) {
            // 17. Je vérifie si le mot de passe envoyé correspond au hash stocké en base (password_verify = fonction native PHP)
            if (password_verify($password, $user["password"])) {
                // 18. Si ok, je démarre la session et stocke les infos utilisateur
                session_start();
                $_SESSION["user_id"] = $user['id'];
                $_SESSION["username"] = $user['username'];
                $_SESSION["email"] = $user['email'];
                $_SESSION['loggin'] = true;

                $message = "super vous etes connecté " . htmlspecialchars($user['name']);
                header('location: home.php');
                exit();
            } else {
                $errors[] = "mot de passe pas bon ma gueule";
            }
        } else {
            $errors[] = "compte introuvable ma gueule";
        }
    } catch (PDOException $e) {
        $errors[] = "nous avons des problemes ma gueule: " . $e->getMessage();
    }
}
// 20. Fin du traitement du formulaire
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/style/style.css">
</head>
<body>
    <h1>Se connecter a notre merveilleux site</h1>
    <form action="" method="POST">
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required placeholder="Entrez votre email">
        </div>
        <div>
            <label for="password">password</label>
            <input type="password" name="password" id="password" required placeholder="entrer votre mdp">
        </div>
        <div>
            <input type="submit" value="Se connecter">
        </div>
    </form>
</body>
</html>