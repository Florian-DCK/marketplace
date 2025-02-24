<?php

// db_connection.php

$db = "marketPlaceWorkshop";

try {
   $db = new PDO('mysql:host=51.91.12.160;port=9109;dbname=marketPlaceWorkshop;charset=utf8', 'malacort_antoine', 'lWqUip20QangrHzH');
   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   echo "Connexion réussie à la base de données.\n";
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

   // Requête préparée
   $requete = $db->prepare("INSERT INTO User 
      (id, name, surname, email, phone, avatar, birthDate, creation_date, last_modified, isActive, pass, operator_level) 
      VALUES 
      (0, :nom, :prenom, :email, :telephone, :avatar, :birthDate, :creation_date, :last_modified, :isActive, :pass, :operator_level)");

   // Exécution de la requête avec les paramètres
   $requete->execute(array(
      ":nom" => $nom,
      ":prenom" => $prenom,
      ":email" => $email,
      ":telephone" => $telephone,
      ":avatar" => $avatar,
      ":birthDate" => $birthDate,
      ":creation_date" => $creation_date,
      ":last_modified" => $last_modified,
      ":isActive" => $isActive,
      ":pass" => $mdp_hash,
      ":operator_level" => $operator_level,
   ));

   echo "Inscription réussie";
}

// L'adresse email à vérifier
$email = 'azerazer@fqefq';

// Préparation de la requête pour éviter les injections SQL
$stmt = $db->prepare("SELECT COUNT(*) FROM utilisateurs WHERE email = :email");
$stmt->execute(['email' => $email]);

// Récupération du nombre d'enregistrements correspondant à l'email
$count = $stmt->fetchColumn();

if ($count > 0) {
    echo "L'adresse email existe déjà.";
} else {
    echo "L'adresse email n'existe pas.";
}
?>
