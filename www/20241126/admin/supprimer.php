<?php
$racine="/home/ralevazaha/Documents/projetHttp/www/";
include($racine . "20241126/inc/fonction.php");
$id=$_GET["id"];
deleteProduit($id);
header("Location:gestion.php?");
?>