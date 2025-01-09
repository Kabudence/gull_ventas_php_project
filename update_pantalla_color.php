<?php

require_once('init.php');

$errors = [];
$success = false;

if (!empty($_POST)) {
    $appStore = [];
    $appStore['tienda'] = $_POST['tienda'];
    $appStore['color'] = $_POST['color'];
    $appStore['codigo'] = $_POST['codigo'];

    //archivos file
    $logo_image = $_FILES["tienda_app_logo"]["name"];
    $icono_image = $_FILES["tienda_app_icono"]["name"];
    $image_nosotros = $_FILES["tienda_app_nosotros"]["name"];

    $icono_cat_producto = $_FILES["tienda_app_icon_cat_producto"]["name"];
    $icono_cat_servicio = $_FILES["tienda_app_icon_cat_servicio"]["name"];
    $icono_cat_membresia = $_FILES["tienda_app_icon_cat_membresia"]["name"];
    $icono_cat_ofertas = $_FILES["tienda_app_icon_cat_ofertas"]["name"];
    $icono_cat_otros = $_FILES["tienda_app_icon_cat_otros"]["name"];

    $appStore['tienda_app_logo'] = $_POST['screen_img_logo_name'];
    $appStore['tienda_app_icono'] = $_POST['screen_img_icono_name'];
    $appStore['tienda_app_nosotros'] = $_POST['screen_img_nosotros'];

    $appStore['tienda_app_icon_cat_producto'] = $_POST['screen_icon_cat_producto'];
    $appStore['tienda_app_icon_cat_servicio'] = $_POST['screen_icon_cat_servicio'];
    $appStore['tienda_app_icon_cat_membresia'] = $_POST['screen_icon_cat_membresia'];
    $appStore['tienda_app_icon_cat_ofertas'] = $_POST['screen_icon_cat_ofertas'];
    $appStore['tienda_app_icon_cat_otros'] = $_POST['screen_icon_cat_otros'];

    $appStore['nombre'] = $_POST['nombre'];
    $appStore['facebook_url'] = $_POST['facebook_url'];
    $appStore['instagram_url'] = $_POST['instragram_url'];
    $appStore['mision'] = $_POST['mision'];
    $appStore['vision'] = $_POST['vision'];
    $appStore['objetivos'] = $_POST['objetivos'];

    $appStore['div_cat_productos'] = $_POST['div_cat_productos'];
    $appStore['div_cat_servicios'] = $_POST['div_cat_servicios'];
    $appStore['div_cat_membresias'] = $_POST['div_cat_membresias'];
    $appStore['div_cat_ofertas_promociones'] = $_POST['div_cat_ofertas_promociones'];
    $appStore['div_cat_otros'] = $_POST['div_cat_otros'];
    $appStore['url_video'] = $_POST['url_video'];
    $appStore['color_texto'] = $_POST['color_texto'];

    $appStore['statu'] = $_POST['statu'];
    $appStore['id'] = $_POST['screen_id'];


    
    /*if (isset($icono_cat_producto)) {
        $icono_cat_producto = $_FILES["tienda_app_icon_cat_producto"]["name"];
        $appStore['tienda_app_icon_cat_producto'] = $_FILES["tienda_app_icon_cat_producto"]["name"];
    } else {
        $icono_cat_producto = "";
        $appStore['tienda_app_icon_cat_producto'] = "";
    }*/
        
    if (isset($_POST['screen_img_nosotros'])) {
        $appStore['tienda_app_nosotros'] = $_POST['screen_img_nosotros'];
    } else {
        $appStore['tienda_app_nosotros'] = "";
    }

    if (isset($_POST['div_cat_productos'])) {
        $appStore['div_cat_productos'] = $_POST['div_cat_productos'];
    } else {
        $appStore['div_cat_productos'] = "";
    }

    if (isset($_POST['div_cat_servicios'])) {
        $appStore['div_cat_servicios'] = $_POST['div_cat_servicios'];
    } else {
        $appStore['div_cat_servicios'] = "";
    }

    if (isset($_POST['div_cat_membresias'])) {
        $appStore['div_cat_membresias'] = $_POST['div_cat_membresias'];
    } else {
        $appStore['div_cat_membresias'] = "";
    }

    if (isset($_POST['div_cat_ofertas_promociones'])) {
        $appStore['div_cat_ofertas_promociones'] = $_POST['div_cat_ofertas_promociones'];
    } else {
        $appStore['div_cat_ofertas_promociones'] = "";
    }

    if (isset($_POST['div_cat_otros'])) {
        $appStore['div_cat_otros'] = $_POST['div_cat_otros'];
    } else {
        $appStore['div_cat_otros'] = "";
    }

    if (isset($_POST['url_video'])) {
        $appStore['url_video'] = $_POST['url_video'];
    } else {
        $appStore['url_video'] = "";
    }
    if (isset($_POST['color_texto'])) {
        $appStore['color_texto'] = $_POST['color_texto'];
    } else {
        $appStore['color_texto'] = "";
    }

    if (isset($_POST['screen_icon_cat_producto'])) {
        $appStore['tienda_app_icon_cat_producto'] = $_POST['screen_icon_cat_producto'];
    } else {
        $appStore['tienda_app_icon_cat_producto'] = "";
    }

    if (isset($_POST['screen_icon_cat_servicio'])) {
        $appStore['tienda_app_icon_cat_servicio'] = $_POST['screen_icon_cat_servicio'];
    } else {
        $appStore['tienda_app_icon_cat_servicio'] = "";
    }

    if (isset($_POST['screen_icon_cat_producto'])) {
        $appStore['tienda_app_icon_cat_producto'] = $_POST['screen_icon_cat_producto'];
    } else {
        $appStore['tienda_app_icon_cat_producto'] = "";
    }

    if (isset($_POST['screen_icon_cat_servicio'])) {
        $appStore['tienda_app_icon_cat_servicio'] = $_POST['screen_icon_cat_servicio'];
    } else {
        $appStore['tienda_app_icon_cat_servicio'] = "";
    }

    if (isset($_POST['screen_icon_cat_membresia'])) {
        $appStore['tienda_app_icon_cat_membresia'] = $_POST['screen_icon_cat_membresia'];
    } else {
        $appStore['tienda_app_icon_cat_membresia'] = "";
    }

    if (isset($_POST['screen_icon_cat_membresia'])) {
        $appStore['tienda_app_icon_cat_membresia'] = $_POST['screen_icon_cat_membresia'];
    } else {
        $appStore['tienda_app_icon_cat_membresia'] = "";
    }

    if (isset($_POST['screen_icon_cat_ofertas'])) {
        $appStore['tienda_app_icon_cat_ofertas'] = $_POST['screen_icon_cat_ofertas'];
    } else {
        $appStore['tienda_app_icon_cat_ofertas'] = "";
    }

    if (isset($_POST['screen_icon_cat_otros'])) {
        $appStore['tienda_app_icon_cat_otros'] = $_POST['screen_icon_cat_otros'];
    } else {
        $appStore['tienda_app_icon_cat_otros'] = "";
    }

    foreach ($appStore as $key => $value) {
        if (empty($value)) {
            //if ($key == 'image_name')
            //  continue;
            $errors[] = is_empty($key, $value);
        }
    }

    if (empty($errors)) {

        if (!empty($logo_image)) {
            $file_name_no_ext = md5(uniqid(rand(), true));
            $uploaded_msg = upload_img($file_name_no_ext, dir_logo(), pantalla_logo_post_name());
            delete_image($appStore['tienda_app_logo'], dir_logo());
            $appStore['tienda_app_logo'] = $uploaded_msg[0];
        }

        if (!empty($icono_image)) {
            $file_name_no_ext_two = md5(uniqid(rand(), true));
            $uploaded_msg_two = upload_img($file_name_no_ext_two, dir_iconos(), pantalla_icono_post_name());
            delete_image($appStore['tienda_app_icono'], dir_iconos());
            $appStore['tienda_app_icono'] = $uploaded_msg_two[0];
        }
        if (!empty($image_nosotros)) {
            $file_name_no_ext_three = md5(uniqid(rand(), true));
            $uploaded_msg_three = upload_img($file_name_no_ext_three, dir_nosotros(), pantalla_img_nosotros_post_name());
            delete_image($appStore['tienda_app_nosotros'], dir_nosotros());
            $appStore['tienda_app_nosotros'] = $uploaded_msg_three[0];
        }

        if (!empty($icono_cat_producto)) {
            $file_name_no_ext_prod = md5(uniqid(rand(), true));
            $uploaded_msg_prod = upload_img($file_name_no_ext_prod, dir_iconos(), pantalla_icono_cat_producto_post_name());
            delete_image($appStore['tienda_app_icon_cat_producto'], dir_iconos());
            $appStore['tienda_app_icon_cat_producto'] = $uploaded_msg_prod[0];
        }
        
        if (!empty($icono_cat_servicio)) {
            $file_name_no_ext_servicio = md5(uniqid(rand(), true));
            $uploaded_msg_servicio = upload_img($file_name_no_ext_servicio, dir_iconos(), pantalla_icono_cat_servicio_post_name());
            delete_image($appStore['tienda_app_icon_cat_servicio'], dir_iconos());
            $appStore['tienda_app_icon_cat_servicio'] = $uploaded_msg_servicio[0];
        }

        if (!empty($icono_cat_membresia)) {
            $file_name_no_ext_membresia = md5(uniqid(rand(), true));
            $uploaded_msg_membresia = upload_img($file_name_no_ext_membresia, dir_iconos(), pantalla_icono_cat_membresia_post_name());
            delete_image($appStore['tienda_app_icon_cat_membresia'], dir_iconos());
            $appStore['tienda_app_icon_cat_membresia'] = $uploaded_msg_membresia[0];
        }

        if (!empty($icono_cat_ofertas)) {
            $file_name_no_ext_ofertas = md5(uniqid(rand(), true));
            $uploaded_msg_ofertas = upload_img($file_name_no_ext_ofertas, dir_iconos(), pantalla_icono_cat_ofertas_post_name());
            delete_image($appStore['tienda_app_icon_cat_ofertas'], dir_iconos());
            $appStore['tienda_app_icon_cat_ofertas'] = $uploaded_msg_ofertas[0];
        }

        if (!empty($icono_cat_otros)) {
            $file_name_no_ext_otros = md5(uniqid(rand(), true));
            $uploaded_msg_otros = upload_img($file_name_no_ext_otros, dir_iconos(), pantalla_icono_cat_otros_post_name());
            delete_image($appStore['tienda_app_icon_cat_otros'], dir_iconos());
            $appStore['tienda_app_icon_cat_otros'] = $uploaded_msg_otros[0];
        }

        if (update_screen($appStore)) {
            $success = true;
            $_SESSION['screen_msg'] = "Registro actualizado con éxito.";
        }
    }
    $_SESSION['errors'] = $errors;
    if ($success) {
        $redirect_to = root_dir() . 'tiendas.php';
        header('Location: ' . $redirect_to);
    } else {
        $redirect_to = root_dir() . 'add_pantalla_color.php?screen_id=' . $appStore['id'] . '&&errormsg=true';
        header('Location: ' . $redirect_to);
    }
}
?>