<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$current_page = basename($_SERVER['PHP_SELF']);
?>
<header></header>
<nav>
    <a href="home.php" class="brand" data-i18n="brand_name">GESTION JOURNAUX</a>
    <div class="nav-links">
        <a href="home.php" <?php echo $current_page == 'home.php' ? 'style="color: var(--secondary-orange);"' : ''; ?> data-i18n="home">Accueil</a>
        <a href="public_journals.php" <?php echo $current_page == 'public_journals.php' ? 'style="color: var(--secondary-orange);"' : ''; ?> data-i18n="public_archives_nav">Archives Publics</a>
        <?php if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])): ?>
            <a href="<?php echo isset($_SESSION['admin_id']) ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>" 
               <?php echo in_array($current_page, ['admin_dashboard.php', 'user_dashboard.php']) ? 'style="color: var(--secondary-orange);"' : ''; ?> data-i18n="dashboard">Dashboard</a>
            <a href="statistiques.php" <?php echo $current_page == 'statistiques.php' ? 'style="color: var(--secondary-orange);"' : ''; ?> data-i18n="stats">Statistique</a>
            <a href="search.php" <?php echo $current_page == 'search.php' ? 'style="color: var(--secondary-orange);"' : ''; ?> data-i18n="search">Recherche</a>
        <?php else: ?>
            <a href="index.php" <?php echo $current_page == 'index.php' ? 'style="color: var(--secondary-orange);"' : ''; ?> data-i18n="login">Login</a>
            <a href="register.php" <?php echo $current_page == 'register.php' ? 'style="color: var(--secondary-orange);"' : ''; ?> data-i18n="register">Inscription</a>
        <?php endif; ?>
    </div>
    <div class="nav-controls">
        <select class="lang-selector" id="langSelect">
            <option value="fr">FR</option>
            <option value="en">EN</option>
        </select>
        <div class="theme-switch" id="themeToggle">🌓</div>
        <?php if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])): ?>
            <a href="logout.php" style="color: var(--primary-blue); font-weight: bold; font-size: 12px;" data-i18n="logout">Logout</a>
        <?php endif; ?>
    </div>
</nav>
