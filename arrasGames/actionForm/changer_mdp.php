<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<?php require_once('../headFoot/header.php') ?>
<?php require_once('../headFoot/nav.php') ?>
</br></br></br></br></br>
<body background="../img/arrasGames-bg-2.jpg">

<div class="formulaire">
<?php
// Démarrer la session si ce n'est pas déjà fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'utilisateur est bien connecté
if (!isset($_SESSION['id'])) {
    echo "Erreur : Vous devez être connecté pour effectuer cette action.";
    exit;
}

// Inclure la connexion à la base de données
require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/dbConnect.php');

$id = $_SESSION['id'];  // ID de l'utilisateur connecté

// Vérifier si le formulaire a été soumis
if (isset($_POST['current_password'], $_POST['new_password'], $_POST['username'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $username = $_POST['username'];

    try {
        // Récupérer l'utilisateur à partir de son ID
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur a été trouvé
        if ($user) {
            // Vérifier que le mot de passe actuel est correct
            if (password_verify($current_password, $user['password'])) {
                // Hachage du nouveau mot de passe
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Mise à jour du mot de passe dans la base de données
                $update_stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                $update_stmt->execute([$hashed_password, $id]);

                // Message de succès
                echo "<h2>Le mot de passe de $username a bien été mis à jour !</h2>";
            } else {
                // Si le mot de passe actuel est incorrect
                echo "<h2 style='color:red;'>Erreur : Le mot de passe actuel est incorrect.</h2>";
            }
        } else {
            // Si l'utilisateur n'existe pas dans la base de données
            echo "<h2 style='color:red;'>Erreur : Utilisateur non trouvé.</h2>";
        }
    } catch (PDOException $e) {
        // Gestion des erreurs PDO
        echo "Erreur lors de la mise à jour du mot de passe : " . $e->getMessage();
    }
} else {
    echo "<h2 style='color:red;'>Erreur : Veuillez remplir tous les champs.</h2>";
}
?>
<p><a href="../compte.php?:<?php echo $id?>">Revenir sur le compte</a></p>
</div>