<?php
    
    // Fonction pour récupérer les informations d'une personne à partir de son email
    function getUserInfo($email) {
        // Charger l'autoloader de Composer
        require_once __DIR__ . '/../../../vendor/autoload.php';
    
        // Charger les variables d'environnement
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
        $dotenv->load();
    
        // Récupérer les variables d'environnement pour la connexion à la base de données
        $host    = $_ENV['DB_HOST'];
        $port    = $_ENV['DB_PORT'];
        $dbname  = $_ENV['DB_NAME'];
        $charset = $_ENV['DB_CHARSET'];
        $user    = $_ENV['DB_USER'];
        $pass    = $_ENV['DB_PASS'];
    
        try {
            // Connexion à la base de données avec PDO
            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";
            $db = new PDO($dsn, $user, $pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Préparer la requête SQL pour récupérer les informations de l'utilisateur
            $stmt = $db->prepare("SELECT * FROM User WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
    
            // Récupérer les résultats de la requête
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Si l'utilisateur existe, renvoyer ses informations
            if ($user) {
                return $user; // Retourne un tableau associatif avec les informations de l'utilisateur
            } else {
                return null; // Si l'utilisateur n'existe pas, retourner null
            }
        } catch (PDOException $e) {
            echo 'Erreur de connexion : ' . $e->getMessage();
            return null; // En cas d'erreur, retourner null
        }
    }

?>
    
