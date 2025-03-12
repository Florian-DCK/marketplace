<?php
header('Content-Type: application/json');

// Vérification que la requête est en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

include_once __DIR__ . '/../models/users/crudUsersModel.php';

$userEmail = $_POST['userEmail'] ?? null;

if (!$userEmail) {
    echo json_encode(['success' => false, 'message' => 'Email utilisateur manquant']);
    exit;
}

$allowedFields = ['lastName', 'firstName', 'email', 'phoneNumber', 'avatar', 'birthDate'];

$updatedData = [];
foreach ($allowedFields as $field) {
    if (isset($_POST[$field])) {
        $updatedData[$field] = $_POST[$field];
    }
}

if (empty($updatedData)) {
    echo json_encode(['success' => false, 'message' => 'Aucune donnée valide à mettre à jour']);
    exit;
}

try {
    // Récupérer l'ID de l'utilisateur à partir de son email
    $stmt = $db->prepare("SELECT id FROM User WHERE email = :email");
    $stmt->execute([':email' => $userEmail]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'Utilisateur non trouvé']);
        exit;
    }
    
    $userId = $user['id'];
    $success = true;
    $errors = [];
    
    // Traitement de chaque champ modifié
    foreach ($updatedData as $field => $value) {
        switch ($field) {
            case 'lastName':
                try {
                    updateSurname($db, $userId, $value);
                } catch (Exception $e) {
                    $success = false;
                    $errors[] = "Erreur lors de la mise à jour du nom: " . $e->getMessage();
                }
                break;
                
            case 'firstName':
                try {
                    updateName($db, $userId, $value);
                } catch (Exception $e) {
                    $success = false;
                    $errors[] = "Erreur lors de la mise à jour du prénom: " . $e->getMessage();
                }
                break;
                
            case 'email':
                try {
                    updateEmail($db, $value, $userId);
                } catch (Exception $e) {
                    $success = false;
                    $errors[] = "Erreur lors de la mise à jour de l'email: " . $e->getMessage();
                }
                break;
                
            case 'phoneNumber':
                try {
                    updatePhone($db, $value, $userId);
                } catch (Exception $e) {
                    $success = false;
                    $errors[] = "Erreur lors de la mise à jour du téléphone: " . $e->getMessage();
                }
                break;
                
            case 'avatar':
                try {
                    updateAvatar($db, $userId, $value);
                } catch (Exception $e) {
                    $success = false;
                    $errors[] = "Erreur lors de la mise à jour de l'avatar: " . $e->getMessage();
                }
                break;
                
            case 'birthDate':
                try {
                    // Todo updateBirthDate($db, $userId, $value);
                    $success = false;
                    $errors[] = "La mise à jour de la date de naissance n'est pas encore implémentée";
                } catch (Exception $e) {
                    $success = false;
                    $errors[] = "Erreur lors de la mise à jour de la date de naissance: " . $e->getMessage();
                }
                break;
        }
    }
    
    if ($success) {
        echo json_encode(['success' => true, 'message' => 'Utilisateur mis à jour avec succès']);
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'Des erreurs se sont produites lors de la mise à jour', 
            'errors' => $errors
        ]);
    }
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur de base de données: ' . $e->getMessage()]);
}
?>