<?php
require_once 'db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Journal Archives</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
</head>
<body class="animate">
    <?php include 'navigation.php'; ?>
    <div style="height: 60vh; display: flex; align-items: center; justify-content: center; text-align: center; background: linear-gradient(rgba(13, 71, 161, 0.7), rgba(13, 71, 161, 0.7)), url('https://images.unsplash.com/photo-1504711434969-e33886168f5c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'); background-size: cover; background-position: center; color: white;">
        <div class="animate">
            <h1 style="font-size: 3.5rem; margin: 0; font-weight: 800; letter-spacing: -1px; text-shadow: 2px 2px 10px rgba(13, 71, 161, 0.5);" data-i18n="welcome">BIENVENUE</h1>
            <p style="font-size: 1.2rem; max-width: 700px; margin: 20px auto; opacity: 0.9; font-weight: 300;" data-i18n="system_description">
                Système de gestion des journaux et des archives.
            </p>
            <div style="margin-top: 40px; display: flex; gap: 20px; justify-content: center;">
                <a href="search.php" class="btn" data-i18n="search">RECHERCHER</a>
                <?php if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])): ?>
                    <a href="index.php" class="btn btn-outline" style="background: white; border-color: white; color: var(--primary-blue);" data-i18n="login">CONNEXION</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="container animate" style="margin-top: -60px; position: relative; z-index: 10;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
            <a href="user_dashboard.php" class="glass-card animate" style="text-align: center; text-decoration: none; transition: transform 0.3s; cursor: pointer; display: block;">
                <div style="font-size: 3.5rem; margin-bottom: 20px;">📰</div>
                <h3 style="color: var(--primary-blue);" data-i18n="register_journal">Enregistrer un Journal</h3>
                <p style="color: #666; font-size: 14px;" data-i18n="manage_journals_desc">Enregistrement de tous les journaux hebdomadaires avec numéro précis.</p>
            </a>
            <a href="search.php" class="glass-card animate" style="text-align: center; animation-delay: 0.1s; text-decoration: none; transition: transform 0.3s; cursor: pointer; display: block;">
                <div style="font-size: 3.5rem; margin-bottom: 20px;">🔍</div>
                <h3 style="color: var(--primary-blue);" data-i18n="quick_search">Recherche Rapide</h3>
                <p style="color: #666; font-size: 14px;" data-i18n="quick_search_desc">Recherchez toutes les informations par numéro de gazette, éditeur ou date.</p>
            </a>
            <a href="liste_journaux.php" class="glass-card animate" style="text-align: center; animation-delay: 0.2s; text-decoration: none; transition: transform 0.3s; cursor: pointer; display: block;">
                <div style="font-size: 3.5rem; margin-bottom: 20px;">📋</div>
                <h3 style="color: var(--primary-blue);" data-i18n="recent_entries">Liste des Journaux</h3>
                <p style="color: #666; font-size: 14px;">Consultez et gérez tous les journaux que vous avez enregistrés.</p>
            </a>
            <a href="statistiques.php" class="glass-card animate" style="text-align: center; animation-delay: 0.3s; text-decoration: none; transition: transform 0.3s; cursor: pointer; display: block;">
                <div style="font-size: 3.5rem; margin-bottom: 20px;">📊</div>
                <h3 style="color: var(--primary-blue);" data-i18n="statistics">Statistiques</h3>
                <p style="color: #666; font-size: 14px;" data-i18n="statistics_desc">Suivi du nombre de journaux et des activités de tous les utilisateurs.</p>
            </a>
        </div>
    </div>

    <div class="container animate" style="margin-top: 60px;">
        <h2 style="text-align: center; color: var(--primary-blue); margin-bottom: 40px;" data-i18n="gallery_title">GALERIE DES ARCHIVES</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
            <div class="glass-card" style="padding: 10px; overflow: hidden; height: 250px;">
                <img src="https://images.unsplash.com/photo-1585829365234-781fcd69186b?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Journal 1" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
            </div>
            <div class="glass-card" style="padding: 10px; overflow: hidden; height: 250px; animation-delay: 0.1s;">
                <img src="https://images.unsplash.com/photo-1504711434969-e33886168f5c?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Journal 2" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
            </div>
            <div class="glass-card" style="padding: 10px; overflow: hidden; height: 250px; animation-delay: 0.2s;">
                <img src="https://images.unsplash.com/photo-1566378246598-5b11a0d486cc?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Journal 3" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
            </div>
            <div class="glass-card" style="padding: 10px; overflow: hidden; height: 250px; animation-delay: 0.3s;">
                <img src="https://images.unsplash.com/photo-1572949645841-3947a407c563?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Journal 4" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
            </div>
            <div class="glass-card" style="padding: 10px; overflow: hidden; height: 250px; animation-delay: 0.4s;">
                <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Journal 5" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
            </div>
            <div class="glass-card" style="padding: 10px; overflow: hidden; height: 250px; animation-delay: 0.5s;">
                <img src="https://images.unsplash.com/photo-1495020689067-958852a7765e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Journal 6" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
            </div>
        </div>
    </div>

    <footer style="margin-top: 80px; padding: 40px; text-align: center; color: #888; border-top: 1px solid #ddd;">
        &copy; <?php echo date('Y'); ?> - <span data-i18n="footer_text">Ministère de l'Intérieur</span>
    </footer>
    <script src="js/script.js"></script>
        </div> <!-- close page-content -->
    </div> <!-- close main-layout -->
</div> <!-- close app-container -->
</body>
</html>
