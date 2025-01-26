<!-- Page principale du site -->
<?php
include("./BoutPage/DataBaseFonction.php");
ConnectDatabase();
$loginStatus = CheckLogin();
include("./BoutPage/Toolbar.php");
?>

<script>

    //Pour utiliser fetch, la fonction doit être "asynchrone", fonctoin pour charger plus de post
    async function loadMorePosts(numberOfPostsAlready) {

        const element = document.getElementById('morePosts');
        if (element != null ) {element.remove();}

        var AJAXresult = await fetch("./BoutPage/MorePost.php?firstPost=" + numberOfPostsAlready);
        writearea = document.getElementById("ShowPosts");
        writearea.innerHTML = writearea.innerHTML + await AJAXresult.text();

    }

    window.onload = loadMorePosts(0);

</script>

<!-- Séparation de la page en 3 partie -->
<div id="MainContainer">
    <!-- 1ère partie Colonne gauche -->
    <div class="column side">
        <!-- Affiche le nom de l'utilisateur ou "Connectez vous" -->
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
                    echo "<h1>".$blogOwnerName."</h1>";
                    echo"<hr>";

                    //Formulaire d'ajout de Post
                    echo'       
                    <form action="editPost.php" method="POST">
                        <input type="hidden" name="newPost" value="1">
                        <button type="submit">Ajouter un nouveau post!</button>
                    </form>';
                }
                else {
                    echo "<h1>Erreur! Cette ID ne correspond à aucun utilisateur actif!</h1>";
                }
            } else {
                echo"<hr>";
                echo "<h1>Connectez-vous</h1>";
                echo"<hr>";
            }
        ?>
    </div>

    <!-- Colonne du milieu avec les posts -->
    <div id="ShowPosts" class="column middle">


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
DisconnectDatabase();
include("./BoutPage/Footer.php");
?>