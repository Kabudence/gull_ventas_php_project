<?php

function concate_address($address) {

    $con_ad = "";
    if (!empty($address)) {
        foreach ($address as $key => $value) {

            if (!empty($value) && (trim($value) != "")) {
                if (($key == "address_id"))
                    continue;
                if ($key == "country")
                    $con_ad .= $value . ".<br>";
                else
                    $con_ad .= $value . ", <br>";
            }
        }
    }
    return $con_ad;
}

function get_currency() {
    return "S/";
}

function get_porcentage() {
    return "%";
}

function get_vat() {
    return 0;
}

function generate_ordered_id($date, $id) {
    return "#" . date("hmmjY", strtotime($date)) . $id;
}

function get_order_status_str($staus_code) {

    if ($staus_code == 1)
        $order_status = "Pendiente";
    else if ($staus_code == 2)
        $order_status = "Aceptado";
    else if ($staus_code == 3)
        $order_status = "Pendiente";

    return $order_status;
}

function get_order_status($staus_code) {

    if ($staus_code == 1)
        $order_status = "red,Pendiente";
    else if ($staus_code == 2)
        $order_status = "green,Aceptado";
    else if ($staus_code == 3)
        $order_status = "black,Pendiente";

    return explode(",", $order_status);
}

function get_order_statusc($staus_code) {

    if ($staus_code == 0)
        $order_status = "red,Pendiente";
    else if ($staus_code == 1)
        $order_status = "green,Preparado";

    else if ($staus_code == 2)
        $order_status = "red,No Preparado";
    return explode(",", $order_status);
}

function get_order_statusx($staus_code) {

    if ($staus_code == 0)
        $order_status = "red,Sin Preparar";
    else if ($staus_code == 1)
        $order_status = "green,Preparado";



    return explode(",", $order_status);
}

function get_order_statusy($staus_code) {

    if ($staus_code == 0)
        $order_status = "red,Sin envio";
    else if ($staus_code == 1)
        $order_status = "green,Enviado";


    return explode(",", $order_status);
}

function get_opposite_status($staus_code) {

    if ($staus_code == 1)
        return 2;
    else if ($staus_code == 2)
        return 1;
}

function truncated_message($message, $char_count) {
    if (strlen($message) > $char_count)
        return substr($message, 0, $char_count) . " ...";
    else
        return $message;
}

function logged_in() {
    $admin_info = [];
    if ((isset($_SESSION['admin_id'])) && (isset($_SESSION['username'])) && (!empty($_SESSION['admin_id'])) && (!empty($_SESSION['username']))) {
        $admin_info[0] = $_SESSION['admin_id'];
        $admin_info[1] = $_SESSION['username'];
    }
    return $admin_info;
}

function set_logged_in($admin) {

    $_SESSION['admin_id'] = $admin['admin_id'];
    $_SESSION['username'] = $admin['username'];
}

function set_deletion_msg() {
    $_SESSION['deletion_msg'] = "Usuario eliminado con éxito.";
}

function unset_deletion_msg() {
    if ((isset($_SESSION['deletion_msg'])) && (!empty($_SESSION['deletion_msg']))) {
        unset($_SESSION['deletion_msg']);
    }
}

function get_deletion_msg() {

    $message = "";
    if ((isset($_SESSION['deletion_msg'])) && (!empty($_SESSION['deletion_msg']))) {
        $message = $_SESSION['deletion_msg'];
    }
    return $message;
}

// USERS
function set_users_deletion_msg() {
    $_SESSION['users_msg'] = "Usuario eliminado con éxito.";
}

function set_roles_deletion_msg() {
    $_SESSION['roles_msg'] = "Rol eliminado con éxito.";
}

function unset_users_msg() {
    if ((isset($_SESSION['users_msg'])) && (!empty($_SESSION['users_msg']))) {
        unset($_SESSION['users_msg']);
    }
}

function get_users_msg() {

    $message = "";
    if ((isset($_SESSION['users_msg'])) && (!empty($_SESSION['users_msg']))) {
        $message = $_SESSION['users_msg'];
    }
    return $message;
}

