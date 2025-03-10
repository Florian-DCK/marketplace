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
} catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage() . "\n";
    exit;
}


function connection($email=null,$password=null){
    $error_msg = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupération des données du formulaire
    
        // Vérification que les champs sont non vides
        if ($email != "" && $password != "") {
            // Préparation de la requête pour vérifier l'email et le mot de passe
            $stmt = $GLOBALS['db']->prepare("SELECT * FROM User WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
    
            // Récupération de l'utilisateur correspondant à l'email
            $user = $stmt->fetch();
    
            // Si l'utilisateur existe
            if ($user) {
                // Vérification du mot de passe
                if (password_verify($password, $user['pass'])) {
                    // Redirection vers la page après connexion réussie
                    return true;
                } 
            } else {
                // erreur l'utilisateur n'existe pas 
                echo "Error user not found";
                return false;
            }
        } 
    }
}

function inscription($nom=null,$prenom=null,$mdp=null,$email=null,$telephone=null,$avatar=null,$birthDate=null){
    if (isset($_POST['ok'])) {
    // Récupération des données envoyées via POST
    $nom = $_POST['lastName'];
    $prenom = $_POST['firstName'];
    $mdp = $_POST['password'];
    $mdpConfirm = $_POST['confirmPassword'];
    $email = $_POST['email']; 
    $telephone = $_POST['phoneNumber'];
    $avatar = $_POST['avatar']; 
    $birthDate = $_POST['birthDate'];
    $creation_date = date('Y-m-d H:i:s');  // Date actuelle pour la création
    $last_modified = $creation_date;  // Date actuelle pour la modification
    $isActive = 1;  
    $operator_level = 1;  
    // Hachage du mot de passe pour plus de sécurité
    $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

    // Vérification si l'email existe déjà
    $stmt = $GLOBALS['db']->prepare("SELECT COUNT(*) FROM User WHERE email = :email");
    $stmt->execute(['email' => $email]);

    // Récupération du nombre d'enregistrements correspondant à l'email
    $count = $stmt->fetchColumn();

    // Si l'email existe déjà, afficher un message d'erreur
    if ($count > 0) {
        // Redirection vers la page d'inscription avec un message d'erreur
        return false;
    } else {
        // Si l'email n'existe pas, on procède à l'insertion
        $requete = $GLOBALS['db']->prepare("INSERT INTO User 
            (id, name, surname, email, phone, avatar, birthDate, creation_date, last_modified, isActive, pass, operator_level) 
            VALUES 
            (0, :name, :surname, :email, :phone, :avatar, :birthDate, :creation_date, :last_modified, :isActive, :pass, :operator_level)");

        // Exécution de la requête avec les paramètres
        $requete->execute(array(
            ":name" => $nom,
            ":surname" => $prenom,
            ":email" => $email,
            ":phone" => $telephone,
            ":avatar" => $avatar,
            ":birthDate" => $birthDate,
            ":creation_date" => $creation_date,
            ":last_modified" => $last_modified,
            ":isActive" => $isActive,
            ":pass" => $mdp_hash,
            ":operator_level" => $operator_level,
        ));

        return true;
    }
}
}
?>





