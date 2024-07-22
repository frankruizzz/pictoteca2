<?php
include('conexion.php');
session_start();

$imageId = $_GET['imageId'];
$response = ['comments' => []];

if ($con) {
    $sql = "SELECT c.contenido, u.username FROM comentario c INNER JOIN usuario u ON c.fk_id_usuario = u.id_usuario WHERE c.fk_id_imagen = $imageId";
    $result = mysqli_query($con, $sql);
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $response['comments'][] = [
                'comentario' => $row['contenido'],
                'username' => $row['username']
            ];
        }
        mysqli_free_result($result);
    } else {
        $response['error'] = 'Error en la consulta: ' . mysqli_error($con);
    }
} else {
    $response['error'] = 'Error de conexión a la base de datos.';
}

mysqli_close($con);

header('Content-Type: application/json');
echo json_encode($response);
?>