// ORDERS
function set_deletion_msg_all($param) {
    $session_var = $param . "_msg";

    $param_arr = explode("_", $param);
    $message = "";
    if (count($param_arr) == 2) {
        $message = ucfirst($param_arr[0]) . " " . $param_arr[1];
    } else if (count($param_arr) == 1) {
        $message = ucfirst($param_arr[0]);
    }

    $_SESSION[$session_var] = $message . " Borrado exitosamente.";
}

function unset_msg_all($param) {
    $session_var = $param . "_msg";
    if ((isset($_SESSION[$session_var])) && (!empty($_SESSION[$session_var]))) {
        unset($_SESSION[$session_var]);
    }
}

function set_msg_all($param) {

    $session_var = $param . "_msg";
    $param_arr = explode("_", $param);
    $message = "";
    if (count($param_arr) == 2) {
        $message = ucfirst($param_arr[0]) . " " . $param_arr[1];
    } else if (count($param_arr) == 1) {
        $message = ucfirst($param_arr[0]);
    }
    $_SESSION[$session_var] = $message . " Actualizado con éxito.";
}

/* SESSION */

function set_session_msg($session_var, $session_message) {

    $session_var = $session_var . "_msg";
    $_SESSION[$session_var] = $session_message;
}

function get_session_msg($session_var) {

    $session_var = $session_var . "_msg";
    $message = "";
    if ((isset($_SESSION[$session_var])) && (!empty($_SESSION[$session_var]))) {
        $message = $_SESSION[$session_var];
    }
    return $message;
}

function unset_session_msg($session_var) {
    $session_var = $session_var . "_msg";
    if ((isset($_SESSION[$session_var])) && (!empty($_SESSION[$session_var]))) {
        unset($_SESSION[$session_var]);
    }
}

function session_exists($session_var) {
    $session_var = $session_var . "_msg";
    if ((isset($_SESSION[$session_var])) && (!empty($_SESSION[$session_var]))) {
        return true;
    } else {
        return false;
    }
}

function get_msg_all($param) {

    $session_var = $param . "_msg";
    $message = "";
    if ((isset($_SESSION[$session_var])) && (!empty($_SESSION[$session_var]))) {
        $message = $_SESSION[$session_var];
    }
    return $message;
}

function redirect_to_link($file_name) {
    $redirect_to = root_dir() . $file_name;
    header('Location: ' . $redirect_to);
}

// COLORS
function set_color_deletion_msg() {
    $_SESSION['color_msg'] = "Color eliminado con éxito.";
}

function unset_color_msg() {
    if ((isset($_SESSION['color_msg'])) && (!empty($_SESSION['color_msg']))) {
        unset($_SESSION['color_msg']);
    }
}

function get_color_msg() {

    $message = "";
    if ((isset($_SESSION['color_msg'])) && (!empty($_SESSION['color_msg']))) {
        $message = $_SESSION['color_msg'];
    }
    return $message;
}

// PRODUCTS
function set_product_deletion_msg() {
    $_SESSION['product_msg'] = "Producto eliminado con éxito.";
}

function set_catalog_deletion_msg() {
    $_SESSION['product_msg'] = "Catalogo eliminado con éxito.";
}

function set_planes_deletion_msg() {
    $_SESSION['product_msg'] = "Plan eliminado con éxito.";
}

function unset_product_msg() {
    if ((isset($_SESSION['product_msg'])) && (!empty($_SESSION['product_msg']))) {
        unset($_SESSION['product_msg']);
    }
}

function unset_videos_msg() {
    if ((isset($_SESSION['videos_msg'])) && (!empty($_SESSION['videos_msg']))) {
        unset($_SESSION['videos_msg']);
    }
}

function get_product_msg() {

    $message = "";
    if ((isset($_SESSION['product_msg'])) && (!empty($_SESSION['product_msg']))) {
        $message = $_SESSION['product_msg'];
    }
    return $message;
}

function get_videos_msg() {

    $message = "";
    if ((isset($_SESSION['videos_msg'])) && (!empty($_SESSION['videos_msg']))) {
        $message = $_SESSION['videos_msg'];
    }
    return $message;
}


// ADMIN PASWORD

function get_admin_update_msg() {

    $message = "";
    if ((isset($_SESSION['admin_msg'])) && (!empty($_SESSION['admin_msg']))) {
        $message = $_SESSION['admin_msg'];
    }
    return $message;
}

