<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/dbConnect.php');

// Vérifier que l'utilisateur est connecté et que l'ID du tournoi est fourni
if (isset($_SESSION['id']) && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idUser = $_SESSION['id'];   // ID de l'utilisateur connecté
    $idTournament = intval($_GET['id']);  // ID du tournoi

    try {
        // Suppression de l'inscription dans la table `play`
        $sql = "DELETE FROM play WHERE idUsers = :idUser AND idTournaments = :idTournament";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->bindParam(':idTournament', $idTournament);
        $stmt->execute();

        // Redirection vers la page du tournoi après désinscription
        header("Location: ../tournoi.php?id=$idTournament");
        exit();
    } catch (PDOException $e) {
        echo "ERREUR: " . $e->getMessage();
    }
} else {
    echo "Erreur : ID utilisateur ou tournoi manquant.";
}