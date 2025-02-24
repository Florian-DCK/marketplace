<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="">
    <div class="d-flex justify-content-center">
        <form class="d-flex flex-column align-items-center" method="POST" action="../../../api/models/connection_et_inscription/connection.php">
            <h1 class="mb-3">Connection</h1>

            <!-- Champ Email -->
            <label class="mb-1" for="email">Votre email</label>
            <input class="mb-3" type="email" name="email" id="email" placeholder="Entrer votre email" required>

            <!-- Champ Mot de passe -->
            <label class="mb-1" for="pass">Votre mot de passe</label>
            <input class="mb-3" type="password" name="pass" id="pass" placeholder="Entrer votre mot de passe" required>

            <!-- Bouton de connection -->
            <input type="submit" class="btn btn-primary" value="Me connecter" name="ok">
        </form>
    </div>
</body>
</html> 