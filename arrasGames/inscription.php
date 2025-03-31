
<?php require_once ('headFoot/header.php')?>


<body background="img/arrasGames-bg-1.jpg">
      <?php require_once('headFoot/nav.php')?>
<div class="formulaire">
    <h2>S'inscrire</h2>
    <form action="actionForm/inscription.php" method='post' name='inscription' enctype="multipart/form-data">
        <table>
            <tr>
                <td>Username</td>
                <td><input type="text" name="username" required></td>
            </tr>
            
            <tr>
                <td>Password</td>
                <td>
                    <div class="password-container">
                    <input type="password" name="password" id="password" required>
                    <i class="far fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                    </div>
                </td>
            
                </tr>
            
            <tr>
                <td>Email</td>
                <td><input type="email" name="email" required></td>
            </tr>
            
            <tr>
                <td><input type="submit" name="submit" value="S'inscrire"></td>
            </tr>
        </table>
    </form>
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
</html>
