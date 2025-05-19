<?php
require_once __DIR__ . '/../../vendor/autoload.php'; 

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
					$this->db->exec("SET time_zone = 'Europe/Brussels'");
                } catch (PDOException $e) {
                    echo 'Erreur de connexion : ' . $e->getMessage() . "\n";
                    exit;
                }
			}
            public function query($query, $params = []) { 
				$stmt = $this->db->prepare($query);
				foreach ($params as $key => $value) { 
					$stmt->bindValue($key, $value);
				}
				$stmt->execute(); 
				
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
            public function close () {
				$this->db = null; 
            }
		}

		function checkBasket($user_id, $db) {
        try {
            $basket = $db->query("SELECT * FROM Basket WHERE user_id = :user_id", [
                ':user_id' => $user_id
            ]);
            if ($basket) {
                return $basket; 
            } else {
                try {
                    $db->query("INSERT INTO Basket (user_id) VALUES (:user_id)", [
                        ':user_id' => $user_id
                    ]);
                }
                catch (PDOException $e) {
                    echo 'Erreur de requête : ' . $e->getMessage();
                    return null;
                }
            }
        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
            return null;
        }
    }

?>
