<?php
require_once 'db.php';

// Hamarino raha Admin no tafiditra
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$success = "";
$error = "";

// Action ho an'ny utilisateur (block, unblock, delete)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];

    if ($action == 'block') {
        $stmt = $pdo->prepare("UPDATE utilisateur SET est_bloque = TRUE WHERE id_utilisateur = ?");
        $stmt->execute([$id]);
        
        // Log operation
        $stmt_log = $pdo->prepare("INSERT INTO suivi_operations (id_utilisateur, operation) VALUES (?, ?)");
        $stmt_log->execute([null, "Admin blocked user ID: $id"]);
        
        $success = "Utilisateur bloqué avec succès.";
    } elseif ($action == 'unblock') {
        $stmt = $pdo->prepare("UPDATE utilisateur SET est_bloque = FALSE WHERE id_utilisateur = ?");
        $stmt->execute([$id]);

        // Log operation
        $stmt_log = $pdo->prepare("INSERT INTO suivi_operations (id_utilisateur, operation) VALUES (?, ?)");
        $stmt_log->execute([null, "Admin unblocked user ID: $id"]);

        $success = "Utilisateur débloqué avec succès.";
    } elseif ($action == 'delete') {
        $stmt = $pdo->prepare("DELETE FROM utilisateur WHERE id_utilisateur = ?");
        $stmt->execute([$id]);

        // Log operation
        $stmt_log = $pdo->prepare("INSERT INTO suivi_operations (id_utilisateur, operation) VALUES (?, ?)");
        $stmt_log->execute([null, "Admin deleted user ID: $id"]);

        $success = "Utilisateur supprimé avec succès.";
    }
}

$users = $pdo->query("SELECT * FROM utilisateur ORDER BY nom ASC")->fetchAll();
$suivi = $pdo->query("SELECT s.*, u.nom, u.prenom FROM suivi_operations s LEFT JOIN utilisateur u ON s.id_utilisateur = u.id_utilisateur ORDER BY s.date_operation DESC LIMIT 50")->fetchAll();
$tentatives = $pdo->query("SELECT * FROM tentatives_connexion ORDER BY date_tentative DESC LIMIT 50")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Gestion des Journaux</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
</head>
<body class="animate">
    <?php include 'navigation.php'; ?>
    <div class="container animate">
        <h2 data-i18n="user_management">Gestion des Utilisateurs</h2>
        <p style="margin-bottom: 25px; opacity: 0.8;">Admin: <strong><?php echo $_SESSION['admin_login']; ?></strong></p>

        <?php if ($success): ?>
            <div class="badge badge-green" style="display: block; margin-bottom: 20px;"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="glass-card" style="padding: 0; overflow: hidden;">
            <table style="margin-top: 0;">
                <thead>
                    <tr>
                        <th data-i18n="name_label">Nom</th>
                        <th data-i18n="cin_label">CIN / Matricule (Login)</th>
                        <th data-i18n="status_label">Statut</th>
                        <th data-i18n="action_label">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($u['nom'] . ' ' . $u['prenom']); ?></td>
                            <td><code><?php echo htmlspecialchars($u['matricule']); ?></code></td>
                            <td>
                                <?php if ($u['est_bloque']): ?>
                                    <span class="badge badge-red" data-i18n="blocked_status">Bloqué</span>
                                <?php else: ?>
                                    <span class="badge badge-green" data-i18n="active_status">Actif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div style="display: flex; gap: 10px;">
                                     <?php if ($u['est_bloque']): ?>
                                         <a href="?action=unblock&id=<?php echo $u['id_utilisateur']; ?>" class="btn" style="background-color: #ffc107; padding: 5px 12px; font-size: 11px;" data-i18n="unblock_btn">Débloquer</a>
                                     <?php else: ?>
                                         <a href="?action=block&id=<?php echo $u['id_utilisateur']; ?>" class="btn" style="background-color: #fd7e14; padding: 5px 12px; font-size: 11px;" data-i18n="block_btn">Bloquer</a>
                                     <?php endif; ?>
                                     <a href="?action=delete&id=<?php echo $u['id_utilisateur']; ?>" onclick="return confirm(translations[localStorage.getItem('lang') || 'fr'].confirm_delete)" class="btn" style="background-color: #dc3545; padding: 5px 12px; font-size: 11px;" data-i18n="delete_btn">Supprimer</a>
                                 </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <h2 style="margin-top: 60px;" data-i18n="monitoring_label">Surveillance</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px;">
            <div class="glass-card">
                <h3 style="color: var(--primary-blue); margin-top: 0;" data-i18n="recent_ops_label">Opérations récentes</h3>
                <div style="max-height: 400px; overflow-y: auto;">
                    <table style="font-size: 12px;">
                        <thead>
                            <tr>
                                <th data-i18n="user_col">Utilisateur</th>
                                <th data-i18n="operation_col">Opération</th>
                                <th data-i18n="date_col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($suivi as $s): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($s['nom'] ?? 'System'); ?></strong></td>
                                    <td>
                                        <?php 
                                        $op = $s['operation'];
                                        $badge_class = 'badge-blue';
                                        if (strpos($op, 'blocked') !== false || strpos($op, 'deleted') !== false || strpos($op, 'Suppression') !== false) $badge_class = 'badge-red';
                                        if (strpos($op, 'Inscription') !== false || strpos($op, 'unblocked') !== false) $badge_class = 'badge-green';
                                        ?>
                                        <span class="badge <?php echo $badge_class; ?>" style="font-size: 10px; padding: 3px 8px;">
                                            <?php echo htmlspecialchars($op); ?>
                                        </span>
                                    </td>
                                    <td><small style="color: #888;"><?php echo date('d/m/Y H:i', strtotime($s['date_operation'])); ?></small></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="glass-card">
                <h3 style="color: var(--primary-blue); margin-top: 0;" data-i18n="failed_logins_label">Tentatives de connexion</h3>
                <div style="max-height: 400px; overflow-y: auto;">
                    <table style="font-size: 12px;">
                        <thead>
                            <tr>
                                <th data-i18n="login">Login</th>
                                <th data-i18n="status_label">Statut</th>
                                <th data-i18n="ip_col">Adresse IP</th>
                                <th data-i18n="date_col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tentatives as $t): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($t['login_tente']); ?></td>
                                    <td>
                                        <?php if ($t['reussi']): ?>
                                            <span class="badge badge-green">Réussi</span>
                                        <?php else: ?>
                                            <span class="badge badge-red">Échec</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($t['adresse_ip']); ?></td>
                                    <td><small><?php echo $t['date_tentative']; ?></small></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
        </div> <!-- close page-content -->
    </div> <!-- close main-layout -->
</div> <!-- close app-container -->
</body>
</html>
