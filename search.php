<?php
require_once 'db.php';

$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$date = isset($_GET['d']) ? trim($_GET['d']) : '';
$partie = isset($_GET['partie']) ? trim($_GET['partie']) : '';
$journals = [];

$has_searched = !empty($search) || !empty($date) || !empty($partie);

if ($has_searched) {
    $sql = "SELECT j.*, p.date_reception FROM journal j JOIN periodique p ON j.id_journal = p.id_journal WHERE 1=1";
    $params = [];
    
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
    
    if (!empty($date)) {
        $sql .= " AND DATE(p.date_reception) = ?";
        $params[] = $date;
    }
    
    $sql .= " ORDER BY p.date_reception DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $journals = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-i18n="search">Recherche - Journal Archives</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
</head>
<body class="animate">
    <?php include 'navigation.php'; ?>
    <div class="container animate">
        <h2 style="text-align: center;" data-i18n="search">RECHERCHE GAZETTE</h2>
        
        <form action="search.php" method="GET" style="display: flex; flex-wrap: wrap; gap: 15px; margin: 40px 0; background: var(--light-grey); padding: 25px; border-radius: 12px;">
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 13px; color: #666;" data-i18n="search_keyword_label">Mots-clés (Numéro, Éditeur...)</label>
                <input type="text" name="q" placeholder="Rechercher..." data-i18n="search_placeholder" value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 13px; color: #666;" data-i18n="partie">Partie</label>
                <select name="partie" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px;">
                    <option value="" data-i18n="all_parties">Toutes les parties</option>
                    <option value="part1" <?php echo $partie == 'part1' ? 'selected' : ''; ?> data-i18n="part1">1ère Partie (Lois, Décrets, Arrêtés)</option>
                    <option value="part2" <?php echo $partie == 'part2' ? 'selected' : ''; ?> data-i18n="part2">2ème Partie (Avis, Appels d'offres, Annonces)</option>
                    <option value="part3" <?php echo $partie == 'part3' ? 'selected' : ''; ?> data-i18n="part3">3ème Partie (Réquisitions Domaniales)</option>
                </select>
            </div>
            <div style="flex: 1; min-width: 150px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 13px; color: #666;" data-i18n="date_received_label">Date de réception</label>
                <input type="date" name="d" value="<?php echo htmlspecialchars($date); ?>">
            </div>
            <div style="display: flex; align-items: flex-end;">
                <button type="submit" class="btn" style="padding: 12px 40px;" data-i18n="search_button">RECHERCHER</button>
            </div>
        </form>

        <?php if ($has_searched): ?>
            <div class="glass-card" style="padding: 0; overflow: hidden;">
                <table>
                    <thead>
                        <tr>
                            <th data-i18n="journal_number">Numéro</th>
                            <th data-i18n="partie">Partie</th>
                            <th data-i18n="editeur">Éditeur</th>
                            <th data-i18n="date_received">Date de réception</th>
                            <th data-i18n="status">Statut</th>
                            <th data-i18n="view_pdf">Fichier</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($journals) > 0): ?>
                            <?php foreach ($journals as $j): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($j['matricule']); ?></strong></td>
                                    <td><span class="badge badge-orange"><?php echo htmlspecialchars($j['partie']); ?></span></td>
                                    <td><?php echo htmlspecialchars($j['editeur']); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($j['date_reception'])); ?></td>
                                    <td><span class="badge badge-orange" data-i18n="status_arrived">Arrivé</span></td>
                                    <td>
                                        <?php if ($j['fichier_pdf']): ?>
                                            <a href="<?php echo htmlspecialchars($j['fichier_pdf']); ?>" target="_blank" class="badge badge-blue" style="text-decoration: none;">📄 PDF</a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" style="text-align: center; padding: 40px; color: #888;" data-i18n="no_results">Aucun résultat trouvé.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 60px; color: #888; border: 2px dashed #ddd; border-radius: 12px;">
                <div style="font-size: 3rem; margin-bottom: 20px;">🔍</div>
                <p data-i18n="start_search_instruction">Entrez le matricule ou la date que vous souhaitez consulter pour commencer la recherche.</p>
            </div>
        <?php endif; ?>
    </div>
    
    <footer style="margin-top: 50px; padding: 40px; text-align: center; color: #888;">
        &copy; <?php echo date('Y'); ?> - <span data-i18n="footer_text">Ministère de l'Intérieur</span>
    </footer>
    <script src="js/script.js"></script>
        </div> <!-- close page-content -->
    </div> <!-- close main-layout -->
</div> <!-- close app-container -->
</body>
</html>
