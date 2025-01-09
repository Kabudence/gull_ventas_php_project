<?php

require_once('init.php');

$errors = [];
$success = false;

if (!empty($_POST)) {

    $restriccion = [];

    $restriccion['id_negocio'] = $_POST['tienda'];
    $restriccion['limite_producto'] = $_POST['limiteproductos'];
    $restriccion['limite_foto'] = $_POST['limitefotos'];

    foreach ($rubro as $key => $value) {
        if (empty($value))
            $errors[] = is_empty($key, $value);
    }

    if (empty($errors)) {
        if (empty($errors)) {
            $buscar_tienda_id = tienda_existe_por_id_restriccion($restriccion['id_negocio']);
            if ($buscar_tienda_id) {
                $_SESSION['errors'] = "Negocio ya existe.";
            } else {
                if (insert_restriccion($restriccion) > -1) {
                    $success = true;
                    $_SESSION['restriccion_msg'] = "Restricción agregado con éxito.";
                }
            }
        }
    }

    $_SESSION['errors'] = $errors;

    if ($success) {
        $redirect_to = root_dir() . 'restricciones.php';
        header('Location: ' . $redirect_to);
    } else {

        $redirect_to = root_dir() . 'add_restriccion.php?errormsg=true';
        header('Location: ' . $redirect_to);
    }
}
?>