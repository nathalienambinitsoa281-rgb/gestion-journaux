<?php
require_once 'db.php';

// Vérifier si l'Admin est connecté
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['logo_cidst'])) {
    $file = $_FILES['logo_cidst'];
    $allowed = ['png'];
    $filename = $file['name'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if (in_array($ext, $allowed)) {
        if ($file['size'] <= 2000000) { // 2MB max
            // Vérifier si le dossier existe
            if (!is_dir('img')) {
                mkdir('img', 0777, true);
            }

            // Enregistrer sous le nom logo_cidst.png (écrase l'ancien)
            $destination = 'img/logo_cidst.png';
            
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                // Log operation
                $stmt_log = $pdo->prepare("INSERT INTO suivi_operations (id_utilisateur, operation) VALUES (?, ?)");
                $stmt_log->execute([null, "Admin updated CIDST logo"]);
                
                header("Location: liste_utilisateurs.php?msg=logo_updated");
                exit();
            } else {
                header("Location: liste_utilisateurs.php?error=upload_failed");
                exit();
            }
        } else {
            header("Location: liste_utilisateurs.php?error=file_too_large");
            exit();
        }
    } else {
        header("Location: liste_utilisateurs.php?error=invalid_format");
        exit();
    }
} else {
    header("Location: liste_utilisateurs.php");
    exit();
}
?>