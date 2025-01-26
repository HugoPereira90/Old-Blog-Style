<!-- Deconnexion au site -->
<?php
include("./BoutPage/DataBaseFonction.php");

if (isset($_COOKIE["name"]) && isset($_COOKIE["password"])){
    DestroyLoginCookie();
}

$redirect = "Location:".GetURL()."/index.php";
header($redirect);

?>