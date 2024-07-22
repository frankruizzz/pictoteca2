<?php
include('conexion.php');

    $id_imagen = intval($_GET['id_imagen']);
    
    $sql = "SELECT i.direccion, i.descripcion, u.username,
            (SELECT nombre_etiqueta FROM etiquetas WHERE fk_id_imagen = i.id_imagen AND valido=1 LIMIT 1) AS etiqueta1, 
            (SELECT nombre_etiqueta FROM etiquetas WHERE fk_id_imagen = i.id_imagen AND valido=1 LIMIT 1 OFFSET 1) AS etiqueta2,
            (SELECT nombre_etiqueta FROM etiquetas WHERE fk_id_imagen = i.id_imagen AND valido=1 LIMIT 1 OFFSET 2) AS etiqueta3
            FROM imagen i
            LEFT JOIN usuario u ON i.fk_id_usuario = u.id_usuario
            LEFT JOIN etiquetas e ON i.id_imagen = e.fk_id_imagen
            WHERE i.id_imagen = $id_imagen LIMIT 1";

    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'No se encontraron datos para la imagen especificada.']);
    }

?>
