<?
$error=[];

if($_SERVER["REQUEST_METHOD"]==="POST"){
    $name = trim(htmlspecialchars($_POST["name"] ?? ''));
    $first_name = trim(htmlspecialchars($_POST["first_name"] ?? ''));
    $mail = trim(htmlspecialchars($_POST["mail"] ?? ''));
    $password = $_POST["password"] ?? '';
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <h1>Hell</h1>
    </header>

    <section>

        <form action="Action"  method="POST">
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
        <div>

        </div>
    </section>
    
</body>
</html>