<?php
include('conexion.php');
session_start();

$imageId = isset($_GET['imageId']) ? (int)$_GET['imageId'] : 0;
$response = [
'success' => false,
'message' => '',
'image' => null,
'direccion' => '',
'etiquetas' => []
];

if ($imageId > 0 && $con) {
    $sql = "SELECT descripcion, direccion FROM imagen WHERE id_imagen = $imageId";
    $result = mysqli_query($con, $sql);
    
    if ($result && $row = mysqli_fetch_assoc($result)) {
        $response['image'] = $row['descripcion'];
        $response['direccion'] = $row['direccion'];
        
        $sql = "SELECT nombre_etiqueta FROM etiquetas WHERE fk_id_imagen = $imageId AND valido = 1";
        $result = mysqli_query($con, $sql);
        
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $response['etiquetas'][] = $row['nombre_etiqueta'];
            }
            $response['success'] = true;
        } else {
            $response['message'] = 'Error obteniendo las etiquetas: ' . mysqli_error($con);
        }
        
    } else {
        $response['message'] = 'No se encontró la imagen o error en la consulta: ' . mysqli_error($con);
    }
    mysqli_free_result($result);
} else {
    $response['message'] = 'ID de imagen no válido o error de conexión a la base de datos.';
}

mysqli_close($con);

header('Content-Type: application/json');
echo json_encode($response);
?>
