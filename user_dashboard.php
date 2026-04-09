<?php
include 'navigation.php';
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

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['enregistrer_journal'])) {
    $matricule = $_POST['matricule'] ?? '';
    $partie = $_POST['partie'] ?? '';
    $editeur = $_POST['editeur'] ?? '';
    $lieu_edition = $_POST['lieu_edition'] ?? '';
    $date_edition = $_POST['date_edition'] ?? null;
    $date_sortie = $_POST['date_sortie'] ?? null;
    $lieu_stockage = $_POST['lieu_stockage'] ?? '';

    if (empty($date_edition)) $date_edition = null;
    if (empty($date_sortie)) $date_sortie = null;

    try {
        $pdo->beginTransaction();
        $stmt_j = $pdo->prepare("INSERT INTO journal (matricule, partie, editeur, lieu_edition, date_edition, date_sortie, lieu_stockage) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt_j->execute([$matricule, $partie, $editeur, $lieu_edition, $date_edition, $date_sortie, $lieu_stockage]);
        $id_journal = $pdo->lastInsertId();

        $stmt_p = $pdo->prepare("INSERT INTO periodique (id_utilisateur, id_journal) VALUES (?, ?)");
        $stmt_p->execute([$id_utilisateur, $id_journal]);

        // Enregistrer l'opération dans le suivi
        $stmt_log = $pdo->prepare("INSERT INTO suivi_operations (id_utilisateur, operation) VALUES (?, ?)");
        $stmt_log->execute([$id_utilisateur, "Enregistrement Journal: $matricule"]);

        $pdo->commit();
        $success = "Journal enregistré !";
    } catch (Exception $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        $error = "Erreur: " . $e->getMessage();
    }
}

$journals = $pdo->query("SELECT j.*, p.date_reception FROM journal j JOIN periodique p ON j.id_journal = p.id_journal ORDER BY p.date_reception DESC")->fetchAll();
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
    <div class="container animate">
        <h2 data-i18n="welcome">BIENVENUE</h2>
        <p style="margin-bottom: 30px; opacity: 0.8;"><span data-i18n="hello">Bonjour</span>, <strong><?php echo $_SESSION['user_nom'] ?? 'Utilisateur'; ?></strong></p>

        <?php if ($success): ?><div class="badge badge-green" style="display: block; margin-bottom: 20px;" data-i18n="success_save"><?php echo $success; ?></div><?php endif; ?>
        <?php if ($error): ?><div class="badge badge-red" style="display: block; margin-bottom: 20px;"><span data-i18n="error_label">Erreur</span>: <?php echo $error; ?></div><?php endif; ?>

        <div class="glass-card">
            <h3 style="color: var(--primary-blue); margin-top: 0;" data-i18n="register_journal">Enregistrer un Nouveau Journal</h3>
            <form action="" method="POST" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 20px;">
                <div class="form-group">
                    <label data-i18n="matricule">Matricule:</label>
                    <input type="text" name="matricule" required placeholder="Ex: J001">
                </div>
                <div class="form-group">
                    <label data-i18n="partie">Partie:</label>
                    <select name="partie">
                        <option value="">-</option>
                        <option value="part1">Partie 1</option>
                        <option value="part2">Partie 2</option>
                        <option value="part3">Partie 3</option>
                    </select>
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
                <div style="grid-column: 1 / -1;">
                    <button type="submit" name="enregistrer_journal" class="btn" style="width: 100%;" data-i18n="save">ENREGISTRER</button>
                </div>
            </form>
        </div>

        <div style="margin-top: 50px;">
            <h3 style="color: var(--primary-blue); border-bottom: 2px solid var(--secondary-orange); padding-bottom: 10px;" data-i18n="recent_entries">Journaux récemment enregistrés</h3>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th data-i18n="matricule">Matricule</th>
                            <th data-i18n="partie">Partie</th>
                            <th data-i18n="editeur">Éditeur</th>
                            <th data-i18n="date_release">Date de sortie</th>
                            <th data-i18n="date_received">Date de réception</th>
                            <th data-i18n="location">Emplacement</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($journals as $j): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($j['matricule']); ?></strong></td>
                            <td><span class="badge badge-orange"><?php echo htmlspecialchars($j['partie']); ?></span></td>
                            <td><?php echo htmlspecialchars($j['editeur']); ?></td>
                            <td><?php echo htmlspecialchars($j['date_sortie'] ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($j['date_reception']); ?></td>
                            <td><?php echo htmlspecialchars($j['lieu_stockage']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($journals)): ?>
                        <tr><td colspan="6" style="text-align: center; padding: 30px; color: #888;" data-i18n="no_journal_recorded">Aucun journal enregistré.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
