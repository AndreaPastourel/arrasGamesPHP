<?php 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']) || $_SESSION['role'] != "admin") {
}
?>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/dbConnect.php');;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $releaseDate = $_POST['releaseDate'];
    $editor = $_POST['editor'];
    $genre = $_POST['genre'];

    try {
        // Préparer la requête de mise à jour
        $stmt = $pdo->prepare("UPDATE games SET name=?, releaseDate=?, editor=?, genre=? WHERE id=?");
        $stmt->execute([$name, $releaseDate, $editor, $genre, $id]);
        
        // Redirection après la mise à jour
        header("Location: /arrasGames/crudGame.php");
        exit();
    } catch (PDOException $e) {
        echo "ERREUR: " . $e->getMessage();
    }
}
?>

<!-- footer section -->
<?php require_once('../../../headFoot/footer.php'); ?>
<!-- footer section -->

</body>
</html>
