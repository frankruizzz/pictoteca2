<?php
    $host="localhost";
    $password="";
    $user="root";
    $db="pictoteca";
    try{
        $con=mysqli_connect($host,$user,$password,$db);
    }
    catch(Exception $e){
        echo "Error al intentar conectar a base de datos. <br>"+$e;
        exit;
    }
?>