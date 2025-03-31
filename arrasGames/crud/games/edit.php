<?php 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']) || $_SESSION['role'] != "admin") {
    header("Location: /arrasGames/unauthorized.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/headFoot/header.php'); 
?>
<body background="/arrasGames/img/arrasGames-bg-2.jpg">
<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/headFoot/nav.php'); 
?>

<div class="formulaire">
    <?php
    // Vérification de l'ID du jeu
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "Erreur : ID du jeu non spécifié.";
        exit();
    }

    $id = $_GET['id'];
    require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/dbConnect.php');

    try {
        // Requête pour récupérer les informations du jeu
        $stmt = $pdo->prepare("SELECT * FROM games WHERE id=?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $name = $result['name'];
            $releaseDate = $result['releaseDate'];
            $editor = $result['editor'];
            $genre = $result['genre'];
        } else {
            echo "Aucun jeu trouvé avec cet ID.";
            exit();
        }
    } catch (PDOException $e) {
        echo "ERREUR : " . $e->getMessage();
    }
    ?>

<h2>Modifier les informations du jeu</h2>
<p><a href="/arrasGames/crudGame.php">Retour en arrière</a></p>

<!-- Début Formulaire -->
<form action="action/edit.php" method="post">
    <table>
        <tr>
            <td>Nom du jeu</td>
            <td><input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required></td>
        </tr>
        <tr>
            <td>Date de sortie</td>
            <td><input type="date" name="releaseDate" value="<?php echo htmlspecialchars($releaseDate); ?>" required></td>
        </tr>
        <tr>
            <td>Éditeur</td>
            <td><input type="text" name="editor" value="<?php echo htmlspecialchars($editor); ?>" required></td>
        </tr>
        <tr>
            <td>Genre</td>
            <td><input type="text" name="genre" value="<?php echo htmlspecialchars($genre); ?>" required></td>
        </tr>
        <tr>
            <td><input type="hidden" name="id" value="<?php echo $id; ?>"></td>
            <td><input type="submit" name="update" value="Modifier"></td>
        </tr>
    </table>
</form>
</div>

<!-- footer section -->
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/headFoot/footer.php'); ?>
<!-- footer section -->

</body>
</html>