<?php
/* INDEX PHP PARA INDEX HTML */
    session_start();
    include('conexion.php');

$response = array(
    "gallery" => "",
    "session" => ""
);

$sql = "SELECT * FROM imagen ORDER BY fecha DESC";
$rp = mysqli_query($con, $sql);
$galleryHTML = "";
while ($row = mysqli_fetch_assoc($rp)) {
    $direccion = htmlspecialchars(rawurlencode($row['direccion']));
    $id_imagen = htmlspecialchars($row['id_imagen']);
    $galleryHTML .= "<img src='public/$direccion' alt='Imagen' id='$id_imagen' onclick='irADetalle($id_imagen)'>";
}
$response['gallery'] = $galleryHTML;

if (isset($_SESSION['username'])) {
    $username = htmlspecialchars($_SESSION['username']);
    $sessionHTML = "<div class='header-img'><p id='$username'>Bienvenido,<br><a href='public/user.html' style='color: #00e861; font-weight: bold; font-size: large;'>$username</a></p>";
    $sessionHTML .= "<a href='php/logout.php'>Cerrar sesión</a></div>";
    $response['session'] = $sessionHTML;
} else {
    $linksHTML = "<div class='header-img'><a href='public/signin.html'><img src='public/img/log.png' alt='Signin'><span>Registrarse</span></a>";
    $linksHTML .= "<a href='public/login.html'><span>Iniciar sesión</span></a></div>";
    $response['session'] = $linksHTML;
}

header('Content-Type: application/json');
echo json_encode($response);
?>