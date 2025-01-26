<!-- Page de création d'un compte -->
<?php
include("./BoutPage/DataBaseFonction.php");
ConnectDatabase();
$newAccountStatus = CheckNewAccountForm();
include("./BoutPage/Toolbar.php");
?>

<body>


    <div class="centred">
        <h1>Création d'un nouveau compte</h1>
        <!-- Test si le compte a été créé avec succée -->
        <?php
            if($newAccountStatus["Success"]){
                echo '<h3 class="successMessage">Nouveau compte crée avec succès!</h3>';
            }
            elseif ($newAccountStatus["Attempted"]){
                echo '<h3 class="errorMessage">'.$newAccountStatus["MsgError"].'</h3>';
            }
        ?>

        <hr>
            <?php include("./BoutPage/newLoginForm.php");?>
        <hr>
        
    </div>

</body>