function get_admin_update_address_msg() {

    $message = "";
    if ((isset($_SESSION['admin_address_msg'])) && (!empty($_SESSION['admin_address_msg']))) {
        $message = $_SESSION['admin_address_msg'];
    }
    return $message;
}

function set_admin_update_msg() {
    $_SESSION['admin_msg'] = "Usuario actualizado con éxito.";
}

function set_admin_address_update_msg() {
    $_SESSION['admin_address_msg'] = "Dirección actualizada con éxito.";
}

function unset_admin_update_msg() {
    if ((isset($_SESSION['admin_msg'])) && (!empty($_SESSION['admin_msg']))) {
        unset($_SESSION['admin_msg']);
    }
}

function unset_admin_address_update_msg() {
    if ((isset($_SESSION['admin_address_msg'])) && (!empty($_SESSION['admin_address_msg']))) {
        unset($_SESSION['admin_address_msg']);
    }
}

// CATEGORIES
function set_category_deletion_msg() {
    $_SESSION['category_msg'] = "Categoría eliminada con éxito.";
}

// CATEGORIES
function set_subcategory_deletion_msg() {
    $_SESSION['subcategoria_msg'] = "SubCategoría eliminada con éxito.";
}

// SCREEN
function set_screen_deletion_msg() {
    $_SESSION['screen_msg'] = "Registro eliminado con éxito.";
}

// RUBRO
function set_rubro_deletion_msg() {
    $_SESSION['rubro_msg'] = "Rubro eliminado con éxito.";
}

// VIDEOS DESTACADOS
function set_video_destacado_deletion_msg() {
    $_SESSION['video_msg'] = "Video eliminado con éxito.";
}

//ENVIOS
function set_envios_deletion_msg() {
    $_SESSION['envio_msg'] = "Envio eliminado con éxito.";
}

// SUCURSAL
function set_sucursal_deletion_msg() {
    $_SESSION['sucursal_msg'] = "Sucursal eliminado con éxito.";
}

//USUARIO
function set_usuario_deletion_msg() {
    $_SESSION['usuario_msg'] = "Usuario eliminado con éxito.";
}

// RESTRICCIÓN
function set_restriccion_deletion_msg() {
    $_SESSION['rubro_msg'] = "Restricción eliminada con éxito.";
}

function set_slider_deletion_msg() {
    $_SESSION['slider_msg'] = "slider eliminada con éxito.";
}
function set_cliente_deletion_msg() {
    $_SESSION['cliente_msg'] = "cliente eliminado con éxito.";
}

function set_info_cliente_deletion_msg() {
    $_SESSION['info_msg'] = "Registro eliminado con éxito.";
}

function set_progreso_cliente_deletion_msg() {
    $_SESSION['progreso_msg'] = "Registro eliminado con éxito.";
}

function unset_category_msg() {
    if ((isset($_SESSION['category_msg'])) && (!empty($_SESSION['category_msg']))) {
        unset($_SESSION['category_msg']);
    }
}

function unset_rol_msg() {
    if ((isset($_SESSION['rol_msg'])) && (!empty($_SESSION['rol_msg']))) {
        unset($_SESSION['rol_msg']);
    }
}

function unset_subcategory_msg() {
    if ((isset($_SESSION['subcategory_msg'])) && (!empty($_SESSION['subcategory_msg']))) {
        unset($_SESSION['subcategory_msg']);
    }
}

function unset_slider_msg() {
    if ((isset($_SESSION['slider_msg'])) && (!empty($_SESSION['slider_msg']))) {
        unset($_SESSION['slider_msg']);
    }
}

function unset_clientes_msg() {
    if ((isset($_SESSION['clientes_msg'])) && (!empty($_SESSION['clientes_msg']))) {
        unset($_SESSION['clientes_msg']);
    }
}

function unset_sucursal_msg() {
    if ((isset($_SESSION['sucursal_msg'])) && (!empty($_SESSION['sucursal_msg']))) {
        unset($_SESSION['sucursal_msg']);
    }
}

