<?php

require_once('init.php');

$errors = [];
$errors_mensaje = [];
$success = false;

$Row_Slider = [];
$Slider_valor = "";

if (!empty($_POST)) {

    $slider = [];
    $slider['slider_image'] = $_FILES["slider_image"]["name"];
    $slider['statu'] = $_POST['statu'];
    $slider['sort'] = 2;

    $slider['id_user'] = $_POST['slider_id_admin'];

    foreach ($slider as $key => $value) {
        if (empty($value))
            $errors[] = is_empty($key, $value);
    }

    if (empty($errors)) {

        if (empty($errors)) {
            $file_name_no_ext = md5(uniqid(rand(), true));
            //$uploaded_msg = upload_img($file_name_no_ext, dir_slider(), slider_post_name());
            $uploaded_msg = upload_img($file_name_no_ext, dir_slider(), slider_post_name());

            $slider['title'] = $_POST['title'];
            $slider['image_name'] = $uploaded_msg[0];
            $id_user = $_POST['slider_id_admin'];
            $Row_Slider = get_number_slider_user_id($id_user);
            $Slider_valor = $Row_Slider['valor'];
          
            $Row_Restrccion_slider = get_limite_producto_slider($id_user);
            $limite_Slider = $Row_Restrccion_slider['limite_foto'];
            if ($Slider_valor == $limite_Slider) {
                $errors_mensaje[] = "Ha superador el limite de slider permitido.";
                $_SESSION['errors_limit'] = $errors_mensaje;
            } else {
                if (insert_slider($slider) > -1) {
                    $success = true;
                    $_SESSION['slider_msg'] = "Slider agregada con éxito.";
                }
            }
        }
    }

    $_SESSION['errors'] = $errors;
   
    if ($success) {
        $redirect_to = root_dir() . 'slider.php';
        header('Location: ' . $redirect_to);
    } else {

        $redirect_to = root_dir() . 'add_slider.php?errormsg=true&Limit=true';
        header('Location: ' . $redirect_to);
    }
}
?>