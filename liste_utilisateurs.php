<?php
require_once 'db.php';

// Vérifier si un utilisateur est connecté
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$is_admin = isset($_SESSION['admin_id']);
$success = "";
$error = "";

// Actions pour l'utilisateur (admin seulement)
if ($is_admin && isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];

    if ($action == 'block') {
        $stmt = $pdo->prepare("UPDATE utilisateur SET est_bloque = TRUE WHERE id_utilisateur = ?");
        $stmt->execute([$id]);
        $stmt_log = $pdo->prepare("INSERT INTO suivi_operations (id_utilisateur, operation) VALUES (?, ?)");
        $stmt_log->execute([null, "Admin blocked user ID: $id"]);
        $success = "Utilisateur bloqué avec succès.";
    } elseif ($action == 'unblock') {
        $stmt = $pdo->prepare("UPDATE utilisateur SET est_bloque = FALSE WHERE id_utilisateur = ?");
        $stmt->execute([$id]);
        $stmt_log = $pdo->prepare("INSERT INTO suivi_operations (id_utilisateur, operation) VALUES (?, ?)");
        $stmt_log->execute([null, "Admin unblocked user ID: $id"]);
        $success = "Utilisateur débloqué avec succès.";
    } elseif ($action == 'delete') {
        $stmt = $pdo->prepare("DELETE FROM utilisateur WHERE id_utilisateur = ?");
        $stmt->execute([$id]);
        $stmt_log = $pdo->prepare("INSERT INTO suivi_operations (id_utilisateur, operation) VALUES (?, ?)");
        $stmt_log->execute([null, "Admin deleted user ID: $id"]);
        $success = "Utilisateur supprimé avec succès.";
    }
}

// Vérifier les messages via l'URL
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'logo_updated') $success = "Logo CIDST mis à jour avec succès.";
}
if (isset($_GET['error'])) {
    if ($_GET['error'] == 'upload_failed') $error = "Erreur lors de l'upload du logo.";
    if ($_GET['error'] == 'file_too_large') $error = "Le fichier est trop volumineux (max 2MB).";
    if ($_GET['error'] == 'invalid_format') $error = "Seul le format PNG est autorisé.";
}

