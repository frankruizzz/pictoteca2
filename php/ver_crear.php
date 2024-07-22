<?php
/* INDEX PHP PARA INDEX HTML */
    session_start();
    include('conexion.php');

$response = array(
    "session" => ""
);

if (isset($_SESSION['username'])) {
    $username = htmlspecialchars($_SESSION['username']);
    $sessionHTML = "<a href='/public/nuevo.html'>
                    <img src='/public/img/nuevo.png' alt='Crear nueva'>
                    <span>Crear</span>
                </a>";
    $response['session'] = $sessionHTML;
} else {
    $response['session'] = '';
}

header('Content-Type: application/json');
echo json_encode($response);
?>