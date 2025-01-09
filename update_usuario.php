<?php

require_once('init.php');

$errors = [];
$success = false;
//$product = [];

if (!empty($_POST)) {

    $usuario = [];
    $usuario['user_id'] = $_POST['usuario_id'];
    $usuario['first_name'] = $_POST['nombre'];
    $usuario['mobile'] = $_POST['celular'];
    $usuario['password'] = $_POST['password'];
    $usuario['id_rol'] = $_POST['rol'];
    $usuario['alias'] = $_POST['alias'];
    $usuario['status'] = $_POST['statu'];

    foreach ($usuario as $key => $value) {
        if (empty($value)) {
            $errors[] = is_empty($key, $value);
        }
    }

    if (empty($errors)) {

        if (update_usuario_rol($usuario)) {
            $success = true;
            $_SESSION['Usuario_msg'] = "Usuario actualizado con éxito.";
        }
    }

    $_SESSION['errors'] = $errors;
    if ($success) {
        $redirect_to = root_dir() . 'usuarios.php';
        header('Location: ' . $redirect_to);
    } else {
        $redirect_to = root_dir() . 'add_usuario.php?usuario_id=' . $usuario['user_id'] . '&&errormsg=true';
        header('Location: ' . $redirect_to);
    }
}
?>