function unset_envio_msg() {
    if ((isset($_SESSION['envio_msg'])) && (!empty($_SESSION['envio_msg']))) {
        unset($_SESSION['envio_msg']);
    }
}

function get_category_msg() {

    $message = "";
    if ((isset($_SESSION['category_msg'])) && (!empty($_SESSION['category_msg']))) {
        $message = $_SESSION['category_msg'];
    }
    return $message;
}

function get_rol_msg() {

    $message = "";
    if ((isset($_SESSION['rol_msg'])) && (!empty($_SESSION['rol_msg']))) {
        $message = $_SESSION['rol_msg'];
    }
    return $message;
}

function get_subcategory_msg() {

    $message = "";
    if ((isset($_SESSION['subcategory_msg'])) && (!empty($_SESSION['subcategory_msg']))) {
        $message = $_SESSION['subcategory_msg'];
    }
    return $message;
}

function get_slider_msg() {

    $message = "";
    if ((isset($_SESSION['slider_msg'])) && (!empty($_SESSION['slider_msg']))) {
        $message = $_SESSION['slider_msg'];
    }
    return $message;
}

function get_customer_msg() {

    $message = "";
    if ((isset($_SESSION['clientes_msg'])) && (!empty($_SESSION['clientes_msg']))) {
        $message = $_SESSION['clientes_msg'];
    }
    return $message;
}

// CATEGORIES
function set_type_deletion_msg() {
    $_SESSION['type_msg'] = "Categoría eliminada con éxito.";
}

function unset_type_msg() {
    if ((isset($_SESSION['type_msg'])) && (!empty($_SESSION['type_msg']))) {
        unset($_SESSION['type_msg']);
    }
}

function get_type_msg() {

    $message = "";
    if ((isset($_SESSION['type_msg'])) && (!empty($_SESSION['type_msg']))) {
        $message = $_SESSION['type_msg'];
    }
    return $message;
}

function unset_braintree_msg() {
    if ((isset($_SESSION['braintree_msg'])) && (!empty($_SESSION['braintree_msg']))) {
        unset($_SESSION['braintree_msg']);
    }
}

function get_braintree_msg() {

    $message = "";
    if ((isset($_SESSION['braintree_msg'])) && (!empty($_SESSION['braintree_msg']))) {
        $message = $_SESSION['braintree_msg'];
    }
    return $message;
}

function logged_out() {

    $admin_info = logged_in();
    if (!empty($admin_info)) {
        unset($_SESSION['admin_id']);
        unset($_SESSION['username']);
        redirect_to_root();
    }
}

function redirect_to_users() {
    $redirect_to = root_dir() . 'seller.php';
    header('Location: ' . $redirect_to);
}

function redirect_to_roles() {
    $redirect_to = root_dir() . 'roles.php';
    header('Location: ' . $redirect_to);
}

function redirect_to_recent_product() {
    $redirect_to = root_dir() . 'recent_products.php';
    header('Location: ' . $redirect_to);
}

function redirect_to_recent_catalog() {
    $redirect_to = root_dir() . 'catalogos.php';
    header('Location: ' . $redirect_to);
}

function redirect_to_recent_planes() {
    $redirect_to = root_dir() . 'planes.php';
    header('Location: ' . $redirect_to);
}

function redirect_to_recent_product_user() {
    $redirect_to = root_dir() . 'recent_products_user.php';
    header('Location: ' . $redirect_to);
}

function redirect_to_category() {
    $redirect_to = root_dir() . 'categorias.php';
    header('Location: ' . $redirect_to);
}

function redirect_to_subcategory() {
    $redirect_to = root_dir() . 'subcategorias.php';
    header('Location: ' . $redirect_to);
}

function redirect_to_screen() {
    $redirect_to = root_dir() . 'tiendas.php';
    header('Location: ' . $redirect_to);
}

function redirect_to_sucursal() {
    $redirect_to = root_dir() . 'sucursales.php';
    header('Location: ' . $redirect_to);
}

function redirect_to_rubro() {
    $redirect_to = root_dir() . 'rubros.php';
    header('Location: ' . $redirect_to);
}

//VIDEO DESTACADO
function redirect_to_video_destacado() {
    $redirect_to = root_dir() . 'videos-destacados.php';
    header('Location: ' . $redirect_to);
}

