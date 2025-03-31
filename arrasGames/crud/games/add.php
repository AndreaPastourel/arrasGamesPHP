<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username']) || ($_SESSION['role'] != "admin" && $_SESSION['role'] != "staff")) {
    header("Location: /arrasGames/unauthorized.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/headFoot/header.php'); ?>

<body background="/arrasGames/img/arrasGames-bg-2.jpg">
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/headFoot/nav.php'); ?>
</br></br></br></br></br>
<div class="formulaire">

    <h2>Ajouter un jeu</h2>
    <p><a href="/arrasGames/crudGame.php">Retour en arrière</a></p>

    <form method="POST" action="/arrasGames/crud/games/action/add.php">
    <table>
        <tr>
            <td>Nom du jeu</td>
            <td><input type="text" name="name" required></td>
        </tr>
        <tr>
            <td>Date de sortie</td>
            <td><input type="date" name="releaseDate" required></td>
        </tr>
        <tr>
            <td>Éditeur</td>
            <td><input type="text" name="editor" required></td>
        </tr>
        <tr>
            <td>Genre</td>
            <td><input type="text" name="genre" required></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="Ajouter">
            </td>
        </tr>
    </table>
</form>
</div>

<!-- footer section -->
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/headFoot/footer.php'); ?>
<!-- footer section -->

</body>
</html>