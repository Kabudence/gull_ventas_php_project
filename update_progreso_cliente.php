<?php

require_once('init.php');

$errors = [];
$success = false;
//$product = [];

if (!empty($_POST)) {

    $info = [];
    $progreso_imagen = $_FILES["progreso_image"]["name"];
    $progreso_fisico_imagen = $_FILES["progreso_fisico_image"]["name"];
    
    $info['id'] = $_POST['progreso_id'];
    $info['progreso_image'] = $_POST['progreso_img_name'];
    $info['progreso_fisico_image'] = $_POST['progreso_fisico_img_name'];
    $info['asunto'] = $_POST['asunto'];
    $info['detalle'] = $_POST['detalle']; 
    $info['status'] = $_POST['statu'];

    foreach ($info as $key => $value) {
        if (empty($value)) {
            if ($key == 'progreso_image')
                continue;
            $errors[] = is_empty($key, $value);
        }
    }

    if (empty($errors)) {

        if (!empty($progreso_imagen)) {
                $file_name_no_ext = md5(uniqid(rand(), true));
                $uploaded_msg = upload_img($file_name_no_ext, dir_info_progreso_clientes(), cliente_progreso_post_name());
                delete_image($info['progreso_image'], dir_info_progreso_clientes());
                $info['progreso_image'] = $uploaded_msg[0];
            }

            if (!empty($progreso_fisico_imagen)) {
                $file_name_no_ext_two = md5(uniqid(rand(), true));
                $uploaded_msg_two = upload_img($file_name_no_ext_two, dir_info_progreso_clientes(), cliente_progreso_fisico_post_name());
                delete_image($info['progreso_fisico_image'], dir_info_progreso_clientes());
                $info['progreso_fisico_image'] = $uploaded_msg_two[0];
            }

        if (update_progreso_fisico_clientes($info)) {
            $success = true;
            $_SESSION['cliente_msg'] = "Registro actualizado con éxito.";
        }
    }

    $_SESSION['errors'] = $errors;

    if ($success) {
        $redirect_to = root_dir() . 'progreso_cliente.php';
        header('Location: ' . $redirect_to);
    } else {
        $redirect_to = root_dir() . 'edit_progreso_cliente.php?progreso_id=' . $info['id'] . '&&errormsg=true';
        header('Location: ' . $redirect_to);
    }
}
?>