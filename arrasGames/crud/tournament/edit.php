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
    // Vérification de l'ID du tournoi
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "Erreur : ID du tournoi non spécifié.";
        exit();
    }

    $id = $_GET['id'];
    require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/dbConnect.php');

    try {
        // Requête pour récupérer les informations du tournoi
        $stmt = $pdo->prepare("SELECT * FROM tournaments WHERE id=?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $name = $result['name'];
            $idGames = $result['idGames'];
            $startDate = $result['startDate'];
            $endDate = $result['endDate'];
            $image = $result['image'];
            $afficher = $result['afficher'];
        } else {
            echo "Aucun tournoi trouvé avec cet ID.";
            exit();
        }
    } catch (PDOException $e) {
        echo "ERREUR : " . $e->getMessage();
    }

    // Récupérer la liste des jeux depuis la table `games`
    try {
        $stmtGames = $pdo->query("SELECT id, name FROM games");
        $games = $stmtGames->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des jeux : " . $e->getMessage();
    }
    ?>

<h2>Modifier les informations du tournoi</h2>
<p><a href="/arrasGames/crudGame.php">Retour en arrière</a></p>

<!-- Début Formulaire -->
<form action="action/edit.php" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td>Nom du tournoi</td>
            <td><input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required></td>
        </tr>
        <tr>
            <td>Jeu</td>
            <td>
                <select name="idGames" required>
                    <option value="">-- Sélectionnez un jeu --</option>
                    <?php foreach ($games as $game): ?>
                        <option value="<?php echo $game['id']; ?>" <?php echo ($game['id'] == $idGames) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($game['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Date de début</td>
            <td><input type="datetime-local" name="startDate" value="<?php echo date('Y-m-d\TH:i', strtotime($startDate)); ?>" required></td>
        </tr>
        <tr>
            <td>Date de fin</td>
            <td><input type="datetime-local" name="endDate" value="<?php echo date('Y-m-d\TH:i', strtotime($endDate)); ?>" required></td>
        </tr>
        <tr>
            <td>Image actuelle</td>
            <td><img src="/arrasGames/uploads/<?php echo $image; ?>" alt="Image tournoi" style="width:100px;height:100px;"></td>
        </tr>
        <tr>
            <td>Nouvelle image (facultatif)</td>
            <td><input type="file" name="image"></td>
        </tr>
        <tr>
            <td>Afficher</td>
            <td>
                <select name="afficher" required>
                    <option value="1" <?php echo ($afficher == 1) ? 'selected' : ''; ?>>Oui</option>
                    <option value="0" <?php echo ($afficher == 0) ? 'selected' : ''; ?>>Non</option>
                </select>
            </td>
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