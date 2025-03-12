<?php
    include __DIR__ . '/../../models/users/getInfosModel.php';

    $userEmail = isset($_GET['userEmail']) ? $_GET['userEmail'] : null;
    $userEmail != null ? $userInfos = getUserInfo($userEmail): $userInfos = null;
    
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
        $last_name = $first_name = $password = $email = $phone_number = 'Not Found';
        $avatar = $birthDate = $creationDate = $lastModified = $operatorLevel = 'Not Found';
    }
?>
<main class="bg-white w-full h-full rounded-tl-xl p-5">
    <form action="dashboard.php" method="GET" class="grid grid-cols-2 gap-4 [&_input:disabled]:bg-gray-200 [&_input:disabled]:text-gray-400">
        <div class="form-group">
            <label for="userEmail">Email de l'utilisateur :</label>
            <input type="text" name="userEmail" id="userEmail" value="<?= $userEmail ?>" class="border p-2 w-full rounded">
        </div>
        <div class="form-group flex items-end">
            <input type="hidden" name="page" value="userInfos">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Rechercher</button>
        </div>
    </form> 
    <form action="../../controllers/UpdateUserData.php" method="POST" aria-disabled="true" class="grid grid-cols-2 gap-4 [&_input:disabled]:bg-gray-200 [&_input:disabled]:text-gray-400">
        <div class="form-group">
            <label for="lastName">Nom</label>
            <input disabled type="text" id="lastName" value="<?= $last_name ?>" name="lastName" class="border p-2 w-full rounded editable" data-original="<?= $last_name ?>">
        </div>
        
        <div class="form-group">
            <label for="firstName">Prénom</label>
            <input disabled type="text" id="firstName" value="<?= $first_name ?>" name="firstName" class="border p-2 w-full rounded editable" data-original="<?= $first_name ?>">
        </div>
        
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input disabled type="password" id="password" value="<?= $password ?>" name="password" class="border p-2 w-full rounded" data-original="<?= $password ?>">
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input disabled type="email" id="email" value="<?= $email ?>" name="email" class="border p-2 w-full rounded editable" data-original="<?= $email ?>">
        </div>
        
        <div class="form-group">
            <label for="phone_number">Téléphone</label>
            <input disabled type="tel" id="phoneNumber" value="<?= $phone_number ?>" name="phoneNumber" class="border p-2 w-full rounded editable" data-original="<?= $phone_number ?>">
        </div>
        
        <div class="form-group">
            <label for="avatar">Avatar</label>
            <input disabled type="text" id="avatar" value="<?= $avatar ?>" name="avatar" class="border p-2 w-full rounded editable" data-original="<?= $avatar ?>">
        </div>
        
        <div class="form-group">
            <label for="birthDate">Date de naissance</label>
            <input disabled type="text" id="birthDate" value="<?= $birthDate ?>" name="birthDate" class="border p-2 w-full rounded editable" data-original="<?= $birthDate ?>">
        </div>
        
        <div class="form-group">
            <label for="creationDate">Date de création</label>
            <input disabled type="text" id="creationDate" value="<?= $creationDate ?>" name="creationDate" class="border p-2 w-full rounded" data-original="<?= $creationDate ?>">
        </div>
        
        <div class="form-group">
            <label for="lastModified">Dernière modification</label>
            <input disabled type="text" id="lastModified" value="<?= $lastModified ?>" name="lastModified" class="border p-2 w-full rounded" data-original="<?= $lastModified ?>">
        </div>
        
        <div class="form-group">
            <label for="operatorLevel">Niveau d'opérateur</label>
            <input disabled type="text" id="operatorLevel" value="<?= $operatorLevel ?>" name="operatorLevel" class="border p-2 w-full rounded " data-original="<?= $operatorLevel ?>">
        </div>
        <button type="button" id="editButton" class="bg-red-400 text-white px-4 py-2 rounded" onclick="toggleEdit()">modifier</button>
        <button type="submit" id="confirmButton" class="bg-green-400 text-white px-4 py-2 rounded hidden" >Confirmer</button>
    </form>
    <script>
        // Variable pour suivre l'état d'édition
        let isEditing = false;
        
        // Fonction d'initialisation à exécuter au chargement de la page
        function initFormState() {
            const fields = document.querySelectorAll('.editable');
            const confirmButton = document.getElementById('confirmButton');
            const editButton = document.getElementById('editButton');
            
            fields.forEach(field => {
                field.disabled = true;
            });
            
            editButton.textContent = 'modifier';
            confirmButton.classList.add('hidden');
            
            isEditing = false;
        }

        function toggleEdit() {
            const fields = document.querySelectorAll('.editable');
            const confirmButton = document.getElementById('confirmButton');
            const editButton = document.getElementById('editButton');
            
            isEditing = !isEditing;
            
            if (isEditing) {
                fields.forEach(field => {
                    field.disabled = false;
                });
                editButton.textContent = 'Annuler';
                confirmButton.classList.remove('hidden');
            } else {
                fields.forEach(field => {
                    field.disabled = true;
                    field.value = field.getAttribute('data-original');
                });
                editButton.textContent = 'modifier';
                confirmButton.classList.add('hidden');
            }
        }

        // Ajouter un écouteur d'événement pour le formulaire
        document.querySelector('form[action="../../controllers/UpdateUserData.php"]').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const editableFields = document.querySelectorAll('.editable');
            
            const formData = new FormData();
            
            formData.append('userEmail', '<?= $email ?>');
            
            let hasChanges = false;
            
            // Vérifier chaque champ modifiable
            editableFields.forEach(field => {
                const originalValue = field.getAttribute('data-original');
                const currentValue = field.value;
                
                if (currentValue !== originalValue) {
                    formData.append(field.name, currentValue);
                    hasChanges = true;
                }
            });
            
            // Si aucun changement, ne pas soumettre le formulaire
            if (!hasChanges) {
                alert('Aucune modification détectée.');
                return;
            }
            
            // Envoi des données modifiées au serveur via fetch
            fetch('../../controllers/UpdateUserData.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Modifications enregistrées avec succès !');
                    editableFields.forEach(field => {
                        if (formData.has(field.name)) {
                            field.setAttribute('data-original', field.value);
                        }
                    });
                    toggleEdit();
                } else {
                    alert('Erreur lors de la mise à jour: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors de la mise à jour.');
            });
        });
        
        // Exécuter l'initialisation au chargement de la page
        document.addEventListener('DOMContentLoaded', initFormState);
    </script>
</main>