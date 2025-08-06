<?php

// Paramètres de connexion à la base de données
$host = "localhost";         // Adresse du serveur MySQL (localhost pour local)
$dbname = "db2";             // Nom de la base de données à laquelle se connecter
$username = "root";          // Nom d'utilisateur MySQL (root par défaut en local)
$password = "";              // Mot de passe MySQL (souvent vide en local)
$port = 3306;                // Port de connexion MySQL (3306 par défaut)
$charset = "utf8mb4";        // Encodage utilisé pour la connexion (utf8mb4 conseillé)

// Déclaration de la fonction de connexion à la base de données
function DbConnexion() {
    // Permet d'utiliser les variables définies en dehors de la fonction (portée globale)
    global $host, $dbname, $username, $password, $port, $charset;

    try {
        // Prépare la chaîne de connexion DSN pour PDO (spécifie le type de base, l’hôte, le nom, le charset et le port)
        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset;port=$port";
        // Crée une nouvelle connexion PDO avec le DSN, le nom d'utilisateur et le mot de passe
        $pdo = new PDO($dsn, $username, $password);
        // Configure PDO pour lancer une exception en cas d’erreur SQL
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Définit le mode de récupération des résultats (ici : tableau associatif)
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        // Retourne l’objet de connexion PDO pour pouvoir l’utiliser ailleurs
        return $pdo;
    } catch(PDOException $e) {
        // En cas d’erreur de connexion, arrête le script et affiche le message d’erreur
        die("Erreur durant la co à la db : " . $e->getMessage());
    }
}

// Appel de la fonction pour obtenir l’objet PDO (et donc établir la connexion)
$pdo = DbConnexion();

// Affiche un message si la connexion a réussi (si on arrive à cette ligne, c’est que la connexion est OK)
echo "Connexion réussie à la base de données !";
?>