function redirect_to_envio() {
    $redirect_to = root_dir() . 'envios.php';
    header('Location: ' . $redirect_to);
}

function redirect_to_restriccion() {
    $redirect_to = root_dir() . 'restricciones.php';
    header('Location: ' . $redirect_to);
}

function redirect_to_slider() {
    $redirect_to = root_dir() . 'slider.php';
    header('Location: ' . $redirect_to);
}

function redirect_to_cliente() {
    $redirect_to = root_dir() . 'clientes.php';
    header('Location: ' . $redirect_to);
}

function redirect_to_info_tecnica_cliente() {
    $redirect_to = root_dir() . 'info_cliente.php';
    header('Location: ' . $redirect_to);
}

function redirect_to_progreso_fisico_cliente() {
    $redirect_to = root_dir() . 'progreso_cliente.php';
    header('Location: ' . $redirect_to);
}

function redirect_to_usuario_rol() {
    $redirect_to = root_dir() . 'usuarios.php';
    header('Location: ' . $redirect_to);
}

function redirect_to_color() {
    $redirect_to = root_dir() . 'colors.php';
    header('Location: ' . $redirect_to);
}

function redirect_to_login() {
    $redirect_to = root_dir() . 'admin-login.php';
    header('Location: ' . $redirect_to);
}

function redirect_to_root() {
    header('Location: ' . root_dir());
}

function redirect_to($location) {
    header('Location: ' . $location);
}

function root_dir() {
    return root_project() . "public/";
}

function private_dir() {
    return root_project() . "private/";
}

function root_project() {
    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $file_dir = explode("/", $actual_link);
    $new_str = str_replace($file_dir[count($file_dir) - 1], "", $actual_link);
    $new_str = str_replace("public/", "", $new_str);
    $new_str = str_replace("private/", "", $new_str);
    return $new_str;
}

function get_directory() {
    $root_out_folder = str_replace(basename(__DIR__), "", dirname(__FILE__));
    $parts = explode('\\', $root_out_folder);
    $index = sizeof($parts) - 2;
    return '/' . $parts[$index] . "/public/";
}

function get_address_error_msg() {
    if (isset($_SESSION['address_errors']) && !empty($_SESSION['address_errors'])) {
        $errors = $_SESSION['address_errors'];
        unset($_SESSION['address_errors']);
        $output = '<ul class="errors"><li><b>El siguiente error ha ocurrido</b></li>';
        foreach ($errors as $error) {
            $output .= '<li>' . $error . '</li>';
        }
        $output .= '</ul>';
        return $output;
    } else
        return '';
}

function get_error_msg() {
    if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
        $errors = $_SESSION['errors'];
        unset($_SESSION['errors']);
        $output = '<ul class="errors"><li><b>El siguiente error ha ocurrido</b></li>';
        foreach ($errors as $error) {
            $output .= '<li>' . $error . '</li>';
        }
        $output .= '</ul>';
        return $output;
    } else
        return '';
}

function get_error_limit_msg() {
    if (isset($_SESSION['errors_limit']) && !empty($_SESSION['errors_limit'])) {
        $errors = $_SESSION['errors_limit'];
        unset($_SESSION['errors_limit']);
        $output = '<ul class="errors"><li><b>El siguiente error ha ocurrido</b></li>';
        foreach ($errors as $error) {
            $output .= '<li>' . $error . '</li>';
        }
        $output .= '</ul>';
        return $output;
    } else
        return '';
}

function trancate_str($string, $size) {
    if (strlen($string) > $size) {
        return substr($string, 0, $size) . "...";
    } else {
        return $string;
    }
}

function is_empty($field_name, $value) {

    return (empty(trim($value))) ? $field_name . " no puede estar vacio " : false;
}

function invalid_email($field_name, $email) {
    //return true;
    return (!filter_var($email, FILTER_VALIDATE_EMAIL)) ? 'Inválido ' . $field_name . '.' : false;
}

function invalid_length($field_name, $passowrd, $length) {
    return (strlen($passowrd) < $length) ? $field_name . ' al menos debe ser ' . $length . ' char largo' : false;
}

function invalid_price_msg($field_name) {
    return 'Por favor ingrese un válido ' . $field_name;
}

