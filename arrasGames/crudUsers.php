<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Le reste de ton code ici
?>
<?php 
    if (session_status() == PHP_SESSION_NONE) {
    session_start();}
    if(!isset($_SESSION['username']) || $_SESSION['role']!="admin"){
      header("Location: /arrasGames/unauthorized.php");
       exit();
    }
    ?>
<?php
//Include the database connection file
require_once('dbConnect.php');

//Requete pour recuperer les utilisateurs 
$stmt=$pdo->query("SELECT * FROM users ORDER BY id");
?>

<!DOCTYPE html>
<html>

<?php require_once ('headFoot/header.php')?>


<body background="img/arrasGames-bg-2.jpg">
    
      <!-- header section strats -->
      <?php require_once('headFoot/nav.php')?>
      <!-- end header section -->
   


    <div class="crud">
    <h1>CRUD utilisateurs</h1>
    <p><a href="crud/users/add.php">Ajouter des utilisateurs</a></p>

    <!-- Debut du tableau crud -->
    <table>
        <tr>
            <td>ID</td>
            <td>Username</td>
            <td>Password</td>
            <td>Email</td>
            <td>Role</td>
            <td>Action</td>
        </tr>
        <?php
        //boucles d'affichage
        while($res=$stmt->fetch(PDO::FETCH_ASSOC)){
            echo "<tr>";
                echo "<td>".$res['id']."</td>";
                echo "<td>".$res['username']."</td>";
                echo "<td>".str_repeat('*', strlen($res['password']))."</td>";
                echo "<td>".$res['email']."</td>";
                echo "<td>".$res['role']."</td>";
                echo "<td> <a href=\"crud/users/edit.php?id={$res['id']}\">Modifier</a> | 
                          <a href=\"crud/users/delete.php?id={$res['id']}\" onClick=\"return confirm('Etes vous sur de supprimer?')\">Supprimer</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
    <!--Fin du tableau crud-->
     
    </div>
 

  <!-- footer section -->
  <?php require_once('headFoot/footer.php'); ?>
  <!-- footer section -->

</body>



</html>