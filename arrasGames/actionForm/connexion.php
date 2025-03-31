<?php require_once("../headFoot/header.php") ?>
<body style="background-image: url('img/arrasGames-bg-1.jpg');">
<?php require_once("../headFoot/nav.php")?>
<?php
    require_once("../dbConnect.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"])) {
        $erreurUser = "<p>Le champ identifiant est vide</p>";
    } elseif (empty($_POST['password'])) {
        $erreurPassword = "<p>Le champ mot de passe est vide</p>";
    } else {
        $username = $_POST['username'];
        $password = $_POST["password"]; // Le mot de passe saisi par l'utilisateur

        try {
            // Préparation de la requête pour récupérer les informations de l'utilisateur
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
            $stmt->execute([$username]);

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $hashed_password = $row['password']; // Récupération du mot de passe haché

                // Vérification du mot de passe haché avec password_verify()
                if (password_verify($password, $hashed_password)) {
                    $id = $row['id'];
                    $role = $row['role'];

                    session_start();
                    $_SESSION['username'] = $username;
                    $_SESSION['id'] = $id;
                    $_SESSION['role'] = $role;

                    header("Location:../index.php");
                } else {
                    echo "<p style='color:red;'>Mot de passe ou nom d'utilisateur incorrect</p>";
                }
            } else {
                echo "<p style='color:red;'>Mot de passe ou nom d'utilisateur incorrect</p>";
            }

        } catch (PDOException $e) {
            echo "ERREUR : " . $e->getMessage();
        }
    }
}
require_once("../connexion.php");
?>



</body>

<?php require_once("headFoot/footer.php")?>