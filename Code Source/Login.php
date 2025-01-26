<!-- Page de connexion au site -->
<?php
include("./BoutPage/DataBaseFonction.php");
ConnectDatabase();
$loginStatus = CheckLogin();
include("./BoutPage/Toolbar.php");

if ( $loginStatus[0] ) { 
    header('Location: ./index.php?userID='.$loginStatus[3]);
    exit();
}
?>


<div class="centred">

    <?php
        if($loginStatus[0]){
            echo '<h3 class="successMessage">Connexions est un succès!</h3>';
        }
        elseif ($loginStatus[2]){
            echo '<h3 class="errorMessage">'.$loginStatus[2].'</h3>';
        }
    ?>

    <hr>
        <?php include("./BoutPage/LoginForm.php");?>
    <hr>
    
</div>



<?php
DisconnectDatabase();
include("./BoutPage/Footer.php");
?>