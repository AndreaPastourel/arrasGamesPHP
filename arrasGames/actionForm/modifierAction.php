<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html>
<head>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/headFoot/header.php')?>
</head>

<body background="../img/arrasGames-bg-2.jpg">
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/headFoot/nav.php') ?>

    <div class="formulaire">

   <?php 
   require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/dbConnect.php');
   if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $username = $_POST['username'];
        $email= $_POST['email'];


        try {
            $stmt = $pdo->prepare("UPDATE users SET username=?,email=? WHERE id=?");
            $stmt->execute([$username,$email, $id]);
            echo "<h2>L'utilisateur $username a bien été mis à jour!</h2>";
        } catch (PDOException $e) {
            echo "ERREUR : " . $e->getMessage();
            require_once('modifierInfos.php');
        }
    }
   ?>
   <p><a href="/arrasGames/compte.php">Retour sur le compte</a></p>
  </div>
</div>

<!-- footer section -->
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/headFoot/footer.php'); ?>
<!-- footer section -->

</body>
</html>