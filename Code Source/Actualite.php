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

        <?php

        if (isset($_GET["jeu"])){
            
            if($_GET["jeu"] != ""){?>

                var AJAXresult = await fetch("./BoutPage/MoreActualite.php?firstPost="+numberOfPostsAlready+"&jeu=<?php echo $_GET["jeu"] ;?>");
            <?php
            } else {?>
               var AJAXresult = await fetch("./BoutPage/MoreActualite.php?firstPost=" + numberOfPostsAlready);
            <?php
            }

        } else {?>
            var AJAXresult = await fetch("./BoutPage/MoreActualite.php?firstPost=" + numberOfPostsAlready);
        
        <?php
        }

        ?>

        writearea = document.getElementById("ShowPosts");
        writearea.innerHTML = writearea.innerHTML + await AJAXresult.text();

    }

    window.onload = loadMorePosts(0);

</script>

<!-- Colonne du milieu avec les posts -->
<div id="ShowPosts">

</div>

<?php
DisconnectDatabase();
include("./BoutPage/Footer.php");
?>