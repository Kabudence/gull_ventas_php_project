<?php

require_once('init.php');

$errors = [];
$success = false;

if (!empty($_POST)) {
    $sucursal = [];
    $sucursal['sucursal_id_admin'] = $_POST['sucursal_id_admin'];
    $sucursal['nombre'] = $_POST['nombre'];
    $sucursal['distrito'] = $_POST['distrito'];
    $sucursal['direccion'] = $_POST['direccion'];
    $sucursal['correo'] = $_POST['correo'];
    $sucursal['celular'] = $_POST['celular'];
    $sucursal['numero_sucursal'] = $_POST['numero_sucursal'];
    $sucursal['latitud'] = $_POST['latitud'];
    $sucursal['longitud'] = $_POST['longitud'];
    $sucursal['statu'] = $_POST['statu'];

    foreach ($sucursal as $key => $value) {
        if (empty($value))
            $errors[] = is_empty($key, $value);
    }

    if (empty($errors)) {
        if (empty($errors)) {
            if (insert_sucursal($sucursal) > -1) {
                $success = true;
                $_SESSION['sucursal_msg'] = "Sucursal agregado con éxito.";
            }
        }
    }

    $_SESSION['errors'] = $errors;

    if ($success) {
        $redirect_to = root_dir() . 'sucursales.php';
        header('Location: ' . $redirect_to);
    } else {

        $redirect_to = root_dir() . 'add_sucursal.php?errormsg=true';
        header('Location: ' . $redirect_to);
    }
}
?>