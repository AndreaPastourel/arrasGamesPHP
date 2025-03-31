<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/dbConnect.php');
$id = $_GET['id'];

try {
    // Supprimer d'abord toutes les participations liées au tournoi dans la table "play"
    $stmt = $pdo->prepare("DELETE FROM play WHERE idTournaments = ?");
    $stmt->execute([$id]);

    // Ensuite, supprimer le tournoi dans la table "tournaments"
    $stmt = $pdo->prepare("DELETE FROM tournaments WHERE id = ?");
    $stmt->execute([$id]);

    // Rediriger vers la page de gestion des tournois après suppression
    header("Location: ../../crudTournament.php");
    exit();
} catch(PDOException $e) {
    echo "ERREUR: " . $e->getMessage();
}
?>