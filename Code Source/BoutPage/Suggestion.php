<?php
    include("./DataBaseFonction.php");
    ConnectDatabase();
    $protectedText = SecurizeString_ForSQL($_GET["var"]);

    echo 'Suggestions : <i>';

    // Si le texte entré dans la barre de recherche n'est pas vide, propose un nom ou pas si l'utilisateur existe
    if ($protectedText != "") {
        $query = "SELECT logname, ID FROM `login` WHERE LOWER(logname) LIKE LOWER('$protectedText%')";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $i = 1;
            while( $row = $result->fetch_assoc() ){
                echo '<a href="./Profil.php?userID='.ucwords($row["ID"]).'">'.ucwords($row["logname"]).'</a>';
                if ($i < $result->num_rows) {
                    echo " - ";
                }
                $i++;
            }
        }
        else {
            echo '(pas de suggestion pour le texte actuel)';
        }
    }
    else{
        echo '(tapez quelque chose pour en avoir!)';
    }

    echo '</i>';
?>