function delete_image($image_name, $image_dir) {
    $image_with_dir = $image_dir . $image_name;

    echo $image_with_dir;
    //$image_with_dir;

    if (file_exists($image_with_dir)) {
        unlink($image_with_dir);
    }
}

//Aqui modifique
function dir_recent_product_from_php() {
    return 'uploads/recent-products/';
}

function dir_recent_product() {
    return '../public/uploads/recent-products/';
}

function dir_recent_plan() {
    return '../public/uploads/planes/';
}

function dir_recent_estrategia() {
    return '../public/uploads/estrategias/';
}

function dir_recent_descuento() {
    return '../public/uploads/descuentos/';
}

function product_post_name() {
    return 'product_image';
}

function dir_category() {
    return '../public/uploads/categories/';
}

function dir_setting_logo_user() {
    return '../public/uploads/user-images/';
}

function dir_logo() {
    return '../public/uploads/logos/';
}

function dir_iconos() {
    return '../public/uploads/iconos/';
}

function dir_nosotros() {
    return '../public/uploads/nosotros/';
}

function dir_horario() {
    return '../public/uploads/horarios/';
}

function dir_descuentos() {
    return '../public/uploads/descuentos/';
}

function dir_profesor() {
    return '../public/uploads/profesores/';
}

function dir_subcategory() {
    return '../public/uploads/subcategories/';
}

function dir_adds() {
    return '../public/uploads/adds/';
}

function dir_slider() {
    return '../public/uploads/recent-products/';
}

function dir_clientes() {
    return '../public/uploads/clientes/';
}

function dir_info_tecnica_clientes_rutina() {
    return '../public/uploads/rutinas/';
}

function dir_info_tecnica_clientes_dieta() {
    return '../public/uploads/dietas/';
}

function dir_info_modulo_dieta() {
    return '../public/uploads/dietas/';
}

function dir_info_progreso_clientes() {
    return '../public/uploads/progresos/';
}

function category_post_name() {
    return 'category_image';
}

function pantalla_logo_post_name() {
    return 'tienda_app_logo';
}

function pantalla_icono_post_name() {
    return 'tienda_app_icono';
}
function pantalla_img_nosotros_post_name() {
    return 'tienda_app_nosotros';
}

function pantalla_icono_cat_producto_post_name() {
    return 'tienda_app_icon_cat_producto';
}

function pantalla_icono_cat_servicio_post_name() {
    return 'tienda_app_icon_cat_servicio';
}

function pantalla_icono_cat_membresia_post_name() {
    return 'tienda_app_icon_cat_membresia';
}

function pantalla_icono_cat_ofertas_post_name() {
    return 'tienda_app_icon_cat_ofertas';
}

function pantalla_icono_cat_otros_post_name() {
    return 'tienda_app_icon_cat_otros';
}


function plan_horario_post_name() {
    return 'horario_image';
}

function estrategia_horario_post_name() {
    return 'horario_image';
}

function plan_profesor_post_name() {
    return 'profesor_image';
}

function estrategia_profesor_post_name() {
    return 'profesor_image';
}

function subcategory_post_name() {
    return 'subcategory_image';
}

function adds_post_name() {
    return 'adds_image';
}

function slider_post_name() {
    return 'slider_image';
}
function cliente_post_name() {
    return 'cliente_image';
}

function cliente_rutina_post_name() {
    return 'rutina_image';
}

function cliente_progreso_post_name() {
    return 'progreso_image';
}

function cliente_dieta_post_name() {
    return 'dieta_image';
}

function dieta_post_name() {
    return 'upload';
}

function cliente_progreso_fisico_post_name() {
    return 'progreso_fisico_image';
}


function dir_category_from_php() {
    return 'uploads/categories/';
}

function dir_screen_logo_from_php() {
    return 'uploads/logos/';
}

function dir_screen_icono_from_php() {
    return 'uploads/iconos/';
}

function dir_subcategory_from_php() {
    return 'uploads/subcategories/';
}

function dir_slider_from_php() {
    return 'uploads/recent-products/';
}

function dir_clientes_from_php() {
    return 'uploads/clientes/';
}

