
<?php
// 0 == L'adresse email existe déja


// db_connection.php

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

if (isset($_POST['ok'])) {
   // Récupération des données envoyées via POST
   $nom = $_POST['nom'];
   $prenom = $_POST['prenom'];
   $mdp = $_POST['pass'];
   $email = $_POST['email'];  // Assurez-vous d'ajouter ces champs dans votre formulaire HTML
   $telephone = $_POST['telephone'];
   $avatar = $_POST['avatar'];  // Ajoutez un champ avatar si nécessaire
   $birthDate = $_POST['birthDate'];
   $creation_date = date('Y-m-d H:i:s');  // Date actuelle pour la création
   $last_modified = $creation_date;  // Date actuelle pour la modification
   $isActive = 1;  // Par défaut l'utilisateur est actif
   $operator_level = 1;  // Vous pouvez définir ce niveau selon votre logique
   // Hachage du mot de passe pour plus de sécurité
   $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

   // Vérification si l'email existe déjà
   $stmt = $db->prepare("SELECT COUNT(*) FROM User WHERE email = :email");
   $stmt->execute(['email' => $email]);

   // Récupération du nombre d'enregistrements correspondant à l'email
   $count = $stmt->fetchColumn();

   // Si l'email existe déjà, afficher un message d'erreur
   if ($count > 0) {
      return "0"; 
   } else {
      // Si l'email n'existe pas, on procède à l'insertion
      $requete = $db->prepare("INSERT INTO User 
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

      echo "Inscription réussie"."<br>";
     
   }
}

?>