$users = $pdo->query("SELECT u.*, 
                       (SELECT COUNT(*) FROM periodique p WHERE p.id_utilisateur = u.id_utilisateur) as nb_journaux,
                       (SELECT s.operation FROM suivi_operations s WHERE s.id_utilisateur = u.id_utilisateur ORDER BY s.date_operation DESC LIMIT 1) as derniere_op
                       FROM utilisateur u ORDER BY u.nom ASC")->fetchAll();
$suivi = $pdo->query("SELECT s.*, u.nom, u.prenom FROM suivi_operations s LEFT JOIN utilisateur u ON s.id_utilisateur = u.id_utilisateur ORDER BY s.date_operation DESC LIMIT 50")->fetchAll();
$tentatives = $pdo->query("SELECT * FROM tentatives_connexion ORDER BY date_tentative DESC LIMIT 50")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateurs & Surveillance - CIDST Tsimbazaza</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
</head>
<body class="animate">
    <?php include 'navigation.php'; ?>
    
    <div class="container animate">
        <div class="header-section" style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 20px;">
            <div>
                <h2 data-i18n="admin_dashboard_title" style="margin-bottom: 5px;"><?php echo $is_admin ? 'Tableau de Bord Admin' : 'Liste des Utilisateurs'; ?></h2>
                <p style="opacity: 0.7; font-size: 0.9rem; margin: 0;"><?php echo $is_admin ? 'Gestion des utilisateurs et surveillance' : 'Consultation des membres et activités'; ?></p>
            </div>
            <div style="text-align: right;">
                <span class="badge badge-blue-dark" style="padding: 8px 15px;"><?php echo $is_admin ? 'Admin: ' . $_SESSION['admin_login'] : 'Utilisateur: ' . $_SESSION['user_nom']; ?></span>
            </div>
        </div>

        <?php if ($success): ?>
            <div class="badge badge-green" style="display: block; margin-bottom: 20px; padding: 10px; width: 100%; text-align: center;"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="badge badge-red" style="display: block; margin-bottom: 20px; padding: 10px; width: 100%; text-align: center;"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="glass-card" style="padding: 0; overflow: hidden; margin-bottom: 50px;">
            <div style="overflow-x: auto;">
                <table style="margin: 0;">
                    <thead>
                        <tr>
                            <th data-i18n="name_label">Nom</th>
                            <th data-i18n="fonction_label">Fonction</th>
                            <th data-i18n="journals_added">Journaux</th>
                            <th data-i18n="last_activity">Dernière activité</th>
                            <th data-i18n="status_label">Statut</th>
                            <?php if ($is_admin): ?>
                                <th data-i18n="action_label">Action</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td style="font-weight: 600;"><?php echo htmlspecialchars($u['nom'] . ' ' . $u['prenom']); ?></td>
                                <td><?php echo htmlspecialchars($u['fonction'] ?? '-'); ?></td>
                                <td style="text-align: center;"><span class="badge badge-blue"><?php echo $u['nb_journaux']; ?></span></td>
                                <td style="font-size: 11px; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?php echo htmlspecialchars($u['derniere_op'] ?? '-'); ?>">
                                    <?php echo htmlspecialchars($u['derniere_op'] ?? '-'); ?>
                                </td>
                                <td>
                                    <?php if ($u['est_bloque']): ?>
                                        <span class="badge badge-red" data-i18n="blocked_status">Bloqué</span>
                                    <?php else: ?>
                                        <span class="badge badge-green" data-i18n="active_status">Actif</span>
                                    <?php endif; ?>
                                </td>
                                <?php if ($is_admin): ?>
                                    <td>
                                        <div style="display: flex; gap: 8px;">
                                            <a href="edit_utilisateur.php?id=<?php echo $u['id_utilisateur']; ?>" class="btn btn-grey" style="padding: 6px 12px; font-size: 10px;">Modifier</a>
                                            <?php if ($u['est_bloque']): ?>
                                                <a href="?action=unblock&id=<?php echo $u['id_utilisateur']; ?>" class="btn btn-blue" style="padding: 6px 12px; font-size: 10px;">Débloquer</a>
                                            <?php else: ?>
                                                <a href="?action=block&id=<?php echo $u['id_utilisateur']; ?>" class="btn btn-grey" style="padding: 6px 12px; font-size: 10px;">Bloquer</a>
                                            <?php endif; ?>
                                            <a href="?action=delete&id=<?php echo $u['id_utilisateur']; ?>" onclick="return confirm('Voulez-vous supprimer cet utilisateur ?')" class="btn btn-red" style="padding: 6px 12px; font-size: 10px;">Supprimer</a>
                                        </div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if ($is_admin): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 30px; margin-bottom: 50px;">
            <!-- Paramètres du site (Logo) -->
            <div class="glass-card">
                <h3 style="margin-top: 0; font-size: 1.1rem; color: var(--primary-blue);">⚙️ PARAMÈTRES DU SITE</h3>
                <p style="font-size: 0.85rem; color: #475569; margin-bottom: 20px;">Insérer ou modifier le logo officiel (CIDST Tsimbazaza).</p>
                
                <form action="upload_logo.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Logo CIDST (PNG seulement, max 2MB) :</label>
                        <input type="file" name="logo_cidst" accept=".png" required>
                    </div>
                    <button type="submit" class="btn btn-blue" style="width: 100%;">METTRE À JOUR LE LOGO</button>
                </form>

                <?php if (file_exists('img/logo_cidst.png')): ?>
                    <div style="margin-top: 20px; padding: 15px; background: #f9f9f9; border-radius: 8px; text-align: center;">
                        <p style="font-size: 0.8rem; margin-bottom: 10px;">Logo actuel :</p>
                        <img src="img/logo_cidst.png" alt="Logo actuel" style="max-height: 60px; display: block; margin: 0 auto 10px;">
                        <a href="img/logo_cidst.png" download="logo_cidst.png" class="btn btn-outline" style="font-size: 0.7rem; padding: 5px 10px;">
                            📥 Télécharger le logo
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Statistique rapide -->
            <div class="glass-card">
                <h3 style="margin-top: 0; font-size: 1.1rem; color: var(--primary-blue);">📊 RESUMÉ RAPIDE</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 20px;">
                    <div style="background: var(--light-grey); padding: 15px; border-radius: 8px; text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary-blue);"><?php echo count($users); ?></div>
                        <div style="font-size: 0.75rem; text-transform: uppercase; font-weight: 600;">Utilisateurs</div>
                    </div>
                    <div style="background: var(--light-grey); padding: 15px; border-radius: 8px; text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary-grey);"><?php echo $pdo->query("SELECT COUNT(*) FROM journal")->fetchColumn(); ?></div>
                        <div style="font-size: 0.75rem; text-transform: uppercase; font-weight: 600;">Journaux</div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <h2 data-i18n="monitoring_label">Surveillance</h2>
        <div style="display: grid; grid-template-columns: <?php echo $is_admin ? 'repeat(auto-fit, minmax(450px, 1fr))' : '1fr'; ?>; gap: 30px;">
            <div class="glass-card" style="padding: 0; overflow: hidden;">
                <div style="padding: 20px; border-bottom: 1px solid #eee;">
                    <h3 style="margin: 0; font-size: 1.1rem;" data-i18n="recent_ops_label">Opérations récentes</h3>
                </div>
                <div style="max-height: 500px; overflow-y: auto;">
                    <table style="font-size: 13px;">
                        <thead style="position: sticky; top: 0; z-index: 10;">
                            <tr>
                                <th data-i18n="user_col">Utilisateur</th>
                                <th data-i18n="operation_col">Opération</th>
                                <th data-i18n="date_col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($suivi as $s): ?>
                                <tr>
                                    <td style="font-weight: 600;"><?php echo htmlspecialchars($s['nom'] ?? 'System'); ?></td>
                                    <td>
                                        <?php 
                                        $op = $s['operation'];
                                        $badge_class = 'badge-grey';
                                        if (stripos($op, 'block') !== false || stripos($op, 'delete') !== false) $badge_class = 'badge-blue-dark';
                                        if (stripos($op, 'inscription') !== false || stripos($op, 'unblock') !== false) $badge_class = 'badge-blue';
                                        ?>
                                        <span class="badge <?php echo $badge_class; ?>" style="font-size: 9px;">
                                            <?php echo htmlspecialchars($op); ?>
                                        </span>
                                    </td>
                                    <td style="color: #666; font-size: 11px;"><?php echo date('d/m/Y H:i', strtotime($s['date_operation'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php if ($is_admin): ?>
            <div class="glass-card" style="padding: 0; overflow: hidden;">
                <div style="padding: 20px; border-bottom: 1px solid #e2e8f0;">
                    <h3 style="margin: 0; font-size: 1.1rem;" data-i18n="failed_logins_label">Tentatives de connexion</h3>
                </div>
                <div style="max-height: 500px; overflow-y: auto;">
                    <table style="font-size: 13px;">
                        <thead style="position: sticky; top: 0; z-index: 10;">
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
                                    <td><strong><?php echo htmlspecialchars($t['login_tente']); ?></strong></td>
                                    <td>
                                        <?php if ($t['reussi']): ?>
                                            <span class="badge badge-green">Réussi</span>
                                        <?php else: ?>
                                            <span class="badge badge-red">Échec</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="font-family: monospace; color: #666;"><?php echo htmlspecialchars($t['adresse_ip']); ?></td>
                                    <td style="color: #666; font-size: 11px;"><?php echo date('d/m/Y H:i', strtotime($t['date_tentative'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="js/script.js"></script>
        </div> <!-- close page-content -->
    </div> <!-- close main-layout -->
</div> <!-- close app-container -->
</body>
</html>
