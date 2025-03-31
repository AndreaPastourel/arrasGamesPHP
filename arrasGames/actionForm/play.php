<?php
// Démarrer la session
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/dbConnect.php');

if (isset($_GET['id']) && isset($_SESSION['id'])) {
    $idTournament = $_GET['id'];   // ID du tournoi
    $idUser = $_SESSION['id'];     // ID de l'utilisateur connecté
    $currentDate = date('Y-m-d H:i:s');  // Récupérer la date actuelle

    try {
        // Préparation de l'insertion dans la table `play`
        $stmt = $pdo->prepare("INSERT INTO `play` (`idUsers`, `idTournaments`, `registred`) VALUES (?, ?, ?)");
        $stmt->execute([$idUser, $idTournament, $currentDate]);

        // Redirection vers la page du tournoi
        header("Location: ../tournoi.php?id=$idTournament");
        exit();  // Assurez-vous que le script s'arrête après la redirection
    } catch (PDOException $e) {
        // Afficher un message d'erreur si quelque chose ne va pas
        echo "ERREUR: " . $e->getMessage();
    }
} else {
    echo "Erreur : ID utilisateur ou tournoi manquant.";
}