<?php
session_start();
require_once 'db.php';

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];
    $contact = $_POST['contact']; 
    $cin = $_POST['cin'];
    $password = $_POST['password'];

    // Vérification du CIN (12 chiffres)
    if (!preg_match('/^[0-9]{12}$/', $cin)) {
        $error = "Le CIN doit comporter 12 chiffres.";
    } else {
        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("SELECT 1 FROM utilisateur WHERE cin = ?");
            $stmt->execute([$cin]);
            if ($stmt->fetch()) {
                $error = "Ce CIN est déjà utilisé.";
                $pdo->rollBack();
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO utilisateur (nom, prenom, adresse, contact, cin, mot_de_passe) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$nom, $prenom, $adresse, $contact, $cin, $hashed_password]);
                $new_user_id = $pdo->lastInsertId();

                // Log operation
                $stmt_log = $pdo->prepare("INSERT INTO suivi_operations (id_utilisateur, operation) VALUES (?, ?)");
                $stmt_log->execute([$new_user_id, "Inscription nouvel utilisateur: $nom $prenom"]);

                $pdo->commit();
            
                // Connexion automatique après inscription
                $_SESSION['user_id'] = $new_user_id;
                $_SESSION['user_nom'] = $nom . ' ' . $prenom;
                header("Location: user_dashboard.php");
                exit();
            }
        } catch (PDOException $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            $error = "Erreur de base de données : " . $e->getMessage();
        }
    }
}
include 'navigation.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-i18n="register_title">S'inscrire - Journal Archives</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
</head>
<body class="animate">
    <div class="container animate" style="max-width: 600px; margin-top: 40px;">
        <h2 style="text-align: center;" data-i18n="register">S'INSCRIRE</h2>
        
        <?php if ($error): ?>
            <div class="badge badge-red" style="display: block; margin-bottom: 25px; text-align: center; padding: 12px;"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                <div class="form-group">
                    <label data-i18n="name">Nom:</label>
                    <input type="text" name="nom" placeholder="Nom..." data-i18n="nom_placeholder" required>
                </div>
                <div class="form-group">
                    <label data-i18n="prenom_label">Prénom:</label>
                    <input type="text" name="prenom" placeholder="Prénom..." data-i18n="prenom_placeholder" required>
                </div>
                <div class="form-group">
                    <label>CIN (12 digits):</label>
                    <input type="text" name="cin" maxlength="12" minlength="12" pattern="[0-9]{12}" placeholder="Exemple: 101202..." data-i18n="cin_placeholder" required>
                </div>
                <div class="form-group">
                    <label>Contact:</label>
                    <input type="text" name="contact" placeholder="Exemple: +261 34..." data-i18n="contact_placeholder" required>
                </div>
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Adresse:</label>
                    <input type="text" name="adresse" placeholder="Lieu de résidence..." data-i18n="address_placeholder">
                </div>
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label data-i18n="password_label">Mot de passe :</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" class="btn" style="width: 100%; margin-top: 20px;" data-i18n="register">S'INSCRIRE</button>
        </form>
        
        <div style="text-align: center; margin-top: 30px; font-size: 14px; color: #666;">
            <span data-i18n="already_have_account">Vous avez déjà un compte ?</span> <a href="index.php" style="color: var(--primary-blue); font-weight: 700; text-decoration: none;" data-i18n="login">Se connecter</a>
        </div>
    </div>
    
    <footer style="margin-top: 50px; padding: 30px; text-align: center; color: #888; font-size: 12px;">
        &copy; <?php echo date('Y'); ?> - <span data-i18n="footer_text">Ministère de l'Intérieur</span>
    </footer>
    <script src="js/script.js"></script>
</body>
</html>
