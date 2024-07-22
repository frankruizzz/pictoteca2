<?php
include('conexion.php');
session_start();

$data = json_decode(file_get_contents('php://input'), true);
$response = ['success' => false, 'message' => ''];

$imageId = isset($data['imageId']) ? (int)$data['imageId'] : 0;
$descripcion = isset($data['descripcion']) ? $data['descripcion'] : '';
$etiquetas = isset($data['etiquetas']) ? $data['etiquetas'] : [];

if ($imageId > 0 && $con) {
    $sql = "UPDATE imagen SET descripcion = '$descripcion' WHERE id_imagen = $imageId";
    if (mysqli_query($con, $sql)) {
        $response['success'] = true;
        
        // Delete existing etiquetas
        $sql = "DELETE FROM etiquetas WHERE fk_id_imagen = $imageId";
        if (!mysqli_query($con, $sql)) {
            $response['message'] = 'Error eliminando las etiquetas antiguas: ' . mysqli_error($con);
        }
        
        // Insert new etiquetas
        foreach ($etiquetas as $etiqueta) {
            if (!empty($etiqueta)) {
                $sql = "INSERT INTO etiquetas (nombre_etiqueta, valido, fk_id_imagen) VALUES ('$etiqueta', 1, $imageId)";
                if (!mysqli_query($con, $sql)) {
                    $response['message'] .= ' Error insertando etiqueta: ' . mysqli_error($con);
                    $response['success'] = false;
                }
            }
        }
        
    } else {
        $response['message'] = 'Error en la actualización: ' . mysqli_error($con);
    }
} else {
    $response['message'] = 'Datos no válidos o error de conexión a la base de datos.';
}

mysqli_close($con);

header('Content-Type: application/json');
echo json_encode($response);
?>
