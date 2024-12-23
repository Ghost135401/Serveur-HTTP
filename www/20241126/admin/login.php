<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/style4.css">
</head>
<body>
    <div class="login-container">
        <h2>Connexion</h2>
        <form action="traitement.php" method="post">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" value="admin" required>
            
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" value="admin" required>
            
            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>