<?php
require_once 'db.php';

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
    <?php include 'navigation.php'; ?>
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
                        <th data-i18n="visual_label">Aperçu</th>
                        <th data-i18n="journal_number">Numéro</th>
                        <th data-i18n="partie">Partie</th>
                        <th data-i18n="editeur">Editeur</th>
                        <th data-i18n="edition_col">Édition</th>
                        <th data-i18n="sortie_col">Sortie</th>
                        <th data-i18n="stockage">Stockage</th>
                        <th data-i18n="price">Prix</th>
                        <th data-i18n="date">Date Reception</th>
                        <th data-i18n="view_pdf">Fichier</th>
                    </tr>
                </thead>
                <tbody id="journalTable">
                    <?php if (count($journals) > 0): ?>
                        <?php foreach ($journals as $j): ?>
                            <tr>
                                <td>
                                    <div style="width: 50px; height: 60px; background: #eee; border-radius: 4px; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid #ddd;">
                                        <img src="https://images.unsplash.com/photo-1585829365234-781fcd69186b?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=60" alt="Newspaper" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                </td>
                                <td><strong><?php echo htmlspecialchars($j['matricule']); ?></strong></td>
                                <td><span class="badge <?php echo $j['partie'] ? 'badge-orange' : 'badge-blue'; ?>" data-i18n="<?php echo $j['partie'] ?: 'no_partie'; ?>"><?php echo $j['partie'] ?: 'TSISY'; ?></span></td>
                                <td><strong><?php echo htmlspecialchars($j['editeur']); ?></strong></td>
                                <td><?php echo $j['date_edition'] ? date('d/m/Y', strtotime($j['date_edition'])) : '-'; ?></td>
                                <td><?php echo $j['date_sortie'] ? date('d/m/Y', strtotime($j['date_sortie'])) : '-'; ?></td>
                                <td><?php echo htmlspecialchars($j['lieu_stockage']); ?></td>
                                <td><strong><?php echo $j['prix'] ? number_format($j['prix'], 2, ',', ' ') . ' Ar' : '-'; ?></strong></td>
                                <td style="color: #888; font-size: 0.85rem;"><?php echo date('d/m/Y H:i', strtotime($j['date_reception'])); ?></td>
                                <td>
                                    <?php if ($j['fichier_pdf']): ?>
                                        <a href="<?php echo htmlspecialchars($j['fichier_pdf']); ?>" target="_blank" class="badge badge-blue" style="text-decoration: none;">📄 PDF</a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php if ($j['description']): ?>
                            <tr class="detail-row">
                                <td colspan="10" style="background: #fdfdfd; font-size: 0.85rem; padding: 10px 20px; border-top: none; color: #666;">
                                    <i data-i18n="details">Note</i>: <?php echo htmlspecialchars($j['description']); ?>
                                </td>
                            </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" style="text-align: center; padding: 40px; color: #999;" data-i18n="no_results">Aucun résultat trouvé.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="container animate" style="margin-top: 60px; padding: 0;">
            <h3 style="color: var(--primary-blue); margin-bottom: 25px;" data-i18n="visual_archives">Archives Visuelles</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 15px;">
                <img src="https://images.unsplash.com/photo-1585829365234-781fcd69186b?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=60" alt="G1" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px; border: 3px solid white; box-shadow: var(--shadow);">
                <img src="https://images.unsplash.com/photo-1504711434969-e33886168f5c?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=60" alt="G2" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px; border: 3px solid white; box-shadow: var(--shadow);">
                <img src="https://images.unsplash.com/photo-1566378246598-5b11a0d486cc?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=60" alt="G3" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px; border: 3px solid white; box-shadow: var(--shadow);">
                <img src="https://images.unsplash.com/photo-1572949645841-3947a407c563?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=60" alt="G4" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px; border: 3px solid white; box-shadow: var(--shadow);">
                <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=60" alt="G5" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px; border: 3px solid white; box-shadow: var(--shadow);">
            </div>
        </div>
    </div>

    <footer style="margin-top: 50px; padding: 40px; text-align: center; color: #888;">
        &copy; <?php echo date('Y'); ?> - <span data-i18n="public_archives">Archives Publiques</span> - <span data-i18n="footer_text">Ministère de l'Intérieur</span>
    </footer>

    <script src="js/script.js"></script>
        </div> <!-- close page-content -->
    </div> <!-- close main-layout -->
</div> <!-- close app-container -->
    <script>
        // Simple client-side filtering for better UX
        document.querySelector('.search-input').addEventListener('keyup', function(e) {
            let filter = e.target.value.toLowerCase();
            let rows = document.querySelectorAll('#journalTable tr:not(.detail-row)');
            
            rows.forEach(row => {
                if(row.innerText.toLowerCase().includes(filter)) {
                    row.style.display = '';
                    // Also show the next row if it's a detail row
                    let nextRow = row.nextElementSibling;
                    if(nextRow && nextRow.classList.contains('detail-row')) {
                        nextRow.style.display = '';
                    }
                } else {
                    row.style.display = 'none';
                    let nextRow = row.nextElementSibling;
                    if(nextRow && nextRow.classList.contains('detail-row')) {
                        nextRow.style.display = 'none';
                    }
                }
            });
        });
    </script>
</body>
</html>
