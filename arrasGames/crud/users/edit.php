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
    // Vérification de l'ID
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "Erreur : ID non spécifié.";
        exit();
    }

    $id = $_GET['id'];
    require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/dbConnect.php');

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $username = $result['username'];
            $password = $result['password'];  // hashed password
            $email = $result['email'];
            $role = $result['role'];
        } else {
            echo "Aucun utilisateur trouvé avec cet ID.";
            exit();
        }
    } catch (PDOException $e) {
        echo "ERREUR : " . $e->getMessage();
    }
    ?>

<h2>Modifier les informations</h2>
<p><a href="/arrasGames/crudUsers.php">Retour en arrière</a></p>

<!-- Début Formulaire -->
<form action="action/edit.php" method="post" name="add" enctype="multipart/form-data">
    <table>
        <tr>
            <td>Username</td>
            <td><input type="text" name="username" value="<?php echo $username; ?>"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td>
                <div class="password-container">
                    <input type="password" name="password" id="password" >
                    <i class="far fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                </div>
            </td>
            <?php echo isset($erreurPassword) ? "<span style='color:red;'>$erreurPassword</span>" : ''; ?>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="email" name="email" value="<?php echo $email; ?>"></td>
        </tr>
        <tr>
            <td>Role</td>
            <td>
                <select name="role" id="role">
                    <option value="<?php echo $role; ?>"><?php echo $role; ?></option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                    <option value="staff">Staff</option>
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

<script>
const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');

togglePassword.addEventListener('click', function(e) {
    // basculer le type d'input entre password et text
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);

    // changer l'icône selon l'état
    this.classList.toggle('fa-eye-slash');
});
</script>

</body>
</html>
