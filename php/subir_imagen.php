<?php
include('conexion.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['username'])) {
        $username = mysqli_real_escape_string($con, $_SESSION['username']);

        $sql_usuario = "SELECT id_usuario FROM usuario WHERE username='$username'";
        $result_usuario = mysqli_query($con, $sql_usuario);
        if ($row_usuario = mysqli_fetch_assoc($result_usuario)) {
            $id_usuario = $row_usuario['id_usuario'];

            $nombre = mysqli_real_escape_string($con, $_POST['nombre']);
            $descripcion = mysqli_real_escape_string($con, $_POST['descripcion']);

            $etiqueta1 = isset($_POST['etiqueta1']) ? mysqli_real_escape_string($con, $_POST['etiqueta1']) : '';
            $etiqueta2 = isset($_POST['etiqueta2']) ? mysqli_real_escape_string($con, $_POST['etiqueta2']) : '';
            $etiqueta3 = isset($_POST['etiqueta3']) ? mysqli_real_escape_string($con, $_POST['etiqueta3']) : '';

            $target_dir = "../public/pictures/";
            $target_file = $target_dir . basename($_FILES["archivo"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $check = getimagesize($_FILES["archivo"]["tmp_name"]);

            if ($check !== false) {
                if ($_FILES["archivo"]["size"] <= 5000000) {
                    if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "jfif") {
                        if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $target_file)) {
                            $sql = "INSERT INTO imagen (nombre, descripcion, direccion, fecha, fk_id_usuario) VALUES ('$nombre', '$descripcion', '$target_file', CURRENT_TIMESTAMP(), $id_usuario)";
                            if (mysqli_query($con, $sql)) {
                                $id_imagen = mysqli_insert_id($con);

                                if (!empty($etiqueta1)) {
                                    $sql1 = "INSERT INTO etiquetas (nombre_etiqueta, valido, fk_id_imagen) VALUES ('$etiqueta1', 1, '$id_imagen')";
                                    mysqli_query($con, $sql1);
                                }
                                if (!empty($etiqueta2)) {
                                    $sql2 = "INSERT INTO etiquetas (nombre_etiqueta, valido, fk_id_imagen) VALUES ('$etiqueta2', 1, '$id_imagen')";
                                    mysqli_query($con, $sql2);
                                }
                                if (!empty($etiqueta3)) {
                                    $sql3 = "INSERT INTO etiquetas (nombre_etiqueta, valido, fk_id_imagen) VALUES ('$etiqueta3', 1, '$id_imagen')";
                                    mysqli_query($con, $sql3);
                                }

                                header('location: /public/exito_imagen.html');
                            } else {
                                echo "Error al guardar la información en la base de datos: " . mysqli_error($con);
                            }
                        } else {
                            echo "Error al subir el archivo.";
                        }
                    } else {
                        header('location: /public/error_imagen_jpg.html');
                    }
                } else {
                    header('location: /public/error_imagen_size.html');
                }
            } else {
                header('location: /public/error_imagen_jpg.html');
            }
        } else {
            header('location: /public/index.html');
        }
    } else {
        header('location: login.php');
    }
} else {
    echo "Método de solicitud no permitido.";
}
?>
