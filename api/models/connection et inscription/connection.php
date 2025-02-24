
<?php

$db = "marketPlaceWorkshop";

try {
    $db = new PDO('mysql:host=51.91.12.160;port=9109;dbname=marketPlaceWorkshop;charset=utf8', 'malacort_antoine', 'lWqUip20QangrHzH');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage() . "\n";
    exit;
}

    $error_msg = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupération des données du formulaire
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['pass']) ? $_POST['pass'] : '';
    
        // Vérification que les champs sont non vides
        if ($email != "" && $password != "") {
            // Préparation de la requête pour vérifier l'email et le mot de passe
            $stmt = $db->prepare("SELECT * FROM User WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
    
            // Récupération de l'utilisateur correspondant à l'email
            $user = $stmt->fetch();
    
            // Si l'utilisateur existe
            if ($user) {
                // Vérification du mot de passe
                if (password_verify($password, $user['pass'])) {
                    // Redirection vers la page après connexion réussie
                    header("Location: page.html.php"); // Page d'accueil après connexion
                    exit();
                } 
            } 
        } 
    }

?>





