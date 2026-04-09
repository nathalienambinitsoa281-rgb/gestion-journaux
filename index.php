<?php
session_start();
require_once 'db.php';

$error = "";

if (isset($_GET['error']) && $_GET['error'] == 'session_expired') {
    $error = "Session expirée ou utilisateur inexistant. Veuillez vous reconnecter.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $ip = $_SERVER['REMOTE_ADDR'];

    $stmt = $pdo->prepare("SELECT * FROM admin_logiciel WHERE login = ? AND mot_de_passe = ?");
    $stmt->execute([$login, $password]);
    $admin = $stmt->fetch();

    if ($admin) {
        // Enregistrer la tentative réussie pour l'admin
        $stmt_log = $pdo->prepare("INSERT INTO tentatives_connexion (login_tente, reussi, adresse_ip) VALUES (?, 1, ?)");
        $stmt_log->execute([$login, $ip]);

        $_SESSION['admin_id'] = $admin['id_admin'];
        $_SESSION['admin_login'] = $admin['login'];
        header("Location: admin_dashboard.php");
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE cin = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['mot_de_passe'])) {
        if ($user['est_bloque']) {
            // Tentative bloquée
            $stmt_log = $pdo->prepare("INSERT INTO tentatives_connexion (login_tente, reussi, adresse_ip) VALUES (?, 0, ?)");
            $stmt_log->execute([$login, $ip]);
            $error = "Ce compte est déjà bloqué. Contactez l'administrateur.";
        } else {
            // Tentative réussie pour l'utilisateur
            $stmt_log = $pdo->prepare("INSERT INTO tentatives_connexion (login_tente, reussi, adresse_ip) VALUES (?, 1, ?)");
            $stmt_log->execute([$login, $ip]);

            $_SESSION['user_id'] = $user['id_utilisateur'];
            $_SESSION['user_nom'] = $user['nom'] . ' ' . $user['prenom'];
            header("Location: user_dashboard.php");
            exit();
        }
    } else {
        // Tentative échouée
        $stmt_log = $pdo->prepare("INSERT INTO tentatives_connexion (login_tente, reussi, adresse_ip) VALUES (?, 0, ?)");
        $stmt_log->execute([$login, $ip]);
        $error = "Login ou mot de passe incorrect.";
    }
}
include 'navigation.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-i18n="title_login">Connexion - Gestion des Journaux</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
</head>
<body class="animate">
    <div class="container animate" style="max-width: 450px; margin-top: 60px;">
        <h2 style="text-align: center;" data-i18n="login">CONNEXION</h2>
        
        <?php if ($error): ?>
            <div class="badge badge-red" style="display: block; margin-bottom: 25px; text-align: center; padding: 12px;"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label data-i18n="login_label">Login (CIN ou Admin) :</label>
                <input type="text" name="login" placeholder="Entrez votre login..." data-i18n="login_placeholder" required>
            </div>
            <div class="form-group">
                <label data-i18n="password_label">Mot de passe :</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn" style="width: 100%; margin-top: 10px;" data-i18n="login">SE CONNECTER</button>
        </form>
        
        <div style="text-align: center; margin-top: 30px; font-size: 14px; color: #666;">
            <span data-i18n="no_account">Pas encore de compte ?</span> <a href="register.php" style="color: var(--primary-blue); font-weight: 700; text-decoration: none;" data-i18n="register">S'inscrire</a>
        </div>
    </div>
    
    <footer style="position: fixed; bottom: 20px; width: 100%; text-align: center; color: #888; font-size: 12px;">
        &copy; <?php echo date('Y'); ?> - <span data-i18n="footer_text">Ministère de l'Intérieur</span>
    </footer>
    <script src="js/script.js"></script>
</body>
</html>
