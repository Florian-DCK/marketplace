<?php
require_once __DIR__ . '/../../vendor/autoload.php'; //Chemin pour accéder au fichier autoload.php

// Vérifier si nous sommes sur Vercel (production) ou en local
	//Définition d'une classe "connexionDB" en utilisant le camelCase
	class   connectionDB

		{
            public $db;
			public $host;
			public $port;
			public $dbname;
			public $charset;
			public $user;
			public $pass;

			public function __construct() {
				if (getenv('VERCEL')) {
					// En production sur Vercel, utiliser les variables d'environnement de Vercel
					$this->	host    = getenv('DB_HOST');
					$this->	port    = getenv('DB_PORT');
					$this->	dbname  = getenv('DB_NAME');
					$this->	charset = getenv('DB_CHARSET');
					$this->	user    = getenv('DB_USER');
					$this->	pass    = getenv('DB_PASS');
				} else {
					// En développement local, utiliser dotenv
					try {
						$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
						$dotenv->load();
						
						$this->	host    = $_ENV['DB_HOST'];
						$this->	port    = $_ENV['DB_PORT'];
						$this->	dbname  = $_ENV['DB_NAME'];
						$this->	charset = $_ENV['DB_CHARSET'];
						$this->	user    = $_ENV['DB_USER'];
						$this->	pass    = $_ENV['DB_PASS'];
					} catch (Exception $e) {
						echo 'Erreur de chargement des variables d\'environnement : ' . $e->getMessage();
						exit;
					}
				}

                try {
                    $dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->dbname;charset=$this->charset";
                    $this->db = new PDO($dsn, $this->user, $this->pass);
                    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 } catch (PDOException $e) {
                    echo 'Erreur de connexion : ' . $e->getMessage() . "\n";
                    exit;
                 }
			}
            public function query($query, $params = []) { //crée un tableau vide
				$stmt = $this->db->prepare($query); //Prépare la requête SQL
				foreach ($params as $key => $value) { //Boucle pour récupérer les éléments de la requête SQL
					$stmt->bindValue($key, $value); //Associe les éléments de la requête entre eux
				}
				$stmt->execute(); //Pour exécuter la requête SQL ou autrement nommé la QUUUUERRRRYYYYYYYY
				
				return $stmt->fetchAll(PDO::FETCH_ASSOC); //Pour retourner les valeurs
			}
            public function close () {

            }
		}

?>
