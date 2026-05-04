<?php
require_once 'db.php';

// Get statistics for home page
$total_gazety = $pdo->query("SELECT COUNT(*) FROM journal")->fetchColumn();
$total_editeurs = $pdo->query("SELECT COUNT(DISTINCT editeur) FROM journal")->fetchColumn();

// Get specific types of acts (Parties)
$stmt_types = $pdo->query("SELECT partie, COUNT(*) as count FROM journal GROUP BY partie HAVING partie IS NOT NULL AND partie != ''");
$types_actes = $stmt_types->fetchAll();
$total_types = count($types_actes);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de journaux CIDST Tsimbazaza</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
</head>
<body class="animate">
    <?php include 'navigation.php'; ?>
    <div style="min-height: 85vh; display: flex; align-items: center; justify-content: center; text-align: center; background: linear-gradient(rgba(21, 101, 192, 0.85), rgba(20, 18, 156, 0.85)), url('https://images.unsplash.com/photo-1504711434969-e33886168f5c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'); background-size: cover; background-position: center; color: white; padding-bottom: 100px;">
        <div class="animate">
            <div style="font-size: 6rem; margin-bottom: 20px;">📖</div>
            <h1 style="font-size: 3.5rem; margin: 0; font-weight: 800; letter-spacing: -1px; text-shadow: 2px 2px 15px rgba(0,0,0,0.3);" data-i18n="welcome">GESTION DE JOURNAUX</h1>
            <p style="font-size: 1.8rem; max-width: 700px; margin: 20px auto; opacity: 0.9; font-weight: 600;" data-i18n="system_description">
                CIDST TSIMBAZAZA
            </p>
            <div style="margin-top: 40px; display: flex; gap: 20px; justify-content: center;">
                <a href="search.php" class="btn btn-grey" style="padding: 15px 40px; font-size: 1.1rem;" data-i18n="search">RECHERCHER</a>
                <?php if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])): ?>
                    <a href="index.php" class="btn btn-outline" style="background: white; border-color: white; color: var(--primary-blue); padding: 15px 40px; font-size: 1.1rem;" data-i18n="login">CONNEXION</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="container animate" style="margin-top: -120px; position: relative; z-index: 10;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px;">
            <a href="user_dashboard.php" class="glass-card animate" style="text-align: center; text-decoration: none; transition: transform 0.3s; cursor: pointer; display: block; border-bottom: 4px solid var(--primary-blue); padding: 25px;">
                <div style="font-size: 2.5rem; margin-bottom: 10px;">📰</div>
                <h3 style="color: var(--primary-blue); margin-bottom: 8px; font-size: 1.1rem;" data-i18n="register_journal">Enregistrer un Journal</h3>
                <p style="color: #2755d3ff; font-size: 13px;" data-i18n="manage_journals_desc">Enregistrement de tous les journaux hebdomadaires.</p>
            </a>
            <a href="search.php" class="glass-card animate" style="text-align: center; animation-delay: 0.1s; text-decoration: none; transition: transform 0.3s; cursor: pointer; display: block; border-bottom: 4px solid var(--primary-grey); padding: 25px;">
                <div style="font-size: 2.5rem; margin-bottom: 10px;">🔍</div>
                <h3 style="color: var(--primary-blue); margin-bottom: 8px; font-size: 1.1rem;" data-i18n="quick_search">Recherche Rapide</h3>
                <p style="color: #323fb3ff; font-size: 13px;" data-i18n="quick_search_desc">Recherchez par numéro, éditeur ou date.</p>
            </a>
            <a href="liste_journaux.php" class="glass-card animate" style="text-align: center; animation-delay: 0.2s; text-decoration: none; transition: transform 0.3s; cursor: pointer; display: block; border-bottom: 4px solid var(--primary-blue); padding: 25px;">
                <div style="font-size: 2.5rem; margin-bottom: 10px;">📋</div>
                <h3 style="color: var(--primary-blue); margin-bottom: 8px; font-size: 1.1rem;" data-i18n="recent_entries">Liste des Journaux</h3>
                <p style="color: #3851beff; font-size: 13px;" data-i18n="list_journals_desc">Gérez tous les journaux enregistrés.</p>
            </a>
            <a href="statistiques.php" class="glass-card animate" style="text-align: center; animation-delay: 0.3s; text-decoration: none; transition: transform 0.3s; cursor: pointer; display: block; border-bottom: 4px solid var(--primary-grey); padding: 25px;">
                <div style="font-size: 2.5rem; margin-bottom: 10px;">📈</div>
                <h3 style="color: var(--primary-blue); margin-bottom: 8px; font-size: 1.1rem;" data-i18n="statistics">Statistiques</h3>
                <p style="color: #435be7ff; font-size: 13px;" data-i18n="statistics_desc">Suivi du nombre de journaux et activités.</p>
            </a>
            <a href="liste_utilisateurs.php" class="glass-card animate" style="text-align: center; animation-delay: 0.4s; text-decoration: none; transition: transform 0.3s; cursor: pointer; display: block; border-bottom: 4px solid var(--primary-blue); padding: 25px;">
                <div style="font-size: 2.5rem; margin-bottom: 10px;">👥</div>
                <h3 style="color: var(--primary-blue); margin-bottom: 8px; font-size: 1.1rem;" data-i18n="user_management">Utilisateurs</h3>
                <p style="color: #2447b9ff; font-size: 13px;" data-i18n="monitoring_label">Liste des comptes et surveillance.</p>
            </a>
        </div>

        <!-- Section Statistiques (Tableau de bord) -->
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px; margin-top: 40px;">
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div class="glass-card animate" style="text-align: center; animation-delay: 0.3s; padding: 25px; border-left: 5px solid var(--primary-blue);">
                    <div style="font-size: 3rem; font-weight: 800; color: var(--primary-blue);"><?php echo $total_gazety; ?></div>
                    <div style="color: #2d47beff; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;" data-i18n="total_journals_label">Total Journaux</div>
                </div>
                <div class="glass-card animate" style="text-align: center; animation-delay: 0.4s; padding: 25px; border-left: 5px solid var(--primary-grey);">
                    <div style="font-size: 3rem; font-weight: 800; color: var(--primary-blue);"><?php echo $total_editeurs; ?></div>
                    <div style="color: #2c4a9eff; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;" data-i18n="institutions_label">Institutions</div>
                </div>
            </div>

            <div class="glass-card animate" style="animation-delay: 0.5s; padding: 30px; border-left: 5px solid var(--primary-blue); cursor: pointer;" onclick="this.querySelector('.stats-detail').style.display = (this.querySelector('.stats-detail').style.display === 'none' ? 'block' : 'none')">
                <h3 style="color: var(--primary-blue); margin-top: 0; margin-bottom: 20px; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;" data-i18n="types_actes_title">
                    📑 Types d'actes (Parties)
                </h3>
                <div class="stats-detail" style="display: none;">
                    <p style="color: #3164a7ff; font-size: 14px; margin-bottom: 20px;" data-i18n="click_to_view">
                        Cliquez sur un type d'acte pour voir la liste :
                    </p>
                    <div style="display: flex; flex-wrap: wrap; gap: 15px;">
                        <?php foreach ($types_actes as $type): ?>
                            <a href="public_journals.php?search=<?php echo urlencode($type['partie']); ?>" 
                               class="badge <?php echo rand(0, 1) ? 'badge-blue-dark' : 'badge-grey'; ?>" 
                               style="text-decoration: none; padding: 10px 20px; font-size: 1rem; transition: transform 0.2s;">
                                <?php echo htmlspecialchars($type['partie']); ?> 
                                <span style="background: rgba(24, 44, 156, 0.3); padding: 2px 8px; border-radius: 10px; margin-left: 5px; font-size: 0.8rem;">
                                    <?php 
                                        $percentage = ($total_gazety > 0) ? round(($type['count'] / $total_gazety) * 100, 1) : 0;
                                        echo $percentage . '%'; 
                                    ?>
                                </span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div style="text-align: center; margin-top: 20px; color: #444dc5ff; font-size: 0.8rem;">
                    (Cliquez ici pour voir les détails)
                </div>
            </div>
        </div>

        <div style="margin-top: 40px;">
            <a href="public_journals.php" class="glass-card animate" style="display: flex; align-items: center; justify-content: center; gap: 30px; padding: 40px; text-decoration: none; border-left: 10px solid var(--primary-blue); transition: all 0.3s;">
                <div style="font-size: 4rem;">📚</div>
                <div style="text-align: left;">
                    <h2 style="color: var(--primary-blue); margin: 0; font-size: 2rem;" data-i18n="public_archives">ARCHIVES PUBLIQUES</h2>
                    <p style="color: #2c5ecaff; margin: 5px 0 0 0; font-size: 1.1rem;" data-i18n="public_archives_desc">Recherche et consultation de tous les journaux enregistrés.</p>
                </div>
                <div style="margin-left: auto; font-size: 2rem; color: var(--primary-blue);">➜</div>
            </a>
        </div>
    </div>

    <footer style="margin-top: 80px; padding: 40px; text-align: center; color: #215cb4ff; border-top: 1px solid #cbd5e1;">
        &copy; <?php echo date('Y'); ?> - <span data-i18n="footer_text">CIDST Tsimbazaza</span>
    </footer>
    <script src="js/script.js"></script>
        </div> <!-- close page-content -->
    </div> <!-- close main-layout -->
</div> <!-- close app-container -->
</body>
</html>
