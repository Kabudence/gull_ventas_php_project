<?php

require_once('init.php');

$errors = [];
$success = false;

if (!empty($_POST)) {
    $appStore = [];
    $appStore['tienda'] = $_POST['tienda'];
    $appStore['color'] = $_POST['color'];
    $appStore['codigo'] = $_POST['codigo'];
    $appStore['tienda_app_logo'] = $_FILES["tienda_app_logo"]["name"];
    $appStore['tienda_app_icono'] = $_FILES["tienda_app_icono"]["name"];
    $appStore['tienda_app_nosotros'] = $_FILES["tienda_app_nosotros"]["name"];
    $appStore['nombre'] = $_POST['nombre'];
    $appStore['statu'] = $_POST['statu'];
    $appStore['facebook_url'] = $_POST['facebook_url'];
    $appStore['instagram_url'] = $_POST['instragram_url'];
    $appStore['mision'] = $_POST['mision'];
    $appStore['vision'] = $_POST['vision'];
    $appStore['objetivos'] = $_POST['objetivos'];
    $appStore['color_texto'] = $_POST['color_texto'];

    $appStore['tienda_app_icon_cat_producto'] = $_FILES["tienda_app_icon_cat_producto"]["name"];
    $appStore['tienda_app_icon_cat_servicio'] = $_FILES["tienda_app_icon_cat_servicio"]["name"];
    $appStore['tienda_app_icon_cat_membresia'] = $_FILES["tienda_app_icon_cat_membresia"]["name"];
    $appStore['tienda_app_icon_cat_ofertas'] = $_FILES["tienda_app_icon_cat_ofertas"]["name"];
    $appStore['tienda_app_icon_cat_otros'] = $_FILES["tienda_app_icon_cat_otros"]["name"];
    
    $appStore['div_cat_productos'] = $_POST['div_cat_productos'];
    $appStore['div_cat_servicios'] = $_POST['div_cat_servicios'];
    $appStore['div_cat_membresias'] = $_POST['div_cat_membresias'];
    $appStore['div_cat_ofertas_promociones'] = $_POST['div_cat_ofertas_promociones'];
    $appStore['div_cat_otros'] = $_POST['div_cat_otros'];
    $appStore['url_video'] = $_POST['url_video'];

    foreach ($appStore as $key => $value) {
        if (empty($value))
            $errors[] = is_empty($key, $value);
    }

    if (empty($errors)) {
        if (empty($errors)) {
            $file_name_no_ext = md5(uniqid(rand(), true));
            $uploaded_msg = upload_img($file_name_no_ext, dir_logo(), pantalla_logo_post_name());
            $appStore['tienda_app_logo'] = $uploaded_msg[0];

            $file_name_no_ext_two = md5(uniqid(rand(), true));
            $uploaded_msg_two = upload_img($file_name_no_ext_two, dir_iconos(), pantalla_icono_post_name());
            $appStore['tienda_app_icono'] = $uploaded_msg_two[0];

            $file_name_no_ext_three = md5(uniqid(rand(), true));
            $uploaded_msg_three = upload_img($file_name_no_ext_three, dir_nosotros(), pantalla_img_nosotros_post_name());
            $appStore['tienda_app_nosotros'] = $uploaded_msg_three[0];
            
            $file_name_no_ext_four = md5(uniqid(rand(), true));
            $uploaded_msg_four = upload_img($file_name_no_ext_four, dir_iconos(), pantalla_icono_cat_producto_post_name());
            $appStore['tienda_app_icon_cat_producto'] = $uploaded_msg_four[0];
            
            $file_name_no_ext_five = md5(uniqid(rand(), true));
            $uploaded_msg_five = upload_img($file_name_no_ext_five, dir_iconos(), pantalla_icono_cat_servicio_post_name());
            $appStore['tienda_app_icon_cat_servicio'] = $uploaded_msg_four[0];

            $file_name_no_ext_six = md5(uniqid(rand(), true));
            $uploaded_msg_six = upload_img($file_name_no_ext_six, dir_iconos(), pantalla_icono_cat_membresia_post_name());
            $appStore['tienda_app_icon_cat_membresia'] = $uploaded_msg_six[0];
            
            $file_name_no_ext_seven = md5(uniqid(rand(), true));
            $uploaded_msg_seven = upload_img($file_name_no_ext_seven, dir_iconos(), pantalla_icono_cat_ofertas_post_name());
            $appStore['tienda_app_icon_cat_ofertas'] = $uploaded_msg_seven[0];
            
            $file_name_no_ext_eight = md5(uniqid(rand(), true));
            $uploaded_msg_eight = upload_img($file_name_no_ext_eight, dir_iconos(), pantalla_icono_cat_otros_post_name());
            $appStore['tienda_app_icon_cat_otros'] = $uploaded_msg_eight[0];
            
            $buscar_tienda_id = tienda_existe_por_id($appStore['tienda']);
            if ($buscar_tienda_id) {
                $_SESSION['errors'] = "Tienda ya existe.";
            } else {
                if (insert_pantalla_color($appStore) > -1) {
                    $success = true;
                    $_SESSION['screen_msg'] = "Pantalla agregada con éxito.";
                }
            }
        }
    }

    $_SESSION['errors'] = $errors;

    if ($success) {
        $redirect_to = root_dir() . 'tiendas.php';
        header('Location: ' . $redirect_to);
    } else {

        $redirect_to = root_dir() . 'add_pantalla_color.php?errormsg=true';
        header('Location: ' . $redirect_to);
    }
}
?>