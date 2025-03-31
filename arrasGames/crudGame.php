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

// Requête pour récupérer les jeux
$stmt = $pdo->query("SELECT * FROM games ORDER BY id");
?>

<!DOCTYPE html>
<html>

<?php require_once('headFoot/header.php'); ?>

<body background="img/arrasGames-bg-2.jpg">
    
    <!-- header section starts -->
    <?php require_once('headFoot/nav.php'); ?>
    <!-- end header section -->

    <div class="crud">
        <h1>CRUD Jeux</h1>
        <p><a href="crud/games/add.php">Ajouter un jeu</a></p>

        <!-- Début du tableau CRUD -->
        <table>
            <tr>
                <td>ID</td>
                <td>Nom</td>
                <td>Date de sortie</td>
                <td>Éditeur</td>
                <td>Genre</td>
                <td>Action</td>
            </tr>
            <?php
            // Boucle d'affichage des jeux
            while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                    echo "<td>" . $res['id'] . "</td>";
                    echo "<td>" . $res['name'] . "</td>";
                    echo "<td>" . $res['releaseDate'] . "</td>";
                    echo "<td>" . $res['editor'] . "</td>";
                    echo "<td>" . $res['genre'] . "</td>";
                    echo "<td> 
                          <a href=\"crud/games/edit.php?id={$res['id']}\">Modifier</a> | 
                          <a href=\"crud/games/delete.php?id={$res['id']}\" onClick=\"return confirm('Etes-vous sûr de vouloir supprimer?')\">Supprimer</a>
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