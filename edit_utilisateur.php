<?php
require_once 'db.php';

// Hamarino raha Admin no tafiditra
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$error = "";
$success = "";
$user_data = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = ?");
    $stmt->execute([$id]);
    $user_data = $stmt->fetch();

    if (!$user_data) {
        header("Location: liste_utilisateurs.php");
        exit();
    }
} else {
    header("Location: liste_utilisateurs.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_user'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $matricule = $_POST['matricule'];
    $fonction = $_POST['fonction'];
    $contact = $_POST['contact'];
    $adresse = $_POST['adresse'];

    try {
        $stmt = $pdo->prepare("UPDATE utilisateur SET nom = ?, prenom = ?, matricule = ?, fonction = ?, contact = ?, adresse = ? WHERE id_utilisateur = ?");
        $stmt->execute([$nom, $prenom, $matricule, $fonction, $contact, $adresse, $id]);
        
        // Log operation
        $stmt_log = $pdo->prepare("INSERT INTO suivi_operations (id_utilisateur, operation) VALUES (?, ?)");
        $stmt_log->execute([null, "Admin updated user: $matricule"]);
        
        $success = "Informations de l'utilisateur mises à jour avec succès.";
        // Refresh data
        $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = ?");
        $stmt->execute([$id]);
        $user_data = $stmt->fetch();
    } catch (PDOException $e) {
        $error = "Erreur: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Utilisateur - CIDST</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
</head>
<body class="animate">
    <?php include 'navigation.php'; ?>
    <div class="container animate">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h2 style="margin-bottom: 0;">Modifier Utilisateur</h2>
            <a href="liste_utilisateurs.php" class="btn btn-outline" style="padding: 8px 20px; font-size: 0.9rem; text-transform: none;">
                ⬅️ <span data-i18n="home">Retour</span>
            </a>
        </div>

        <?php if ($success): ?>
            <div class="badge badge-green" style="display: block; margin-bottom: 20px;"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="badge badge-red" style="display: block; margin-bottom: 20px;"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="glass-card animate">
            <form action="" method="POST" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div class="form-group">
                    <label data-i18n="name_label">Nom:</label>
                    <input type="text" name="nom" value="<?php echo htmlspecialchars($user_data['nom']); ?>" required>
                </div>
                <div class="form-group">
                    <label data-i18n="prenom_label">Prénom:</label>
                    <input type="text" name="prenom" value="<?php echo htmlspecialchars($user_data['prenom']); ?>" required>
                </div>
                <div class="form-group">
                    <label data-i18n="cin_label">Matricule:</label>
                    <input type="text" name="matricule" value="<?php echo htmlspecialchars($user_data['matricule']); ?>" required>
                </div>
                <div class="form-group">
                    <label data-i18n="fonction_label">Fonction:</label>
                    <input type="text" name="fonction" value="<?php echo htmlspecialchars($user_data['fonction'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Contact:</label>
                    <input type="text" name="contact" value="<?php echo htmlspecialchars($user_data['contact'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Adresse:</label>
                    <input type="text" name="adresse" value="<?php echo htmlspecialchars($user_data['adresse'] ?? ''); ?>">
                </div>
                <div style="grid-column: 1 / -1; margin-top: 20px;">
                    <button type="submit" name="update_user" class="btn btn-blue" style="width: 100%; padding: 15px;">Mettre à jour l'utilisateur</button>
                </div>
            </form>
        </div>
    </div>
    <script src="js/script.js"></script>
        </div> <!-- close page-content -->
    </div> <!-- close main-layout -->
</div> <!-- close app-container -->
</body>
</html>
