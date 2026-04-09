<?php
// CONFIGURATION DE LA BASE DE DONNÉES (Supporte le Local et le Serveur En Ligne)

// Si on est sur Railway (En Ligne), il va lire les variables d'environnement.
// Si on est en local (XAMPP), il va utiliser les valeurs par défaut.
$host = getenv('MYSQLHOST') ?: 'localhost';
$port = getenv('MYSQLPORT') ?: '3306';
$dbname = getenv('MYSQLDATABASE') ?: 'gestion_journaux';
$user = getenv('MYSQLUSER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: '';

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    // Message d'erreur en cas de problème de connexion
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
