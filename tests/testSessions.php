<?php
require_once __DIR__ . '/../api/config/session.php';

// Initialiser la session
init_session();

// Mettre en mémoire les sorties au lieu de les envoyer immédiatement
ob_start();

// Vérifier si la session est active
echo "État de la session: " . (session_status() === PHP_SESSION_ACTIVE ? "Active" : "Inactive") . "\n";

// Test d'écriture en session
$_SESSION['test_value'] = "Test à " . date('H:i:s');
echo "Valeur écrite: " . $_SESSION['test_value'] . "\n";

// Forcer l'écriture de la session
session_write_close();

// Réouvrir la session pour vérifier si les données sont toujours là
session_start();
echo "Valeur relue: " . ($_SESSION['test_value'] ?? 'Non trouvée') . "\n";

// Afficher l'ID de session pour vérification manuelle dans Redis
echo "ID de session: " . session_id() . "\n";

// Afficher le contenu mis en mémoire
ob_end_flush();
?>