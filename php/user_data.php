<?php
session_start();
include('conexion.php');

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $sql = "SELECT username, nombres FROM usuario WHERE username = '$username'";
    $res = mysqli_query($con, $sql);
    if ($row = $res->fetch_assoc()) {
        $userData = [
            'username' => htmlspecialchars($row['username']),
            'nombres' => htmlspecialchars($row['nombres'])
        ];
        echo json_encode($userData);
    } else {
        echo json_encode(['error' => 'Datos no encontrados.']);
    }

} else {
    echo json_encode(['error' => 'Usuario no autenticado.']);
}
?>
