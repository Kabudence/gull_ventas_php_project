<?php

require_once('init.php');

$errors = [];
$success = false;

if (!empty($_POST)) {

    $rubro = [];
    $rubro['codigo'] = $_POST['codigo'];
    $rubro['descripcion'] = $_POST['descripcion'];
    $rubro['statu'] = $_POST['statu'];

    foreach ($rubro as $key => $value) {
        if (empty($value))
            $errors[] = is_empty($key, $value);
    }

    if (empty($errors)) {
        if (empty($errors)) {
            if (insert_rubro($rubro) > -1) {
                $success = true;
                $_SESSION['rubro_msg'] = "Rubro agregado con éxito.";
            }
        }
    }

    $_SESSION['errors'] = $errors;

    if ($success) {
        $redirect_to = root_dir() . 'rubros.php';
        header('Location: ' . $redirect_to);
    } else {

        $redirect_to = root_dir() . 'add_rubro.php?errormsg=true';
        header('Location: ' . $redirect_to);
    }
}
?>