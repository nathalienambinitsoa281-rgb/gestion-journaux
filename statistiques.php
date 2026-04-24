<?php
require_once 'db.php';

// Data for the 4 main cards
$total_actes = $pdo->query("SELECT COUNT(*) FROM journal")->fetchColumn();
$total_gazety = $pdo->query("SELECT COUNT(*) FROM journal")->fetchColumn();
$total_types = $pdo->query("SELECT COUNT(DISTINCT partie) FROM journal")->fetchColumn();
$total_institutions = $pdo->query("SELECT COUNT(DISTINCT editeur) FROM journal")->fetchColumn();

// Data for the distribution section (Progress bars)
$stats_partie = $pdo->query("SELECT partie, COUNT(*) as count FROM journal GROUP BY partie")->fetchAll();
$max_count = $total_actes > 0 ? $total_actes : 1;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-i18n="stats">Statistiques - Journal Archives</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px; }
        
        .stat-value { font-size: 2.5rem; font-weight: 800; color: var(--primary-blue); margin: 10px 0; }
        .stat-label { font-size: 0.9rem; color: #666; text-transform: uppercase; letter-spacing: 1px; }
        
        .progress-container { margin-top: 15px; background: #eee; border-radius: 10px; height: 12px; overflow: hidden; }
        .progress-bar { height: 100%; background: var(--secondary-orange); border-radius: 10px; transition: width 1s ease-in-out; }
    </style>
</head>
<body class="animate">
    <?php include 'navigation.php'; ?>
    <div class="container animate">
        <h2 data-i18n="stats_title">Statistiques des Journaux</h2>
        <p style="margin-bottom: 30px; opacity: 0.8;" data-i18n="stats_desc">Résumé du nombre de journaux et de leur répartition.</p>

        <div class="stats-grid animate">
            <a href="liste_journaux.php" class="stat-card" style="text-decoration: none; display: block;">
                <div class="stat-label" data-i18n="total_actes">Total Actes</div>
                <div class="stat-value"><?php echo $total_actes; ?></div>
                <div style="font-size: 20px;">📄</div>
            </a>
            <a href="liste_journaux.php" class="stat-card" style="border-top-color: var(--secondary-orange); text-decoration: none; display: block;">
                <div class="stat-label" data-i18n="total_journals">Journaux</div>
                <div class="stat-value"><?php echo $total_gazety; ?></div>
                <div style="font-size: 20px;">📗</div>
            </a>
            <a href="liste_journaux.php" class="stat-card" style="text-decoration: none; display: block;">
                <div class="stat-label" data-i18n="total_types">Types d'actes</div>
                <div class="stat-value"><?php echo $total_types; ?></div>
                <div style="font-size: 20px;">🔖</div>
            </a>
            <a href="liste_journaux.php" class="stat-card" style="border-top-color: var(--secondary-orange); text-decoration: none; display: block;">
                <div class="stat-label" data-i18n="total_institutions">Institutions</div>
                <div class="stat-value"><?php echo $total_institutions; ?></div>
                <div style="font-size: 20px;">🏛️</div>
            </a>
        </div>

        <div class="glass-card animate" style="animation-delay: 0.2s;">
            <h3 style="margin-top: 0; color: var(--primary-blue); border-bottom: 2px solid var(--secondary-orange); padding-bottom: 10px;" data-i18n="distribution_partie">
                📊 Répartition par "Partie"
            </h3>
            
            <div style="margin-top: 25px;">
                <?php foreach ($stats_partie as $s): 
                    $name = $s['partie'] ?: 'Sans Partie';
                    $count = $s['count'];
                    $percent = round(($count / $max_count) * 100, 1);
                ?>
                    <div style="margin-bottom: 25px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-weight: 600;">
                            <span><?php echo htmlspecialchars($name); ?></span>
                            <span style="color: var(--primary-blue);"><?php echo $count; ?> (<?php echo $percent; ?>%)</span>
                        </div>
                        <div class="progress-container">
                            <div class="progress-bar" style="width: <?php echo $percent; ?>%;"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
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
