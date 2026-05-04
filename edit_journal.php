<?php
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$id_utilisateur = $_SESSION['user_id'];
$id_journal = $_GET['id'] ?? null;

if (!$id_journal) {
    header("Location: liste_journaux.php");
    exit();
}

// Récupérer les données du journal
$stmt = $pdo->prepare("SELECT j.* FROM journal j JOIN periodique p ON j.id_journal = p.id_journal WHERE j.id_journal = ? AND p.id_utilisateur = ?");
$stmt->execute([$id_journal, $id_utilisateur]);
$journal = $stmt->fetch();

if (!$journal) {
    header("Location: liste_journaux.php");
    exit();
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifier_journal'])) {
    $matricule = $_POST['matricule'] ?? '';
    $partie = $_POST['partie'] ?? '';
    $editeur = $_POST['editeur'] ?? '';
    $lieu_edition = $_POST['lieu_edition'] ?? '';
    $date_edition = $_POST['date_edition'] ?? null;
    $date_sortie = $_POST['date_sortie'] ?? null;
    $lieu_stockage = $_POST['lieu_stockage'] ?? '';
    $prix = $_POST['prix'] ?? null;
    $description = $_POST['description'] ?? '';
    
    // Validation des champs obligatoires
    if (empty($matricule) || empty($partie) || empty($editeur) || empty($date_edition) || empty($date_sortie) || empty($lieu_stockage)) {
        $error = "Tous les champs sont obligatoires, sauf le fichier PDF.";
    } else {
        $fichier_pdf = $journal['fichier_pdf']; // Garder l'ancien par défaut

        // Gestion de l'upload PDF (si nouveau fichier)
        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] == 0) {
            $allowed = ['pdf'];
            $filename = $_FILES['pdf_file']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (in_array(strtolower($ext), $allowed)) {
                // Supprimer l'ancien fichier
                if ($fichier_pdf && file_exists($fichier_pdf)) {
                    unlink($fichier_pdf);
                }
                
                $new_filename = "journal_" . $matricule . "_" . time() . ".pdf";
                $upload_path = 'uploads/pdf/' . $new_filename;
                if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $upload_path)) {
                    $fichier_pdf = $upload_path;
                }
            }
        }

        if (empty($date_edition)) $date_edition = null;
        if (empty($date_sortie)) $date_sortie = null;

        try {
            $stmt_u = $pdo->prepare("UPDATE journal SET matricule = ?, partie = ?, editeur = ?, lieu_edition = ?, date_edition = ?, date_sortie = ?, lieu_stockage = ?, fichier_pdf = ?, prix = ?, description = ? WHERE id_journal = ?");
            $stmt_u->execute([$matricule, $partie, $editeur, $lieu_edition, $date_edition, $date_sortie, $lieu_stockage, $fichier_pdf, $prix, $description, $id_journal]);

            // Log operation
            $stmt_log = $pdo->prepare("INSERT INTO suivi_operations (id_utilisateur, operation) VALUES (?, ?)");
            $stmt_log->execute([$id_utilisateur, "Modification Journal: $matricule (ID: $id_journal)"]);

            header("Location: liste_journaux.php?msg=updated");
            exit();
        } catch (Exception $e) {
            $error = "Erreur: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Journal</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
</head>
<body class="animate">
    <?php include 'navigation.php'; ?>
    <div class="container animate">
        <h2 style="text-align: center; color: var(--primary-blue);" data-i18n="edit_journal">MODIFIER UN JOURNAL</h2>
        
        <?php if ($error): ?>
            <div class="badge badge-red" style="display: block; margin-bottom: 20px;"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="glass-card">
            <form action="" method="POST" enctype="multipart/form-data">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                    <div class="form-group">
                        <label data-i18n="journal_number">Numéro (Matricule) :</label>
                        <input type="text" name="matricule" value="<?php echo htmlspecialchars($journal['matricule']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label data-i18n="partie">Partie :</label>
                        <input type="text" name="partie" value="<?php echo htmlspecialchars($journal['partie']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label data-i18n="editeur">Editeur :</label>
                        <input type="text" name="editeur" value="<?php echo htmlspecialchars($journal['editeur']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label data-i18n="edition_col">Date d'édition :</label>
                        <input type="date" name="date_edition" value="<?php echo $journal['date_edition']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label data-i18n="sortie_col">Date de sortie :</label>
                        <input type="date" name="date_sortie" value="<?php echo $journal['date_sortie']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label data-i18n="stockage">Lieu de stockage :</label>
                        <input type="text" name="lieu_stockage" value="<?php echo htmlspecialchars($journal['lieu_stockage']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label data-i18n="price">Prix (Ar) :</label>
                        <input type="number" step="0.01" name="prix" value="<?php echo $journal['prix']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label data-i18n="upload_pdf">Fichier PDF (Peut être vide) :</label>
                        <input type="file" name="pdf_file" accept=".pdf">
                        <?php if ($journal['fichier_pdf']): ?>
                            <small style="color: var(--primary-blue);">Fichier actuel: <?php echo basename($journal['fichier_pdf']); ?></small>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="form-group" style="margin-top: 20px;">
                    <label data-i18n="description_label">Description / Notes :</label>
                    <textarea name="description" rows="4"><?php echo htmlspecialchars($journal['description']); ?></textarea>
                </div>

                <div style="display: flex; gap: 15px; margin-top: 30px;">
                    <button type="submit" name="modifier_journal" class="btn btn-blue" style="flex: 2;" data-i18n="save_changes">ENREGISTRER LES MODIFICATIONS</button>
                    <a href="liste_journaux.php" class="btn btn-grey" style="flex: 1; text-align: center;" data-i18n="cancel">ANNULER</a>
                </div>
            </form>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
