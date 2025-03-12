<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

// Vérifier si nous sommes sur Vercel (production) ou en local
if (getenv('VERCEL')) {
    // En production sur Vercel, utiliser les variables d'environnement de Vercel
    $host    = getenv('DB_HOST');
    $port    = getenv('DB_PORT');
    $dbname  = getenv('DB_NAME');
    $charset = getenv('DB_CHARSET');
    $user    = getenv('DB_USER');
    $pass    = getenv('DB_PASS');
} else {
    // En développement local, utiliser dotenv
    try {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../../');
        $dotenv->load();
        
        $host    = $_ENV['DB_HOST'];
        $port    = $_ENV['DB_PORT'];
        $dbname  = $_ENV['DB_NAME'];
        $charset = $_ENV['DB_CHARSET'];
        $user    = $_ENV['DB_USER'];
        $pass    = $_ENV['DB_PASS'];
    } catch (Exception $e) {
        echo 'Erreur de chargement des variables d\'environnement : ' . $e->getMessage();
        exit;
    }
}

try {
   $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";
   $db = new PDO($dsn, $user, $pass);
   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
   echo 'Erreur de connexion : ' . $e->getMessage() . "\n";
   exit;
}

?>
