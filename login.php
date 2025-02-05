<?php
session_start();
require_once './src/config/Database.php';  // Fichier de connexion à la base de données

use Config\Database;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $password = $_POST['password'];

    // Connexion à la base de données
    $db = Database::getConnection();

    // Vérification du nom d'utilisateur
    $stmt = $db->prepare('SELECT * FROM administrateurs WHERE nom = :nom');
    $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
    $stmt->execute();

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['mot_de_passe'])) {
        // Connexion réussie
        $_SESSION['admin'] = $admin['id'];
        header('Location: /portfolio_v01/admin/projets/list.php');
        exit;
    } else {
        $error = 'Nom ou mot de passe incorrect.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Connexion Administrateur</title>
</head>
<body>
    <h1>Connexion</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="post" action="login.php">
    <label>Nom d'utilisateur :</label>
    <input type="text" name="nom" required>
    
    <label>Mot de passe :</label>
    <input type="password" name="password" required>

    <button type="submit">Se connecter</button>
</form>

</body>
</html>
