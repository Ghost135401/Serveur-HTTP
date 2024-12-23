<?php
$ut=$_POST["username"];
$pwd=$_POST["password"];
if($ut=="admin" && $pwd=="admin"){
    header("location:ajouter.php");
}else{
    header("location:login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    {{username}}
    {{password}}
</body>
</html>