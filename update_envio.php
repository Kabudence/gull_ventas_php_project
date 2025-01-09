<?php

require_once('init.php');

$errors = [];
$success = false;
//$product = [];

if (!empty($_POST)) {
    $envio = [];
    $envio['envio_id'] = $_POST['envio_id'];
    $envio['envio_id_admin'] = $_POST['envio_id_admin'];
    $envio['sucursal_id'] = $_POST['sucursal_id'];
    $envio['distrito'] = $_POST['distrito'];
    $envio['precio'] = $_POST['precio'];
    $envio['statu'] = $_POST['statu'];

    foreach ($envio as $key => $value) {
        if (empty($value)) {
            $errors[] = is_empty($key, $value);
        }
    }

    if (empty($errors)) {
        if (update_envio($envio)) {
            $success = true;
            $_SESSION['envio_msg'] = "envio actualizado con éxito.";
        }
    }

    $_SESSION['errors'] = $errors;
    if ($success) {
        $redirect_to = root_dir() . 'envios.php';
        header('Location: ' . $redirect_to);
    } else {
        $redirect_to = root_dir() . 'add_envio.php?envio_id=' . $envio['envio_id'] . '&&errormsg=true';
        header('Location: ' . $redirect_to);
    }
}
?>