<?php
$current_page = basename($_SERVER['PHP_SELF']);
$no_sidebar_pages = ['index.php', 'register.php'];
$show_sidebar = !in_array($current_page, $no_sidebar_pages);
?>
<div class="app-container">
    <?php if ($show_sidebar): ?>
    <div class="sidebar">
        <a href="home.php" class="brand" data-i18n="brand_name">GESTION JOURNAUX</a>
        <div class="sidebar-links">
            <a href="home.php" class="sidebar-link <?php echo $current_page == 'home.php' ? 'active' : ''; ?>">
                <span>🏠</span> <span data-i18n="home">Accueil</span>
            </a>
            <a href="public_journals.php" class="sidebar-link <?php echo $current_page == 'public_journals.php' ? 'active' : ''; ?>">
                <span>📚</span> <span data-i18n="public_archives_nav">Archives Publics</span>
            </a>
            
            <?php if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])): ?>
                <a href="<?php echo isset($_SESSION['admin_id']) ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>" 
                   class="sidebar-link <?php echo in_array($current_page, ['admin_dashboard.php', 'user_dashboard.php']) ? 'active' : ''; ?>">
                    <span>📊</span> <span data-i18n="dashboard">Dashboard</span>
                </a>
                <?php if (isset($_SESSION['user_id'])): ?>
                <a href="liste_journaux.php" class="sidebar-link <?php echo $current_page == 'liste_journaux.php' ? 'active' : ''; ?>">
                    <span>📋</span> <span data-i18n="recent_entries">Liste des Journaux</span>
                </a>
                <?php endif; ?>
                <a href="statistiques.php" class="sidebar-link <?php echo $current_page == 'statistiques.php' ? 'active' : ''; ?>">
                    <span>📈</span> <span data-i18n="stats">Statistique</span>
                </a>

                <a href="search.php" class="sidebar-link <?php echo $current_page == 'search.php' ? 'active' : ''; ?>">
                    <span>🔍</span> <span data-i18n="search">Recherche</span>
                </a>
            <?php else: ?>
                <a href="index.php" class="sidebar-link <?php echo $current_page == 'index.php' ? 'active' : ''; ?>">
                    <span>🔑</span> <span data-i18n="login">Login</span>
                </a>
                <a href="register.php" class="sidebar-link <?php echo $current_page == 'register.php' ? 'active' : ''; ?>">
                    <span>📝</span> <span data-i18n="register">Inscription</span>
                </a>
            <?php endif; ?>

            <?php if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])): ?>
                <a href="logout.php" class="sidebar-link" style="margin-top: auto; color: #ffab91;">
                    <span>🚪</span> <span data-i18n="logout">Logout</span>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="main-layout" <?php echo !$show_sidebar ? 'style="margin-left: 0;"' : ''; ?>>
        <div class="top-navbar" style="justify-content: space-between;">
            <!-- Liens de navigation rapides (Actes, Journaux, etc.) - Uniquement sur Entrées récentes -->
            <?php if ($current_page == 'liste_journaux.php'): ?>
            <div style="display: flex; align-items: center; gap: 20px;">
                <a href="liste_journaux.php" class="nav-shortcut" title="Numéro">
                    <span>📄</span> <span data-i18n="journal_number">Numéro</span>
                </a>
                <a href="liste_journaux.php" class="nav-shortcut" title="Journaux">
                    <span>📗</span> <span data-i18n="total_journals">Journaux</span>
                </a>
                <a href="liste_journaux.php" class="nav-shortcut" title="Types d'actes">
                    <span>🔖</span> <span data-i18n="total_types">Types d'actes</span>
                </a>
                <a href="liste_journaux.php" class="nav-shortcut" title="Institutions">
                    <span>🏛️</span> <span data-i18n="total_institutions">Institutions</span>
                </a>
            </div>
            <?php else: ?>
            <div></div> <!-- Spacer pour garder l'alignement -->
            <?php endif; ?>

            <div style="display: flex; align-items: center; gap: 15px;">
                <div style="display: flex; align-items: center; gap: 15px; background: rgba(13, 71, 161, 0.05); padding: 5px 15px; border-radius: 30px;">
                    <div class="theme-switch" id="themeToggle" style="cursor: pointer; font-size: 20px; transition: transform 0.3s;" title="Changer de mode">
                        <span id="themeIcon">🌙</span>
                    </div>
                    <div style="width: 1px; height: 20px; background: rgba(13, 71, 161, 0.1);"></div>
                    <select class="lang-selector" id="langSelect" style="border: none; background: transparent; font-weight: 600; cursor: pointer; padding: 2px 5px;">
                        <option value="fr">FR</option>
                        <option value="en">EN</option>
                    </select>
                </div>
                
                <?php if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])): ?>
                    <div style="font-weight: 600; color: var(--primary-blue); display: flex; align-items: center; gap: 10px; margin-left: 10px; background: rgba(13, 71, 161, 0.05); padding: 5px 15px; border-radius: 30px;">
                        <span style="font-size: 1.2rem;">👤</span> 
                        <span><?php echo $_SESSION['user_nom'] ?? $_SESSION['admin_login'] ?? 'User'; ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="page-content">
