<?php

require_once('init.php');

$errors = [];
$success = false;
$dieta_detalle = [];

if (!empty($_POST)) {
    if (isset($_FILES["upload"]["name"]) && $_FILES['upload']['error'] === UPLOAD_ERR_OK) {
        $dieta_detalle['image_name'] = $_FILES["upload"]["name"];
        $file_name_no_ext = md5(uniqid(rand(), true));
        $uploaded_msg = upload_img($file_name_no_ext, dir_info_modulo_dieta(), dieta_post_name());
        $dieta_detalle['image_name'] = $uploaded_msg[0];
        $dieta_detalle['id'] = $_POST['dieta_detalle_id'];
        $dieta_detalle['user_id'] = $_POST['user_id'];
        $dieta_detalle['dia_dieta'] = $_POST['dia_dieta'];
        $dieta_detalle['tipo_comida'] = $_POST['tipo_comida'];
        $dieta_detalle['nombre_comida'] = $_POST['nombre_comida'];
        $dieta_detalle['hora'] = $_POST['hora'];
        $dieta_detalle['descripcion'] = $_POST['descripcion'];
        $dieta_detalle['recomendacion'] = $_POST['recomendacion'];

        if (update_dieta_detalle($dieta_detalle)) {
            $success = true;
            //$_SESSION['dieta_msg'] = "Dieta actualizado con éxito.";
            echo "Registro Actualizado";
        }else {
            echo "Error al actualizar los datos";
        }
    }else {
        $dieta_detalle['image_name'] = $_POST['imagen_name_val'];
        $dieta_detalle['id'] = $_POST['dieta_detalle_id'];
        $dieta_detalle['user_id'] = $_POST['user_id'];
        $dieta_detalle['dia_dieta'] = $_POST['dia_dieta'];
        $dieta_detalle['tipo_comida'] = $_POST['tipo_comida'];
        $dieta_detalle['nombre_comida'] = $_POST['nombre_comida'];
        $dieta_detalle['hora'] = $_POST['hora'];
        $dieta_detalle['descripcion'] = $_POST['descripcion'];
        $dieta_detalle['recomendacion'] = $_POST['recomendacion'];
        if (update_dieta_detalle($dieta_detalle)) {
            $success = true;
            //$_SESSION['dieta_msg'] = "Dieta actualizado con éxito.";
            echo "Registro Actualizado";
        }else {
            echo "Error al actualizar los datos";
        }
        
        //echo "Error al cargar la imagen";
    }
}
?>