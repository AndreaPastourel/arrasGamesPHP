<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username']) || ($_SESSION['role'] != "admin" && $_SESSION['role'] != "staff")) {
    header("Location: /arrasGames/unauthorized.php");
    exit();
}
?>

<?php
// Inclure le fichier de connexion à la base de données
require_once('dbConnect.php');

// Requête pour récupérer les tournois avec le nombre de participants
$stmt = $pdo->query("
    SELECT tournaments.*, games.name AS gameName, 
    (SELECT COUNT(*) FROM play WHERE play.idTournaments = tournaments.id) AS participantCount
    FROM tournaments 
    JOIN games ON tournaments.idGames = games.id
    ORDER BY tournaments.id
");
?>

<!DOCTYPE html>
<html>

<?php require_once('headFoot/header.php'); ?>

<body background="img/arrasGames-bg-2.jpg">
    
    <!-- header section starts -->
    <?php require_once('headFoot/nav.php'); ?>
    <!-- end header section -->

    <div class="crud">
        <h1>CRUD Tournois</h1>
        <p><a href="crud/tournament/add.php">Ajouter un tournoi</a></p>
<!-- Début du tableau CRUD -->
<table>
    <tr>
        <td>ID</td>
        <td>Nom</td>
        <td>Jeu</td>
        <td>Date de début</td>
        <td>Date de fin</td>
        <td>Image</td>
        <td>Afficher</td>
        <td>Participants</td>  <!-- Nouvelle colonne pour le nombre de participants -->
        <td>Action</td>
    </tr>
    <?php
    // Boucle d'affichage des tournois
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
            echo "<td>" . $res['id'] . "</td>";
            echo "<td>" . $res['name'] . "</td>";
            echo "<td>" . $res['gameName'] . "</td>";  // Affichage du nom du jeu
            echo "<td>" . $res['startDate'] . "</td>";
            echo "<td>" . $res['endDate'] . "</td>";
            echo "<td><img src='uploads/" . $res['image'] . "' alt='Image tournoi' style='width:50px;height:50px;'></td>";
            echo "<td>" . ($res['afficher'] == 1 ? 'Oui' : 'Non') . "</td>";
            echo "<td>" . $res['participantCount'] . "</td>";  // Affichage du nombre de participants
            echo "<td> 
                  <a href=\"crud/tournament/edit.php?id={$res['id']}\">Modifier</a> | 
                  <a href=\"crud/tournament/delete.php?id={$res['id']}\" onClick=\"return confirm('Etes-vous sûr de vouloir supprimer?')\">Supprimer</a>
                  </td>";
        echo "</tr>";
    }
    ?>
</table>
<!-- Fin du tableau CRUD -->
    </div>

    <!-- footer section -->
    <?php require_once('headFoot/footer.php'); ?>
    <!-- footer section -->

</body>

</html>