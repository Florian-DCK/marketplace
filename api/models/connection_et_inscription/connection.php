
<?php

// Charger l'autoloader de Composer
require_once __DIR__ . '/../../../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();


// Récupérer les variables d'environnement
$host    = $_ENV['DB_HOST'];
$port    = $_ENV['DB_PORT'];
$dbname  = $_ENV['DB_NAME'];
$charset = $_ENV['DB_CHARSET'];
$user    = $_ENV['DB_USER'];
$pass    = $_ENV['DB_PASS'];

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";
    $db = new PDO($dsn, $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie à la base de données.\n";
} catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage() . "\n";
    exit;
}

    $error_msg = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupération des données du formulaire
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        echo "Je suis de toute beauté";
    
        // Vérification que les champs sont non vides
        if ($email != "" && $password != "") {
            // Préparation de la requête pour vérifier l'email et le mot de passe
            $stmt = $db->prepare("SELECT * FROM User WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            echo    'Jesuis toujours aussi beau';
    
            // Récupération de l'utilisateur correspondant à l'email
            $user = $stmt->fetch();
    
            // Si l'utilisateur existe
            if ($user) {
                echo"Maintenant aussi";
                // Vérification du mot de passe
                if (password_verify($password, $user['pass'])) {
                    echo 'et la aussi';
                    // Redirection vers la page après connexion réussie
                    header("Location: ../../../api/index.php"); // Page d'accueil après connexion
                    echo"Maintenant aussi";
                    exit();
                } 
            } 
        } 
    }

?>





