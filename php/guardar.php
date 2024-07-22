<?php
include('conexion.php');

$username = $_POST['username'];
$name= $_POST['name'];
$password= $_POST['password'];
$rpassword = $_POST['rpassword'];

if ($password === $rpassword) {
    $sql = "SELECT username FROM usuario WHERE username = '$username'";
    $rs = mysqli_query($con, $sql);

    if (mysqli_num_rows($rs) > 0) {
        header("location: /public/signin.html?error=yaexiste");
        exit;
    } else {
        $p = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuario (username, nombres, contrasena) VALUES ('$username', '$name', '$p')";
        $res = mysqli_query($con, $sql);

        if (mysqli_affected_rows($con) > 0) {
            header("location: /public/login.html");
            exit;
        } else {
            header("location: /public/signin.html?error=noinserto");
            exit;
        }
    }
} else {
    header("location: /public/signin.html?error=contrasenas");
    exit;
}
?>