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
        <form class="d-flex flex-column align-items-center" method="POST" action="../../../api/models/connection_et_inscription/traitement.php">
            <h1 class="mb-3">Inscription</h1>

            <!-- Champ Nom -->
            <label class="mb-1" for="nom">Votre nom</label>
            <input class="mb-3" type="text" name="nom" id="nom" placeholder="Entrer votre nom" required>

            <!-- Champ Prénom -->
            <label class="mb-1" for="prenom">Votre prénom</label>
            <input class="mb-3" type="text" name="prenom" id="prenom" placeholder="Entrer votre prénom" required>

            <!-- Champ Email -->
            <label class="mb-1" for="email">Votre email</label>
            <input class="mb-3" type="email" name="email" id="email" placeholder="Entrer votre email" required>

            <!-- Champ Téléphone -->
            <label class="mb-1" for="telephone">Votre numéro de téléphone</label>
            <input class="mb-3" type="text" name="telephone" id="telephone" placeholder="Entrer votre numéro de téléphone" required>

            <!-- Champ Avatar (optionnel, selon vos besoins) -->
            <label class="mb-1" for="avatar">Votre avatar (URL)</label>
            <input class="mb-3" type="text" name="avatar" id="avatar" placeholder="Entrer l'URL de votre avatar">

            <!-- Champ Date de naissance (optionnel, selon vos besoins) -->
            <label class="mb-1" for="birthDate">Votre date de naissance</label>
            <input class="mb-3" type="date" name="birthDate" id="birthDate">

            <!-- Champ Mot de passe -->
            <label class="mb-1" for="pass">Votre mot de passe</label>
            <input class="mb-3" type="password" name="pass" id="pass" placeholder="Entrer votre mot de passe" required>

            <!-- Bouton d'inscription -->
            <input type="submit" class="btn btn-primary" value="M'inscrire" name="ok">
        </form>
    </div>
</body>
</html>
