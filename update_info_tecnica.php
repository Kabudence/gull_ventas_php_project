<?php

require_once('init.php');

$errors = [];
$success = false;
//$product = [];

if (!empty($_POST)) {

    $info = [];    
    $rutina_imagen = $_FILES["rutina_image"]["name"];
    $dieta_imagen = $_FILES["dieta_image"]["name"];
    
    $info['id'] = $_POST['info_id'];
    $info['fecha_inicio_rutina'] = $_POST['fecha_inicio_rutina'];
    $info['fecha_fin_rutina'] = $_POST['fecha_fin_rutina'];
    $info['frecuencia_rutina'] = $_POST['frecuencia_rutina'];
    $info['image_rutina'] = $_POST['rutina_img_name'];
    $info['image_dieta'] = $_POST['dieta_img_name'];
    $info['status'] = $_POST['statu'];

    foreach ($info as $key => $value) {
        if (empty($value)) {
            if ($key == 'image_rutina')
                continue;
            $errors[] = is_empty($key, $value);
        }
    }

    if (empty($errors)) {

        if (!empty($rutina_imagen)) {
                $file_name_no_ext = md5(uniqid(rand(), true));
                $uploaded_msg = upload_img($file_name_no_ext, dir_info_tecnica_clientes_rutina(), cliente_rutina_post_name());
                delete_image($info['image_rutina'], dir_info_tecnica_clientes_rutina());
                $info['image_rutina'] = $uploaded_msg[0];
            }

            if (!empty($dieta_imagen)) {
                $file_name_no_ext_two = md5(uniqid(rand(), true));
                $uploaded_msg_two = upload_img($file_name_no_ext_two, dir_info_tecnica_clientes_dieta(), cliente_dieta_post_name());
                delete_image($info['image_dieta'], dir_info_tecnica_clientes_dieta());
                $info['image_dieta'] = $uploaded_msg_two[0];
            }

        if (update_info_tecnica_clientes($info)) {
            $success = true;
            $_SESSION['cliente_msg'] = "Registro actualizado con éxito.";
        }
    }

    $_SESSION['errors'] = $errors;

    if ($success) {
        $redirect_to = root_dir() . 'info_cliente.php';
        header('Location: ' . $redirect_to);
    } else {
        $redirect_to = root_dir() . 'edit_info_cliente.php?info_id=' . $info['id'] . '&&errormsg=true';
        header('Location: ' . $redirect_to);
    }
}
?>