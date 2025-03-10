<?php
    // Variables mockup pour les informations utilisateur
    include __DIR__ . '/../../models/fonctions/recuperation_infos.php';
    $userInfos = getUserInfo("lb@la");
    
    // Extraction des données utilisateur
    // La fonction getUserInfo devrait retourner un tableau associatif
    if ($userInfos) {
        // Attribution des valeurs aux variables individuelles
        $last_name = $userInfos['surname'] ?? '';
        $first_name = $userInfos['name'] ?? '';
        $password = $userInfos['pass'] ?? '';
        $email = $userInfos['email'] ?? '';
        $phone_number = $userInfos['phone'] ?? '';
        $avatar = $userInfos['avatar'] ?? '';
        $birthDate = $userInfos['birthDate'] ?? '';
        $creationDate = $userInfos['creation_date'] ?? '';
        $lastModified = $userInfos['last_modified'] ?? '';
        $operatorLevel = $userInfos['operator_level'] ?? '';
    } else {
        // Valeurs par défaut si aucune donnée n'est trouvée
        $last_name = $first_name = $password = $email = $phone_number = '';
        $avatar = $birthDate = $creationDate = $lastModified = $operatorLevel = '';
    }
?>
<main class="bg-white w-full h-full rounded-tl-xl p-5">

    <form action="POST" aria-disabled="true" class="grid grid-cols-2 gap-4 [&_input:disabled]:bg-gray-200 [&_input:disabled]:text-gray-400">
        <div class="form-group">
            <label for="lastName">Nom</label>
            <input disabled type="text" id="last_name" value="<?= $last_name ?>" class="border p-2 w-full rounded">
        </div>
        
        <div class="form-group">
            <label for="firstName">Prénom</label>
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
            <label for="operatorLevel">Niveau d'opérateur</label>
            <input disabled type="text" id="operatorLevel" value="<?= $operatorLevel ?>" class="border p-2 w-full rounded">
        </div>
    </form>

</main>