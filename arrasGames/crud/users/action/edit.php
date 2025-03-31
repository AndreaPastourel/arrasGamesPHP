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


   <?php 
   require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/dbConnect.php');
   if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        // Hachage du mot de passe seulement si le mot de passe a été changé
        if (password_needs_rehash($password, PASSWORD_DEFAULT)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $hashed_password = $password;
        }

        try {
            $stmt = $pdo->prepare("UPDATE users SET username=?, password=?, email=?, role=? WHERE id=?");
            $stmt->execute([$username, $hashed_password, $email, $role, $id]);
            echo "<h2>L'utilisateur $username a bien été mis à jour!</h2>";
            header("Location: /arrasGames/crudUsers.php");
        } catch (PDOException $e) {
            echo "ERREUR : " . $e->getMessage();
        }
    }
   ?>
   <p><a href="/arrasGames/crudUsers.php">Retour sur le Crud</a></p>
  </div>
</div>

<!-- footer section -->
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/headFoot/footer.php'); ?>
<!-- footer section -->

</body>
</html>