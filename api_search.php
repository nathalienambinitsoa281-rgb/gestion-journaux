<?php
require_once 'db.php';

header('Content-Type: application/json');

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

if (empty($q)) {
    echo json_encode([]);
    exit;
}

try {
    // Recherche par numéro, éditeur ou description
    $stmt = $pdo->prepare("SELECT id_journal, matricule, editeur, date_edition, partie, fichier_pdf 
                           FROM journal 
                           WHERE matricule LIKE ? OR editeur LIKE ? OR description LIKE ? 
                           ORDER BY date_edition DESC LIMIT 10");
    
    $searchTerm = "%$q%";
    $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
