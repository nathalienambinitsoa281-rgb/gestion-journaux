<?php
require_once 'db.php';
include 'navigation.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($search)) {
    $stmt = $pdo->prepare("SELECT j.*, p.date_reception 
                           FROM journal j 
                           JOIN periodique p ON j.id_journal = p.id_journal 
                           WHERE j.editeur LIKE ? OR j.lieu_edition LIKE ? OR j.partie LIKE ?
                           ORDER BY p.date_reception DESC");
    $stmt->execute(["%$search%", "%$search%", "%$search%"]);
} else {
    $stmt = $pdo->query("SELECT j.*, p.date_reception 
                         FROM journal j 
                         JOIN periodique p ON j.id_journal = p.id_journal 
                         ORDER BY p.date_reception DESC");
}
$journals = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journaux Publics - Consultations</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
</head>
<body class="animate">
    <div class="container animate">
        <h2 style="text-align: center; color: var(--primary-blue);" data-i18n="public_archives">ARCHIVES PUBLIQUES</h2>
        <p style="text-align: center; color: #666; margin-bottom: 40px;" data-i18n="public_archives_desc">Recherche et consultation de tous les journaux enregistrés.</p>
        
        <div style="margin-bottom: 30px; background: var(--light-grey); padding: 25px; border-radius: 12px;">
            <form action="" method="GET">
                <label style="display: block; margin-bottom: 10px; font-weight: 600; font-size: 14px; color: #666;" data-i18n="quick_search_label">Recherche rapide :</label>
                <input type="text" name="search" class="search-input" placeholder="Rechercher par éditeur, lieu ou partie..." data-i18n="public_search_placeholder" value="<?php echo htmlspecialchars($search); ?>">
            </form>
        </div>

        <div class="glass-card" style="padding: 0; overflow: hidden;">
            <table>
                <thead>
                    <tr>
                        <th data-i18n="partie">Partie</th>
                        <th data-i18n="editeur">Editeur</th>
                        <th data-i18n="edition_col">Édition</th>
                        <th data-i18n="sortie_col">Sortie</th>
                        <th data-i18n="stockage">Stockage</th>
                        <th data-i18n="date">Date Reception</th>
                    </tr>
                </thead>
                <tbody id="journalTable">
                    <?php if (count($journals) > 0): ?>
                        <?php foreach ($journals as $j): ?>
                            <tr>
                                <td><span class="badge <?php echo $j['partie'] ? 'badge-orange' : 'badge-blue'; ?>"><?php echo $j['partie'] ?: 'TSISY'; ?></span></td>
                                <td><strong><?php echo htmlspecialchars($j['editeur']); ?></strong></td>
                                <td><?php echo $j['date_edition'] ? date('d/m/Y', strtotime($j['date_edition'])) : '-'; ?></td>
                                <td><?php echo $j['date_sortie'] ? date('d/m/Y', strtotime($j['date_sortie'])) : '-'; ?></td>
                                <td><?php echo htmlspecialchars($j['lieu_stockage']); ?></td>
                                <td style="color: #888; font-size: 0.85rem;"><?php echo date('d/m/Y H:i', strtotime($j['date_reception'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px; color: #999;" data-i18n="no_results">Aucun résultat trouvé.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer style="margin-top: 50px; padding: 40px; text-align: center; color: #888;">
        &copy; <?php echo date('Y'); ?> - <span data-i18n="public_archives">Archives Publiques</span> - <span data-i18n="footer_text">Ministère de l'Intérieur</span>
    </footer>

    <script src="js/script.js"></script>
    <script>
        // Simple client-side filtering for better UX
        document.querySelector('.search-input').addEventListener('keyup', function(e) {
            let filter = e.target.value.toLowerCase();
            let rows = document.querySelectorAll('#journalTable tr');
            
            rows.forEach(row => {
                if(row.innerText.toLowerCase().includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
