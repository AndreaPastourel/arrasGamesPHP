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

    <h2>Ajouter un tournoi</h2>
    <p><a href="/arrasGames/crudTournament.php">Retour en arrière</a></p>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/dbConnect.php');

    // Récupérer les jeux depuis la base de données
    try {
        $stmt = $pdo->query("SELECT id, name FROM games");
        $games = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
    ?>

    <form action="/arrasGames/crud/tournament/action/add.php" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Nom du tournoi</td>
                <td><input type="text" name="name" required></td>
            </tr>

            <tr>
                <td>Jeu</td>
                <td>
                    <select name="idGames" required>
                        <option value="">-- Sélectionnez un jeu --</option>
                        <?php foreach ($games as $game): ?>
                            <option value="<?php echo $game['id']; ?>">
                                <?php echo htmlspecialchars($game['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Date de début</td>
                <td><input type="datetime-local" name="startDate" required></td>
            </tr>

            <tr>
                <td>Date de fin</td>
                <td><input type="datetime-local" name="endDate" required></td>
            </tr>

            <tr>
                <td>Image</td>
                <td><input type="file" name="image" accept="image/*"></td>
            </tr>

            <tr>
                <td>Afficher</td>
                <td>
                    <select name="afficher" required>
                        <option value="1">Oui</option>
                        <option value="0">Non</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td><input type="submit" name="submit" value="Ajouter"></td>
            </tr>
        </table>
    </form>

</div>


</body>
</html>
