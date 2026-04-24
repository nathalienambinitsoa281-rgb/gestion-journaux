<?php
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$id_utilisateur = $_SESSION['user_id'];

// Vérifier si l'utilisateur existe encore dans la base de données pour éviter les erreurs de contrainte
$stmt_check = $pdo->prepare("SELECT 1 FROM utilisateur WHERE id_utilisateur = ?");
$stmt_check->execute([$id_utilisateur]);
if (!$stmt_check->fetch()) {
    session_destroy();
    header("Location: index.php?error=session_expired");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['enregistrer_journal'])) {
    $matricule = $_POST['matricule'] ?? '';
    $partie = $_POST['partie'] ?? '';
    $editeur = $_POST['editeur'] ?? '';
    $lieu_edition = $_POST['lieu_edition'] ?? '';
    $date_edition = $_POST['date_edition'] ?? null;
    $date_sortie = $_POST['date_sortie'] ?? null;
    $lieu_stockage = $_POST['lieu_stockage'] ?? '';
    $prix = $_POST['prix'] ?? null;
    $description = $_POST['description'] ?? '';
    $fichier_pdf = null;

    // Gestion de l'upload PDF
    if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] == 0) {
        $allowed = ['pdf'];
        $filename = $_FILES['pdf_file']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (in_array(strtolower($ext), $allowed)) {
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
        $pdo->beginTransaction();
        $stmt_j = $pdo->prepare("INSERT INTO journal (matricule, partie, editeur, lieu_edition, date_edition, date_sortie, lieu_stockage, fichier_pdf, prix, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt_j->execute([$matricule, $partie, $editeur, $lieu_edition, $date_edition, $date_sortie, $lieu_stockage, $fichier_pdf, $prix, $description]);
        $id_journal = $pdo->lastInsertId();

        $stmt_p = $pdo->prepare("INSERT INTO periodique (id_utilisateur, id_journal) VALUES (?, ?)");
        $stmt_p->execute([$id_utilisateur, $id_journal]);

        // Enregistrer l'opération dans le suivi
        $stmt_log = $pdo->prepare("INSERT INTO suivi_operations (id_utilisateur, operation) VALUES (?, ?)");
        $stmt_log->execute([$id_utilisateur, "Enregistrement Journal: $matricule"]);

        $pdo->commit();
        header("Location: liste_journaux.php?success=1");
        exit();
    } catch (Exception $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        $error = "Erreur: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - User</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
</head>
<body class="animate">
    <?php include 'navigation.php'; ?>
    <div class="container animate">
        <h2 data-i18n="welcome">BIENVENUE</h2>
        <p style="margin-bottom: 30px; opacity: 0.8;"><span data-i18n="hello">Bonjour</span>, <strong><?php echo $_SESSION['user_nom'] ?? 'Utilisateur'; ?></strong></p>

        <?php if ($error): ?><div class="badge badge-red" style="display: block; margin-bottom: 20px;"><span data-i18n="error_label">Erreur</span>: <?php echo $error; ?></div><?php endif; ?>

        <div class="glass-card">
            <h3 style="color: var(--primary-blue); margin-top: 0;" data-i18n="register_journal">Enregistrer un Nouveau Journal</h3>
            <form action="" method="POST" enctype="multipart/form-data" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 20px;">
                <div class="form-group">
                    <label data-i18n="journal_number">Numéro:</label>
                    <input type="number" name="matricule" required placeholder="Numéro...">
                </div>
                <div class="form-group">
                    <label data-i18n="partie">Partie:</label>
                    <select name="partie" id="partieSelect" onchange="updatePrice()">
                        <option value="">-</option>
                        <option value="part1" data-i18n="part1">1ère Partie (Lois, Décrets, Arrêtés)</option>
                        <option value="part2" data-i18n="part2">2ème Partie (Avis, Appels d'offres, Annonces)</option>
                        <option value="part3" data-i18n="part3">3ème Partie (Réquisitions Domaniales)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label data-i18n="price">Prix (Ar):</label>
                    <input type="number" name="prix" id="priceInput" step="0.01" readonly style="background: #f4f4f4;">
                </div>
                <div class="form-group">
                    <label data-i18n="editeur">Éditeur:</label>
                    <input type="text" name="editeur" required>
                </div>
                <div class="form-group">
                    <label data-i18n="stockage">Stockage:</label>
                    <input type="text" name="lieu_stockage">
                </div>
                <div class="form-group">
                    <label data-i18n="place_edition">Lieu d'édition:</label>
                    <input type="text" name="lieu_edition">
                </div>
                <div class="form-group">
                    <label data-i18n="date_edition">Date d'édition:</label>
                    <input type="date" name="date_edition">
                </div>
                <div class="form-group">
                    <label data-i18n="date_release">Date de sortie:</label>
                    <input type="date" name="date_sortie">
                </div>
                <div class="form-group">
                    <label data-i18n="pdf_file">Fichier PDF (Optionnel):</label>
                    <input type="file" name="pdf_file" accept=".pdf">
                </div>
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label data-i18n="details">Détails / Complément:</label>
                    <textarea name="description" placeholder="Atsasaky ny premiere partie..." style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;"></textarea>
                </div>
                <div style="grid-column: 1 / -1;">
                    <button type="submit" name="enregistrer_journal" class="btn" style="width: 100%;" data-i18n="save">ENREGISTRER</button>
                </div>
            </form>
        </div>
    </div>
    <script src="js/script.js"></script>
        </div> <!-- close page-content -->
    </div> <!-- close main-layout -->
</div> <!-- close app-container -->
    <script>
        function updatePrice() {
            const select = document.getElementById('partieSelect');
            const priceInput = document.getElementById('priceInput');
            const prices = {
                'part1': 1035,
                'part2': 900,
                'part3': 85
            };
            priceInput.value = prices[select.value] || '';
        }
    </script>
</body>
</html>
