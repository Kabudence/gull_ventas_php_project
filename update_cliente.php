<?php

require_once('init.php');

$errors = [];
$success = false;
$product = [];

if (!empty($_POST)) {

    $cliente = [];
    $cliente_image = $_FILES["cliente_image"]["name"];
    $cliente['id'] = $_POST['cliente_id'];
    $cliente['image_name'] = $_POST['cliente_img_name'];
    $cliente['user_id'] = $_POST['cliente_id_admin'];
    $cliente['codigo'] = $_POST['codigo'];
    $cliente['nombres'] = $_POST['nombres'];
    $cliente['celular'] = $_POST['celular'];
    $cliente['email'] = $_POST['email'];
    $cliente['direccion'] = $_POST['direccion'];
    $cliente['tipo_cliente'] = $_POST['tipo_cliente'];
    $cliente['status'] = $_POST['statu'];
    
    foreach ($cliente as $key => $value) {
        if (empty($value)) {
            if ($key == 'image_name')
                continue;
            $errors[] = is_empty($key, $value);
        }
    }

    if (empty($errors)) {

        if (!empty($cliente_image)) {
            $file_name_no_ext = md5(uniqid(rand(), true));
            $uploaded_msg = upload_img($file_name_no_ext, dir_clientes(), cliente_post_name());
            delete_image($cliente['image_name'], dir_clientes());
            $cliente['image_name'] = $uploaded_msg[0];
        }
        
        if (update_clientes($cliente)) {
            $success = true;
            $_SESSION['product_msg'] = "Cliente actualizado con éxito.";
        }
    }

    $_SESSION['errors'] = $errors;

    if ($success) {
        $redirect_to = root_dir() . 'clientes.php';
        header('Location: ' . $redirect_to);
    } else {
        $redirect_to = root_dir() . 'add_cliente.php?cliente_id=' . $cliente['id'] . '&&errormsg=true';
        header('Location: ' . $redirect_to);
    }
}
?>