<?php
    session_start();
    include('conexion.php');

$response = array(
    "gallery" => "",
    "session" => ""
);

if (isset($_SESSION['username'])){
    $user=$_SESSION['username'];
}
$sql = "SELECT * FROM imagen WHERE fk_id_usuario=(SELECT id_usuario FROM usuario WHERE username = '$user') ORDER BY fecha DESC";
$rp = mysqli_query($con, $sql);
$galleryHTML = "";
while ($row = mysqli_fetch_assoc($rp)) {
    $direccion = htmlspecialchars(rawurlencode($row['direccion']));
    $id_imagen = htmlspecialchars($row['id_imagen']);
    $galleryHTML .= "<img src='$direccion' alt='Imagen' id='$id_imagen' onclick='irADetalle($id_imagen)'>";
}
$response['gallery'] = $galleryHTML;

if (isset($_SESSION['username'])) {
    $username = htmlspecialchars($_SESSION['username']);
    $sessionHTML = "<div class='header-img'><p id='$username'>Bienvenido,<br><a href='user.html' style='color: #00e861; font-weight: bold; font-size: large;'>$username</a></p>";
    $sessionHTML .= "<a href='/php/logout.php'>Cerrar sesión</a></div>";
    $response['session'] = $sessionHTML;
} else {
    $linksHTML = "<div class='header-img'><a href='signin.html'><img src='img/log.png' alt='Signin'><span>Registrarse</span></a>";
    $linksHTML .= "<a href='login.html'><span>Iniciar sesión</span></a></div>";
    $response['session'] = $linksHTML;
}

header('Content-Type: application/json');
echo json_encode($response);
?>