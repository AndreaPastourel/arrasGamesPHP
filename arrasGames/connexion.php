<?php 
 if (session_status() == PHP_SESSION_NONE) {
  session_start();};
require_once("headFoot/header.php")
?>

<body style="background-image: url('/arrasGames/img/arrasGames-bg-1.jpg');">
    
    <?php require_once("headFoot/nav.php")?>
    <div class="formulaire">
    <h2>Se connecter</h2>
    <form action="/arrasGames/actionForm/connexion.php" method='post' name='connexion' enctype="multipart/form-data">
        <table>
            <tr>
                <td>Username</td>
                <td><input type="text" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" required></td>
                <?php echo isset($erreurUser) ? "<span style='color:red;'>$erreurUser</span>" : ''; ?>
            </tr>
            <tr>
                <td>Password</td>
                <td>
                    <div class="password-container">
                    <input type="password" name="password" id="password" required>
                    <i class="far fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                    </div>
                </td>
                <?php echo isset($erreurPassword) ? "<span style='color:red;'>$erreurPassword</span>" : '';?>
                </tr>
            
            <tr>
              <td></td>
                <td><input type="submit" name="submit" value="Se connecter"></td>
            </tr>
            <tr>
                <td>Pas encore de compte?</td>
                <td> <a href="inscription.php">S'inscrire</a></td>
            </tr>
        </table>
    </form>
</div>
  </div>
</div>
</div>
    <?php require_once("headFoot/footer.php")?>
    <script>
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#password');

  togglePassword.addEventListener('click', function (e) {
    // basculer le type d'input entre password et text
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    
    // changer l'icône selon l'état
    this.classList.toggle('fa-eye-slash');
  });
</script>
</body>