<?php
require_once 'db.php';

// Data for the 4 main cards
$total_actes = $pdo->query("SELECT COUNT(*) FROM journal")->fetchColumn();
$total_gazety = $pdo->query("SELECT COUNT(*) FROM journal")->fetchColumn();
$total_types = $pdo->query("SELECT COUNT(DISTINCT partie) FROM journal")->fetchColumn();
$total_institutions = $pdo->query("SELECT COUNT(DISTINCT editeur) FROM journal")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-i18n="stats">Statistiques - CIDST Tsimbazaza</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px; }
        
        .stat-value { font-size: 2.5rem; font-weight: 800; color: var(--primary-blue); margin: 10px 0; }
        .stat-label { font-size: 0.9rem; color: #475569; text-transform: uppercase; letter-spacing: 1px; }
        
        .progress-container { margin-top: 15px; background: #e2e8f0; border-radius: 10px; height: 12px; overflow: hidden; }
        .progress-bar { height: 100%; background: var(--primary-blue); border-radius: 10px; transition: width 1s ease-in-out; }
    </style>
</head>
<body class="animate">
    <?php include 'navigation.php'; ?>
    <div class="container animate">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 data-i18n="stats_title" style="margin-bottom: 0;">Statistiques des Journaux</h2>
            <a href="home.php" class="btn btn-outline" style="padding: 8px 20px; font-size: 0.9rem; text-transform: none;">
                ⬅️ <span data-i18n="home">Retour</span>
            </a>
        </div>
        <p style="margin-bottom: 30px; opacity: 0.8;" data-i18n="stats_desc">Résumé du nombre de journaux et des activités.</p>

        <div class="stats-grid animate">
            <a href="liste_journaux.php" class="stat-card" style="text-decoration: none; display: block; border-top: 4px solid var(--primary-blue);">
                <div class="stat-label" data-i18n="total_actes">Total Actes</div>
                <div class="stat-value"><?php echo $total_actes; ?></div>
                <div style="font-size: 20px;">📄</div>
            </a>
            <a href="liste_journaux.php" class="stat-card" style="border-top: 4px solid var(--primary-grey); text-decoration: none; display: block;">
                <div class="stat-label" data-i18n="total_journals">Journaux</div>
                <div class="stat-value"><?php echo $total_gazety; ?></div>
                <div style="font-size: 20px;">📗</div>
            </a>
            <a href="liste_journaux.php" class="stat-card" style="text-decoration: none; display: block; border-top: 4px solid var(--primary-blue);">
                <div class="stat-label" data-i18n="total_types">Types d'actes</div>
                <div class="stat-value"><?php echo $total_types; ?></div>
                <div style="font-size: 20px;">🔖</div>
            </a>
            <a href="liste_journaux.php" class="stat-card" style="border-top: 4px solid var(--primary-grey); text-decoration: none; display: block;">
                <div class="stat-label" data-i18n="total_institutions">Institutions</div>
                <div class="stat-value"><?php echo $total_institutions; ?></div>
                <div style="font-size: 20px;">🏛️</div>
            </a>
        </div>
    </div>

    <footer style="margin-top: 50px; padding: 40px; text-align: center; color: #64748b;">
        &copy; <?php echo date('Y'); ?> - <span data-i18n="footer_text">CIDST Tsimbazaza</span>
    </footer>
    <script src="js/script.js"></script>
        </div> <!-- close page-content -->
    </div> <!-- close main-layout -->
</div> <!-- close app-container -->
</body>
</html>
