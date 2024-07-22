<?php
    include('conexion.php');
    $name = $_POST['nombre'];
    $dir = $_POST['direccion'];
    $sql = "INSERT INTO imagen (nombre, direccion, fecha) VALUES ('$name', '$dir', CURRENT_TIMESTAMP())";
    if(mysqli_query($con, $sql)=== TRUE){
        header('location: ../index.php');
    }
    else{
        header('location: ../nuevo.html');        
    }
?>