function dir_clientes_rutina_from_php() {
    return 'uploads/rutinas/';
}

function dir_progreso_clientes_from_php() {
    return 'uploads/progresos/';
}

function dir_clientes_dieta_from_php() {
    return 'uploads/dietas/';
}

function dir_type() {
    return '../public/uploads/categories/';
}

function type_post_name() {
    return 'type_image';
}

function dir_type_from_php() {
    return 'uploads/categories/';
}

function dir_horario_from_php() {
    return 'uploads/horarios/';
}

function dir_profesor_from_php() {
    return 'uploads/profesores/';
}

function upload_img($no_ext_filename, $target_directory, $post_name) {


    $target_dir = $target_directory;
    // $target_dir = dir_recent_product();
    $current_file = $target_dir . basename($_FILES[$post_name]["name"]);
    $imageFileType = strtolower(pathinfo($current_file, PATHINFO_EXTENSION));
    $file_name = $no_ext_filename . "." . $imageFileType;
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $message = "";


    $check = getimagesize($_FILES[$post_name]["tmp_name"]);
    
    //echo "valor check: " . $check;
    
    if ($check !== false) {
        $message = "El archivo es una imagen - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $message = "El archivo no es una imagen.";
        $uploadOk = 0;
    }

/*
 /*aqui agregue */
    /*if ($no_ext_filename != "") {
        $message = "Cargar un archivo.";
        $uploadOk = 0;
    }*/

    // Check if file already exists
    if (file_exists($target_file)) {
        $message = "Lo sentimos, el archivo ya existe.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES[$post_name]["size"] > 500000) {
        $message = "Lo sentimos, tu archivo es demasiado grande.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $message = "Lo sentimos, solo se permiten archivos JPG, JPEG, PNG y GIF.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $message = "Lo sentimos, tu archivo no fue subido.";
        // if everything is ok, try to upload file
    } else {

        if (move_uploaded_file($_FILES[$post_name]["tmp_name"], $target_file)) {
            // $file_dir = $target_file;
            $message = "El archivo " . $file_name . " ha sido subido";
        } else {
            $message = "Lo sentimos, hubo un error al subir tu archivo.";
        }
    }
    $return_arr = [3];
    $return_arr[0] = $file_name;
    $return_arr[1] = $message;
    $return_arr[2] = $target_file;
    // $return_arr[2] = $file_dir;
    return $return_arr;
}

// PLAN
function set_plan_deletion_msg() {
    $_SESSION['plan_msg'] = "Registro eliminado con éxito.";
}

function redirect_to_plan() {
    $redirect_to = root_dir() . 'planes.php';
    header('Location: ' . $redirect_to);
}

// PLAN
function set_descuento_deletion_msg() {
    $_SESSION['descuento_msg'] = "Registro eliminado con éxito.";
}

function set_estrategia_deletion_msg() {
    $_SESSION['estrategia_msg'] = "Registro eliminado con éxito.";
}

function redirect_to_descuento() {
    $redirect_to = root_dir() . 'descuentos.php';
    header('Location: ' . $redirect_to);
}
function redirect_to_estrategia() {
    $redirect_to = root_dir() . 'estrategia_ventas.php';
    header('Location: ' . $redirect_to);
}

function dir_recent_catalog_from_php() {
    return 'uploads/catalogos/';
}

function dir_recent_plan_from_php() {
    return 'uploads/planes/';
}
function dir_recent_descuentos_from_php() {
    return 'uploads/descuentos/';
}

//Dietas
function get_dietas_msg() {

    $message = "";
    if ((isset($_SESSION['dieta_msg'])) && (!empty($_SESSION['dieta_msg']))) {
        $message = $_SESSION['dieta_msg'];
    }
    return $message;
}

function unset_dieta_msg() {
    if ((isset($_SESSION['dieta_msg'])) && (!empty($_SESSION['dieta_msg']))) {
        unset($_SESSION['dieta_msg']);
    }
}

// DIETA
function set_dieta_deletion_msg() {
    $_SESSION['dieta_msg'] = "Dieta eliminado con éxito.";
}

function redirect_to_dieta() {
    $redirect_to = root_dir() . 'dietas.php';
    header('Location: ' . $redirect_to);
}

?>
