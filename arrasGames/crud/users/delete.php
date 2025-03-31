<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/dbConnect.php');
$id = $_GET['id'];

try {
    // Supprimer d'abord toutes les participations dans la table "play" pour cet utilisateur
    $stmt = $pdo->prepare("DELETE FROM play WHERE idUsers = ?");
    $stmt->execute([$id]);

    // Ensuite, supprimer l'utilisateur dans la table "users"
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);

    // Rediriger vers la page de gestion des utilisateurs après suppression
    header("Location: ../../crudUsers.php");
    exit();
} catch(PDOException $e) {
    echo "ERREUR: " . $e->getMessage();
}
?>
