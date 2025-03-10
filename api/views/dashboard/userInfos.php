<?php
    // Variables mockup pour les informations utilisateur
    $last_name = "Dupont";
    $first_name = "Jean";
    $password = "••••••••";
    $email = "jean.dupont@exemple.com";
    $phone_number = "06 12 34 56 78";
    $avatar = "https://via.placeholder.com/150";
    $birthDate = "15/05/1985";
    $creationDate = "01/03/2023";
    $lastModified = "10/03/2025";
    $pass = "Premium";
    $operatorLevel = "Utilisateur";
?>
<main class="bg-white w-full h-full rounded-tl-xl p-5">

    <form action="POST" aria-disabled="true" class="grid grid-cols-2 gap-4 [&_input:disabled]:bg-gray-200 [&_input:disabled]:text-opacity-20">
        <div class="form-group">
            <label for="last_name">Nom</label>
            <input disabled type="text" id="last_name" value="<?= $last_name ?>" class="border p-2 w-full rounded">
        </div>
        
        <div class="form-group">
            <label for="first_name">Prénom</label>
            <input disabled type="text" id="first_name" value="<?= $first_name ?>" class="border p-2 w-full rounded">
        </div>
        
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input disabled type="password" id="password" value="<?= $password ?>" class="border p-2 w-full rounded">
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input disabled type="email" id="email" value="<?= $email ?>" class="border p-2 w-full rounded">
        </div>
        
        <div class="form-group">
            <label for="phone_number">Téléphone</label>
            <input disabled type="tel" id="phone_number" value="<?= $phone_number ?>" class="border p-2 w-full rounded">
        </div>
        
        <div class="form-group">
            <label for="avatar">Avatar</label>
            <input disabled type="text" id="avatar" value="<?= $avatar ?>" class="border p-2 w-full rounded">
        </div>
        
        <div class="form-group">
            <label for="birthDate">Date de naissance</label>
            <input disabled type="text" id="birthDate" value="<?= $birthDate ?>" class="border p-2 w-full rounded">
        </div>
        
        <div class="form-group">
            <label for="creationDate">Date de création</label>
            <input disabled type="text" id="creationDate" value="<?= $creationDate ?>" class="border p-2 w-full rounded" disabled>
        </div>
        
        <div class="form-group">
            <label for="lastModified">Dernière modification</label>
            <input disabled type="text" id="lastModified" value="<?= $lastModified ?>" class="border p-2 w-full rounded" disabled>
        </div>
        
        <div class="form-group">
            <label for="pass">Pass</label>
            <input disabled type="text" id="pass" value="<?= $pass ?>" class="border p-2 w-full rounded">
        </div>
        
        <div class="form-group">
            <label for="operatorLevel">Niveau d'opérateur</label>
            <input disabled type="text" id="operatorLevel" value="<?= $operatorLevel ?>" class="border p-2 w-full rounded">
        </div>
    </form>

</main>