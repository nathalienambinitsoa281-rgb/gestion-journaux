<?php
require_once 'db.php';
include 'navigation.php';

$search = isset($_GET['q']) ? $_GET['q'] : '';
$date = isset($_GET['d']) ? $_GET['d'] : '';
$journals = [];

$has_searched = !empty($search) || !empty($date);

if ($has_searched) {
    $sql = "SELECT j.*, p.date_reception FROM journal j JOIN periodique p ON j.id_journal = p.id_journal WHERE 1=1";
    $params = [];
    
    if (!empty($search)) {
        $sql .= " AND (j.matricule LIKE ? OR j.editeur LIKE ? OR j.lieu_stockage LIKE ?)";
        $search_param = "%$search%";
        $params[] = $search_param;
        $params[] = $search_param;
        $params[] = $search_param;
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
    <div class="container animate">
        <h2 style="text-align: center;" data-i18n="search">RECHERCHE GAZETTE</h2>
        
        <form action="search.php" method="GET" style="display: flex; flex-wrap: wrap; gap: 15px; margin: 40px 0; background: var(--light-grey); padding: 25px; border-radius: 12px;">
            <div style="flex: 2; min-width: 250px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 13px; color: #666;" data-i18n="search_keyword_label">Mots-clés (Matricule, Éditeur...)</label>
                <input type="text" name="q" placeholder="Rechercher..." data-i18n="search_placeholder" value="<?php echo htmlspecialchars($search); ?>">
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
                            <th data-i18n="matricule">Matricule</th>
                            <th data-i18n="editeur">Éditeur</th>
                            <th data-i18n="date_received">Date de réception</th>
                            <th data-i18n="status">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($journals) > 0): ?>
                            <?php foreach ($journals as $j): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($j['matricule']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($j['editeur']); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($j['date_reception'])); ?></td>
                                    <td><span class="badge badge-orange" data-i18n="status_arrived">Arrivé</span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" style="text-align: center; padding: 40px; color: #888;" data-i18n="no_results">Aucun résultat trouvé.</td></tr>
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
</body>
</html>
