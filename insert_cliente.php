<?php

require_once('init.php');

$errors = [];
$success = false;

if (!empty($_POST)) {

    $cliente = [];
    $cliente['image_name'] = $_FILES["cliente_image"]["name"];
    $cliente['user_id'] = $_POST['cliente_id_admin'];
    $cliente['codigo'] = $_POST['codigo'];
    $cliente['nombres'] = $_POST['nombres'];
    $cliente['celular'] = $_POST['celular'];
    $cliente['email'] = $_POST['email'];
    $cliente['direccion'] = $_POST['direccion'];
    $cliente['tipo_cliente'] = $_POST['tipo_cliente'];
    $cliente['status'] = $_POST['statu'];

    foreach ($cliente as $key => $value) {
        if (empty($value))
            $errors[] = is_empty($key, $value);
    }

    if (empty($errors)) {
        if (empty($errors)) {
            $file_name_no_ext = md5(uniqid(rand(), true));
            $uploaded_msg = upload_img($file_name_no_ext, dir_clientes(), cliente_post_name());

            $cliente['user_id'] = $_POST['cliente_id_admin'];
            $cliente['codigo'] = $_POST['codigo'];
            $cliente['nombres'] = $_POST['nombres'];
            $cliente['celular'] = $_POST['celular'];
            $cliente['email'] = $_POST['email'];
            $cliente['direccion'] = $_POST['direccion'];
            $cliente['tipo_cliente'] = $_POST['tipo_cliente'];
            $cliente['image_name'] = $uploaded_msg[0];
            $cliente['status'] = $_POST['statu'];

            if (insert_cliente($cliente) > -1) {
                $success = true;
                $_SESSION['cliente_msg'] = "Cliente agregado con éxito.";
            }
        }
    }

    $_SESSION['errors'] = $errors;

    if ($success) {
        $redirect_to = root_dir() . 'clientes.php';
        header('Location: ' . $redirect_to);
    } else {

        $redirect_to = root_dir() . 'add_cliente.php?errormsg=true';
        header('Location: ' . $redirect_to);
    }
}
?>