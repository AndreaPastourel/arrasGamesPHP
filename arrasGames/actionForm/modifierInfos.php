<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>
<html>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/headFoot/header.php');?>
    <body background="../img/arrasGames-bg-2.jpg">

        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/headFoot/nav.php'); ?>
        </br></br></br></br>
        <?php  
    require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/dbConnect.php');
    $id=$_SESSION['id'];
    try{
        $stmt=$pdo->prepare("SELECT * FROM users WHERE id=?");
        $stmt->execute([$id]);
        $result=$stmt->fetch(PDO::FETCH_ASSOC);

        $username=$result['username'];
        $email=$result['email'];
    } catch (PDOException $e){
        echo "ERREUR : ".$e->getMessage();
    };?>
    <div class="formulaire">
    
<h2>Modifier mes informations</h2>
    <p><a href="/arrasGames/compte.php">Retour en arrière</a></p>

    <!-- Debut Formulaire  -->
    <form action="modifierAction.php" method="post" name="add" enctype="multipart/form-data">
      <table>
        <tr>
          <td >Username</td>
          <td><input type="text" name="username" value="<?php echo $username; ?>"></td>
        </tr>


        <tr>
          <td >Email</td>
          <td><input type="email" name="email" value="<?php echo $email; ?>"></td>
        </tr>

        <tr>
          <td><input type="hidden" name="id" value="<?php echo $id; ?>"></td>
          <td><input type="submit" name="update" value="Modifier"></td>
        </tr>
      </table>
    </form>

  </div>
</div>


<!-- footer section -->
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/arrasGames/headFoot/footer.php'); ?>
<!-- footer section -->


</body>
</html>

