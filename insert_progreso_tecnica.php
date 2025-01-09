<?php

require_once('init.php');

$errors = [];
$success = false;

if (!empty($_POST)) {

    $info = [];
    $info['cliente_id'] = $_POST['cliente_id'];
    $info['user_id'] = $_POST['cliente_id_admin'];
    $info['fecha'] = date('Y-m-d');
    $info['asunto'] = $_POST['asunto'];
    $info['detalle'] = $_POST['detalle'];
    $info['progreso_image'] = $_FILES["progreso_image"]["name"];
    $info['progreso_fisico_image'] = $_FILES["progreso_fisico_image"]["name"];
    $info['status'] = $_POST['statu'];

    foreach ($info as $key => $value) {
        if (empty($value))
            $errors[] = is_empty($key, $value);
    }

    if (empty($errors)) {
        if (empty($errors)) {
            $file_name_no_ext = md5(uniqid(rand(), true));
            $uploaded_msg = upload_img($file_name_no_ext, dir_info_progreso_clientes(), cliente_progreso_post_name());
            $info['progreso_image'] = $uploaded_msg[0];

            $file_name_no_ext_two = md5(uniqid(rand(), true));
            $uploaded_msg_two = upload_img($file_name_no_ext_two, dir_info_progreso_clientes(), cliente_progreso_fisico_post_name());
            $info['progreso_fisico_image'] = $uploaded_msg_two[0];

            $info['cliente_id'] = $_POST['cliente_id'];
            $info['user_id'] = $_POST['cliente_id_admin'];
            $info['fecha'] = date('Y-m-d');
            $info['asunto'] = $_POST['asunto'];
            $info['detalle'] = $_POST['detalle'];

            $info['status'] = $_POST['statu'];

            if (insert_progreso_cliente($info) > -1) {
                $success = true;
                $_SESSION['cliente_msg'] = "Registro exitoso.";
            }
        }
    }

    $_SESSION['errors'] = $errors;

    if ($success) {
        $redirect_to = root_dir() . 'progreso_cliente.php';
        header('Location: ' . $redirect_to);
    } else {

        $redirect_to = root_dir() . 'add_progreso_cliente.php?errormsg=true';
        header('Location: ' . $redirect_to);
    }
}
?>