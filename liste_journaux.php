<?php
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$id_utilisateur = $_SESSION['user_id'];

// Supprimer le journal (Delete Journal)
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id_journal = $_GET['id'];
    
    // Vérifier si le journal appartient à cet utilisateur
    $stmt_check = $pdo->prepare("SELECT j.fichier_pdf FROM journal j JOIN periodique p ON j.id_journal = p.id_journal WHERE j.id_journal = ? AND p.id_utilisateur = ?");
    $stmt_check->execute([$id_journal, $id_utilisateur]);
    $journal = $stmt_check->fetch();
    
    if ($journal) {
        // Supprimer le fichier PDF s'il existe
        if ($journal['fichier_pdf'] && file_exists($journal['fichier_pdf'])) {
            unlink($journal['fichier_pdf']);
        }
        
        // Supprimer de la base de données
        $pdo->prepare("DELETE FROM journal WHERE id_journal = ?")->execute([$id_journal]);
        
        // Log operation
        $stmt_log = $pdo->prepare("INSERT INTO suivi_operations (id_utilisateur, operation) VALUES (?, ?)");
        $stmt_log->execute([$id_utilisateur, "Suppression Journal ID: $id_journal"]);
        
        header("Location: liste_journaux.php?msg=deleted");
        exit();
    }
}

$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$partie = isset($_GET['partie']) ? trim($_GET['partie']) : '';

// Récupérer les journaux enregistrés par cet utilisateur avec possibilité de filtrer
$sql = "SELECT j.*, p.date_reception FROM journal j JOIN periodique p ON j.id_journal = p.id_journal WHERE p.id_utilisateur = ?";
$params = [$id_utilisateur];

if (!empty($search)) {
    $sql .= " AND (j.matricule = ? OR j.editeur LIKE ? OR j.lieu_stockage LIKE ?)";
    $params[] = $search;
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if (!empty($partie)) {
    $sql .= " AND j.partie = ?";
    $params[] = $partie;
}

$sql .= " ORDER BY p.date_reception DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$journals_list = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Journaux - Gestion des Archives</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
</head>
<body class="animate">
    <?php include 'navigation.php'; ?>
    <div class="container animate">
        <?php if (isset($_GET['success'])): ?>
            <div class="badge badge-green" style="display: block; margin-bottom: 20px;" data-i18n="success_save">Journal enregistré !</div>
        <?php endif; ?>
        
        <form action="liste_journaux.php" method="GET" style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 30px; background: var(--light-grey); padding: 20px; border-radius: 12px;">
            <div style="flex: 2; min-width: 250px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 13px; color: #475569;" data-i18n="search_keyword_label">Mots-clés (Numéro, Éditeur...)</label>
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Rechercher..." style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 6px;">
            </div>
            <div style="flex: 1; min-width: 150px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 13px; color: #475569;" data-i18n="partie">Partie</label>
                <select name="partie" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 6px;">
                    <option value="" data-i18n="all_parties">Toutes les parties</option>
                    <option value="part1" <?php echo $partie == 'part1' ? 'selected' : ''; ?> data-i18n="part1">1ère Partie (Lois, Décrets, Arrêtés)</option>
                    <option value="part2" <?php echo $partie == 'part2' ? 'selected' : ''; ?> data-i18n="part2">2ème Partie (Avis, Appels d'offres, Annonces)</option>
                    <option value="part3" <?php echo $partie == 'part3' ? 'selected' : ''; ?> data-i18n="part3">3ème Partie (Réquisitions Domaniales)</option>
                </select>
            </div>
            <div style="display: flex; align-items: flex-end;">
                <button type="submit" class="btn btn-blue" style="padding: 12px 30px;" data-i18n="search_button">FILTRER</button>
                <?php if (!empty($search) || !empty($partie)): ?>
                    <a href="liste_journaux.php" class="btn btn-grey" style="padding: 12px 20px; margin-left: 10px;" data-i18n="clear">Effacer</a>
                <?php endif; ?>
            </div>
        </form>
        
        <h2 data-i18n="recent_entries">Journaux récemment enregistrés</h2>
        <p style="margin-bottom: 25px; opacity: 0.8;"><span data-i18n="hello">Bonjour</span>, <strong><?php echo $_SESSION['user_nom'] ?? 'Utilisateur'; ?></strong></p>

        <div style="overflow-x: auto; margin-top: 20px;">
            <table>
                <thead>
                    <tr>
                        <th data-i18n="journal_number">Numéro</th>
                        <th data-i18n="partie">Partie</th>
                        <th data-i18n="editeur">Éditeur</th>
                        <th data-i18n="date_received">Date de réception</th>
                        <th data-i18n="action_label">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
                        <div class="badge badge-blue" style="display: block; margin-bottom: 20px;">Journal supprimé avec succès.</div>
                    <?php endif; ?>
                    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'updated'): ?>
                        <div class="badge badge-green" style="display: block; margin-bottom: 20px;">Journal mis à jour avec succès.</div>
                    <?php endif; ?>

                    <?php foreach ($journals_list as $j): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($j['matricule']); ?></strong></td>
                        <td><span class="badge badge-grey"><?php echo htmlspecialchars($j['partie']); ?></span></td>
                        <td><?php echo htmlspecialchars($j['editeur']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($j['date_reception'])); ?></td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <?php if ($j['fichier_pdf']): ?>
                                    <a href="<?php echo htmlspecialchars($j['fichier_pdf']); ?>" target="_blank" class="btn btn-grey" style="padding: 5px 12px; font-size: 11px;">📄 PDF</a>
                                <?php endif; ?>
                                <a href="edit_journal.php?id=<?php echo $j['id_journal']; ?>" class="btn btn-blue" style="padding: 5px 12px; font-size: 11px;">Modifier</a>
                                 <a href="?action=delete&id=<?php echo $j['id_journal']; ?>" onclick="return confirm('Voulez-vous vraiment supprimer ce journal ?')" class="btn btn-red" style="padding: 5px 12px; font-size: 11px;">Supprimer</a>
                             </div>
                        </td>
                    </tr>
                    <?php if ($j['description']): ?>
                    <tr>
                        <td colspan="5" style="background: #f9f9f9; font-size: 0.85rem; padding: 10px 20px; border-top: none;">
                            <i data-i18n="details">Note</i>: <?php echo htmlspecialchars($j['description']); ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <?php if (empty($journals_list)): ?>
                    <tr><td colspan="5" style="text-align: center; padding: 30px; color: #888;" data-i18n="no_journal_recorded">Aucun journal enregistré.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 30px; text-align: center;">
            <a href="user_dashboard.php" class="btn" data-i18n="register_journal">Enregistrer un Nouveau Journal</a>
        </div>
    </div>
    
    <footer style="margin-top: 50px; padding: 40px; text-align: center; color: #243ba3ff;">
        &copy; <?php echo date('Y'); ?> - <span data-i18n="footer_text">CIDST Tsimbazaza</span>
    </footer>
    <script src="js/script.js"></script>
        </div> <!-- close page-content -->
    </div> <!-- close main-layout -->
</div> <!-- close app-container -->
</body>
</html>