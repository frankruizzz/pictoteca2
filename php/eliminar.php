<?php
include('conexion.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$imageId = $data['imageId'] ?? null;

if (!$imageId) {
    echo json_encode(['success' => false, 'message' => 'ID de imagen no proporcionado']);
    exit;
}

$imageId = mysqli_real_escape_string($con, $imageId);

$sql = "DELETE FROM imagen WHERE id_imagen = '$imageId'";
if (mysqli_query($con, $sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error eliminando la imagen: ' . mysqli_error($con)]);
}

mysqli_close($con);
?>
