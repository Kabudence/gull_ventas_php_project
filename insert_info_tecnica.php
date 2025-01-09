<?php

require_once('init.php');

$errors = [];
$success = false;

if (!empty($_POST)) {

    $info = [];
    $info['cliente_id'] = $_POST['cliente_id'];
    $info['user_id'] = $_POST['cliente_id_admin'];
    $info['fecha_inicio_rutina'] = $_POST['fecha_inicio_rutina'];
    $info['fecha_fin_rutina'] = $_POST['fecha_fin_rutina'];
    $info['frecuencia_rutina'] = $_POST['frecuencia_rutina'];
    $info['fecha'] = date('Y-m-d');
    $info['image_rutina'] = $_FILES["rutina_image"]["name"];
    $info['image_dieta'] = $_FILES["dieta_image"]["name"];
    $info['status'] = $_POST['statu'];

    foreach ($info as $key => $value) {
        if (empty($value))
            $errors[] = is_empty($key, $value);
    }

    if (empty($errors)) {
        if (empty($errors)) {
            $file_name_no_ext = md5(uniqid(rand(), true));
            $uploaded_msg = upload_img($file_name_no_ext, dir_info_tecnica_clientes_rutina(), cliente_rutina_post_name());
            $info['image_rutina'] = $uploaded_msg[0];

            $file_name_no_ext_two = md5(uniqid(rand(), true));
            $uploaded_msg_two = upload_img($file_name_no_ext_two, dir_info_tecnica_clientes_dieta(), cliente_dieta_post_name());
            $info['image_dieta'] = $uploaded_msg_two[0];

            $info['cliente_id'] = $_POST['cliente_id'];
            $info['user_id'] = $_POST['cliente_id_admin'];
            $info['fecha'] = date('Y-m-d');
            $info['status'] = $_POST['statu'];

            if (insert_info_cliente($info) > -1) {
                $success = true;
                $_SESSION['cliente_msg'] = "Registro exitoso.";
            }
        }
    }

    $_SESSION['errors'] = $errors;

    if ($success) {
        $redirect_to = root_dir() . 'info_cliente.php';
        header('Location: ' . $redirect_to);
    } else {

        $redirect_to = root_dir() . 'add_info_cliente.php?errormsg=true';
        header('Location: ' . $redirect_to);
    }
}
?>