<!-- Page Profil de l'utilisateur -->
<?php
    include("./BoutPage/DataBaseFonction.php");
    ConnectDatabase();
    $loginStatus = CheckLogin();
    include("./BoutPage/Toolbar.php");
?>
<!-- Séparation de la page en 3 partie -->
<div id="MainContainer">
    <!-- 1ère partie Colonne gauche -->
    <div class="column side">
        <!-- Affiche le nom de l'utilisateur ou le nom du Profil que l'on regarde -->
        <?php
            if ( isset($_GET["userID"]) ){
        
                if ( isset($userID) && $userID == $_GET["userID"] ){
                    $isMyOwnBlog = true;
                    $blogOwnerName = $username;
                }
                else {
                    $query = 'SELECT `logname` FROM `login` WHERE `ID` ='.$_GET["userID"];
                    $result = $conn->query($query);
                    
                    if ( mysqli_num_rows($result) != 0 ){ $blogOwnerName = $result->fetch_assoc()["logname"];}
                }
                
                if ($blogOwnerName != ""){
                    echo"<hr>";
                    echo "<h1> Profil de : </h1>";
                    echo "<h1>".$blogOwnerName."</h1>";
                    echo"<hr>";
                }
                else {
                    echo "<h1>Erreur! Cette ID ne correspond à aucun utilisateur actif!</h1>";
                }
            }   
        ?>
    </div>

    <!-- Colonne du milieu avec les posts du profil (utilisateur connecté ou un autre compte) -->
    <div class="column middle">
        <?php
            if ( isset($_GET["userID"]) ){

                $isMyOwnBlog = false;

                if ( isset($userID) && $userID == $_GET["userID"] ){
                    $isMyOwnBlog = true;
                    $blogOwnerName = $username;
                }
                else {
                    $query = 'SELECT `logname` FROM `login` WHERE `ID` ='.$_GET["userID"];
                    $result = $conn->query($query);
                    
                    if ( mysqli_num_rows($result) != 0 ){ $blogOwnerName = $result->fetch_assoc()["logname"];}
                }
                
                if ($blogOwnerName != ""){
                    DisplayPostsPage( $_GET["userID"] , $blogOwnerName, $isMyOwnBlog);
                }
                else {
                    echo "<h1>Erreur! Cette ID ne correspond à aucun utilisateur actif!</h1>";
                }
            }   
        ?>
    </div>

    <!-- Colonne de droite avec la recherche de profil -->
    <div class="column side">
        <hr>
        <h1>Recherche</h1>
        <hr>
        <?php
            include("./BoutPage/Search.php");
        ?>
  </div>
</div>

<?php
    include("./BoutPage/Footer.php");
?>