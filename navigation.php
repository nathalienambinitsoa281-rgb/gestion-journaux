<?php
$current_page = basename($_SERVER['PHP_SELF']);
$no_sidebar_pages = ['index.php', 'register.php'];
$show_sidebar = !in_array($current_page, $no_sidebar_pages);
?>
<div class="app-container">
    <?php if ($show_sidebar): ?>
    <div class="sidebar">
        <a href="home.php" class="brand" data-i18n="brand_name">CIDST TSIMBAZAZA</a>
        <div class="sidebar-links">
            <a href="home.php" class="sidebar-link <?php echo $current_page == 'home.php' ? 'active' : ''; ?>">
                <span>🏠</span> <span data-i18n="home">Accueil</span>
            </a>
            <a href="public_journals.php" class="sidebar-link <?php echo $current_page == 'public_journals.php' ? 'active' : ''; ?>">
                <span>📚</span> <span data-i18n="public_archives_nav">Archives Publics</span>
            </a>
            
            <?php if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])): ?>
                <?php if (!isset($_SESSION['admin_id'])): ?>
                    <a href="user_dashboard.php" 
                       class="sidebar-link <?php echo $current_page == 'user_dashboard.php' ? 'active' : ''; ?>">
                        <span>📊</span> <span data-i18n="dashboard">Tableau de bord</span>
                    </a>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                <a href="liste_journaux.php" class="sidebar-link <?php echo $current_page == 'liste_journaux.php' ? 'active' : ''; ?>">
                    <span>📋</span> <span data-i18n="recent_entries">Entrées récentes</span>
                </a>
                <?php endif; ?>
                
                <a href="statistiques.php" class="sidebar-link <?php echo $current_page == 'statistiques.php' ? 'active' : ''; ?>">
                    <span>📈</span> <span data-i18n="stats">Statistiques</span>
                </a>

                <a href="search.php" class="sidebar-link <?php echo $current_page == 'search.php' ? 'active' : ''; ?>">
                    <span>🔍</span> <span data-i18n="search">RECHERCHER</span>
                </a>

                <a href="liste_utilisateurs.php" class="sidebar-link <?php echo $current_page == 'liste_utilisateurs.php' ? 'active' : ''; ?>">
                    <span>👥</span> <span data-i18n="user_management">Utilisateurs</span>
                </a>

                <!-- Box bottom for Logged In users -->
                <div style="margin-top: auto; background: rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 8px;">
                    <?php if (!isset($_SESSION['admin_id'])): ?>
                        <a href="register.php" class="sidebar-link <?php echo $current_page == 'register.php' ? 'active' : ''; ?>" style="margin-bottom: 5px;">
                            <span>📝</span> <span data-i18n="register">S'INSCRIRE</span>
                        </a>
                    <?php endif; ?>
                    <a href="logout.php" class="sidebar-link" style="color: rgba(255, 255, 255, 0.7); background: transparent;">
                        <span>🚪</span> <span data-i18n="logout">Déconnexion</span>
                    </a>
                </div>
            <?php else: ?>
                <!-- Box bottom for Logged Out users -->
                <div style="margin-top: auto; background: rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 8px;">
                    <a href="index.php" class="sidebar-link <?php echo $current_page == 'index.php' ? 'active' : ''; ?>" style="margin-bottom: 5px;">
                        <span>🔑</span> <span data-i18n="login">Login</span>
                    </a>
                    <a href="register.php" class="sidebar-link <?php echo $current_page == 'register.php' ? 'active' : ''; ?>">
                        <span>📝</span> <span data-i18n="register">S'INSCRIRE</span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="main-layout" <?php echo !$show_sidebar ? 'style="margin-left: 0;"' : ''; ?>>
        <div class="top-navbar" style="justify-content: space-between;">
            <button class="menu-toggle" id="menuToggle" style="margin-right: 15px;">☰</button>
            <div style="display: flex; align-items: center; gap: 20px; flex: 1;">
                <!-- Barre de recherche AJAX -->
                <div class="search-container" style="position: relative; width: 100%; max-width: 400px;">
                    <div style="position: relative; display: flex; align-items: center;">
                        <span style="position: absolute; left: 15px; color: #0c3e9bff;">🔍</span>
                        <input type="text" id="globalSearch" placeholder="Recherche rapide (Numéro, éditeur...)" 
                               style="width: 100%; padding: 10px 15px 10px 40px; border-radius: 25px; border: 1px solid rgba(21, 101, 192, 0.2); background: white; outline: none; transition: all 0.3s;"
                               onkeyup="handleRealTimeSearch(this.value)">
                    </div>
                    <div id="searchResults" style="position: absolute; top: 100%; left: 0; right: 0; background: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(21, 101, 192, 0.1); z-index: 1000; margin-top: 10px; display: none; max-height: 400px; overflow-y: auto; border: 1px solid #e2e8f0;">
                        <!-- Résultats de recherche ici -->
                    </div>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 15px;">
                <div style="display: flex; align-items: center; gap: 15px; background: rgba(21, 101, 192, 0.05); padding: 5px 15px; border-radius: 30px;">
                    <div class="theme-switch" id="themeToggle" style="cursor: pointer; font-size: 20px; transition: transform 0.3s;" title="Changer de mode">
                        <span id="themeIcon">🌙</span>
                    </div>
                    <div style="width: 1px; height: 20px; background: rgba(21, 101, 192, 0.1);"></div>
                    <select class="lang-selector" id="langSelect" style="border: none; background: transparent; font-weight: 600; cursor: pointer; padding: 2px 5px;">
                        <option value="fr">FR</option>
                        <option value="en">EN</option>
                    </select>
                </div>
                
                <?php if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])): ?>
                    <div style="font-weight: 600; color: var(--primary-blue); display: flex; align-items: center; gap: 10px; margin-left: 10px; background: rgba(21, 101, 192, 0.05); padding: 5px 15px; border-radius: 30px;">
                        <span style="font-size: 1.2rem;">👤</span> 
                        <span><?php echo $_SESSION['user_nom'] ?? $_SESSION['admin_login'] ?? 'User'; ?></span>
                    </div>
                <?php endif; ?>
                
                <!-- Logo CIDST Tsimbazaza -->
                <div class="logo-container" style="margin-left: 15px; display: flex; align-items: center; border-left: 1px solid rgba(33, 33, 33, 0.1); padding-left: 15px;">
                    <?php if (file_exists('img/logo_cidst.png')): ?>
                        <img src="img/logo_cidst.png" alt="Logo CIDST" style="height: 50px; width: auto; object-fit: contain;">
                    <?php else: ?>
                        <div style="background: linear-gradient(135deg, var(--primary-blue), #0d47a1); color: white; padding: 8px 15px; border-radius: 6px; font-weight: 800; font-size: 16px; text-align: center; line-height: 1; box-shadow: 0 4px 10px rgba(21, 101, 192, 0.2); border: 1px solid rgba(255,255,255,0.2);">
                            CIDST<br><span style="font-size: 9px; font-weight: 400; letter-spacing: 1px; opacity: 0.9;">TSIMBAZAZA</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="page-content">
