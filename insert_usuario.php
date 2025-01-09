<?php

require_once('init.php');

$errors = [];
$success = false;

if (!empty($_POST)) {

    $usuario = [];

    $usuario['type'] = 4;
    $usuario['first_name'] = $_POST['nombre'];
    $usuario['username'] = "usuario";
    $usuario['mobile'] = $_POST['celular'];
    $usuario['password'] = $_POST['password'];
    $usuario['id_user_create'] = $_POST['admin_id'];
    $usuario['id_rol'] = $_POST['rol'];
    $usuario['alias'] = $_POST['alias'];
    $usuario['status'] = $_POST['statu'];
    

    //$tipo = $_POST['cod_tipo_servicio'];

    foreach ($usuario as $key => $value) {
        if (empty($value))
            $errors[] = is_empty($key, $value);
    }

    if (empty($errors)) {
        if (empty($errors)) {
            if (insert_usuario($usuario) > -1) {
                $success = true;
                $_SESSION['usuario_msg'] = "Usuario agregado con éxito.";
            }
        }
    }


    $_SESSION['errors'] = $errors;

    if ($success) {
        $redirect_to = root_dir() . 'usuarios.php';
        header('Location: ' . $redirect_to);
    } else {

        $redirect_to = root_dir() . 'add_usuario.php?errormsg=true';
        header('Location: ' . $redirect_to);
    }
}
?>