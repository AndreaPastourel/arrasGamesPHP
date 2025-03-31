<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('dbConnect.php'); 
require('headFoot/header.php');?>
<html>
    <body background="img/arrasGames-bg-1.jpg">

        <?php require_once('headFoot/nav.php'); ?>
        </br></br></br></br>
        <div class="tournament">
<?php

    // Récupérer l'ID du tournoi à partir de l'URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = intval($_GET['id']);

        // Requête SQL pour obtenir les détails du tournoi
        $sql = "SELECT tournaments.*, games.name AS gameName
        FROM tournaments 
        JOIN games ON tournaments.idGames = games.id
        WHERE tournaments.id = :id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $tournament = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tournament) {
            // Affichage des détails du tournoi
            echo "<h2>" . htmlspecialchars($tournament['name']) . "</h2>";
            echo "<p>Date de début : " . htmlspecialchars($tournament['startDate']) . "</p>";
            echo "<p>Date de fin : " . htmlspecialchars($tournament['endDate']) . "</p>";
            echo "<p>Jeu : " . htmlspecialchars($tournament['gameName']) . "</p>";
            echo "<img src='uploads/" . htmlspecialchars($tournament['image']) . "' alt='" . htmlspecialchars($tournament['name']) . "' width='200px'>";

            // Requête SQL pour obtenir les participants du tournoi
            $sqlParticipants = "SELECT u.username 
                                FROM play p 
                                JOIN users u ON p.idUsers = u.id 
                                WHERE p.idTournaments = :tournamentId";
            $stmtParticipants = $pdo->prepare($sqlParticipants);
            $stmtParticipants->bindParam(':tournamentId', $id);
            $stmtParticipants->execute();
            $participants = $stmtParticipants->fetchAll(PDO::FETCH_ASSOC);

            // Affichage des participants
            echo "<h3>Participants :</h3>";
            if (count($participants) > 0) {
                echo "<ul>";
                foreach ($participants as $participant) {
                    echo "<li>" . htmlspecialchars($participant['username']) . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>Aucun participant pour ce tournoi.</p>";
            }
   // Vérification si l'utilisateur est déjà inscrit
   if (isset($_SESSION['id'])) {
    $idUser = $_SESSION['id'];
    
    $sqlCheck = "SELECT * FROM play WHERE idUsers = :idUser AND idTournaments = :idTournament";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->bindParam(':idUser', $idUser);
    $stmtCheck->bindParam(':idTournament', $id);
    $stmtCheck->execute();
    
    if ($stmtCheck->rowCount() > 0) {
        // Si l'utilisateur est inscrit, afficher le bouton de désinscription
        echo "<button onclick='confirmUnregistration(" . $tournament['id'] . ")'>Se désinscrire</button>";
    } else {
        // Si l'utilisateur n'est pas inscrit, afficher le bouton d'inscription
        echo "<button onclick='confirmRegistration(" . $tournament['id'] . ")'>Participer</button>";
    }
} else {
    // Utilisateur non connecté : Redirection vers la page de connexion
    echo "<a href='connexion.php'><button>Se connecter pour participer</button></a>";
}
} else {
echo "<p>Tournoi non trouvé.</p>";
}
} else {
echo "<p>ID invalide.</p>";
}
?>

<script>
// Fonction de confirmation d'inscription
function confirmRegistration(tournamentId) {
if (confirm("Voulez-vous vraiment vous inscrire à ce tournoi ?")) {
    window.location.href = "actionForm/play.php?id=" + tournamentId;
}
}

// Fonction de confirmation de désinscription
function confirmUnregistration(tournamentId) {
if (confirm("Voulez-vous vraiment vous désinscrire de ce tournoi ?")) {
    window.location.href = "actionForm/desinscrire.php?id=" + tournamentId;
}
}
</script>
</body>
</html>