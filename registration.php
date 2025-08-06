<?

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"] ?? '';
    $first_name = $_POST["first_name"] ?? '';
    $mail = $_POST["mail"] ?? '';
    $password = $_POST["password"] ?? '';

    $erreur = [];  
   if (empty($name)) {
        $erreur[] = "ce champ doit etre rempli";
   }
    if(empty($first_name)) { 
        $erreur[] = "ce champ doit etre rempli";
    }
    if(empty($mail)) 
        $erreur[] = "ce champ doit etre rempli";

    if(empty($password)) {
        $erreur[] = "ce champ doit etre rempli";
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