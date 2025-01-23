<?php

require_once('init.php');
date_default_timezone_set("America/Lima");
?>

<?php

/* START OF ORDER */

// NO ELIMINAR
function insert_ordered_products($ordered_products) {
    global $db;
    date_default_timezone_set("America/Lima");
    $hoy = date("Y-m-d H:i:s");

    $sql = "INSERT INTO ordered_products ";
    $sql .= "(product_id, order_id,tipo_categoria,ordered_quantity, date) ";
    $sql .= "VALUES (";
    $sql .= "" . db_escape($db, $ordered_products['product_id']) . ",";
    $sql .= "" . db_escape($db, $ordered_products['order_id']) . ",";
    $sql .= "" . db_escape($db, $ordered_products['tipo_categoria']) . ",";
    $sql .= "" . db_escape($db, $ordered_products['ordered_quantity']) . ",";
    //$sql .= "" . db_escape($db, $ordered_products['product_size_id']) . ",";
//$sql .= "" . db_escape($db, $hoy) . ",";
    $sql .= "'" . db_escape($db, $hoy) . "' ";
    //$sql .= "" . db_escape($db, $ordered_products['product_color_id']) . "";

    $sql .= ")";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}
//NO ELIMINAR
function insert_order($order) {
    global $db;
    date_default_timezone_set("America/Lima");
    $hoy = date("Y-m-d H:i:s");

    $sql = "INSERT INTO orders ";
    $sql .= "(order_method, order_amount,order_costo_envio,order_comision_culqui,order_status, order_user_id,order_client_id,order_time, order_noti,order_sucursal_id,order_distrito) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $order['order_method']) . "',";
    $sql .= "" . db_escape($db, $order['order_amount']) . ",";
    $sql .= "" . db_escape($db, $order['order_costo_envio']) . ",";
    $sql .= "" . db_escape($db, $order['order_comision_culqui']) . ",";
    $sql .= "" . db_escape($db, $order['order_status']) . ",";
    $sql .= "" . db_escape($db, $order['order_user_id']) . ",";
    $sql .= "" . db_escape($db, $order['order_client_id']) . ",";
//$sql .= "'" . db_escape($db, $order['order_time']) . "', ";
    $sql .= "'" . db_escape($db, $hoy) . "', ";
    $sql .= "" . db_escape($db, $order['order_noti']) . ",";
    $sql .= "" . db_escape($db, $order['order_sucursal_id']) . ",";
    $sql .= "'" . db_escape($db, $order['order_distrito']) . "' ";
    $sql .= ")";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function find_orders_by_count() {
    global $db;

    $sql = "SELECT * FROM orders ";
    $sql .= "ORDER BY order_id DESC ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_orders_of_user($user_id) {
    global $db;

    $sql = "SELECT * FROM orders ";
    $sql .= "WHERE order_user_id='" . db_escape($db, $user_id) . "' ";
    $sql .= "ORDER BY order_id DESC";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_orders_by_id($order_id) {
    global $db;

    $sql = "SELECT * FROM orders ";
    $sql .= "WHERE order_id='" . db_escape($db, $order_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $admin; // returns an assoc. array
}

function update_order_status($order) {
    global $db;

    $sql = "UPDATE orders SET ";
    $sql .= "order_status='" . db_escape($db, $order['order_status']) . "' ";
    $sql .= "WHERE order_id='" . db_escape($db, $order['order_id']) . "' ";
    $sql .= "LIMIT 1";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}


// START OF USER
function find_all_users() {
    global $db;

    $sql = "SELECT * FROM users";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_users_by_count($start, $finish) {
    global $db;

    $sql = "SELECT * FROM users WHERE type='1' ";
    $sql .= "ORDER BY user_id DESC ";
    $sql .= "LIMIT " . $start . ", " . $finish;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_sellers_by_count($types) {
    global $db;

    $sql = "SELECT * FROM users where  type='" . $types . "'";
    $sql .= " ORDER BY user_id DESC ";

// echo ($sql);

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function search_tipo_servicio_usuario($id) {
    global $db;

    $sql = "SELECT * FROM users where  user_id='" . $id . "'";
    $sql .= " ORDER BY user_id DESC ";

// echo ($sql);

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

// New return number of notifiacion view
function total_view_noti() {
    global $db;

    $sql = "SELECT * FROM users WHERE type='2' AND view_noti='0'";


// echo ($sql);

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
// $rows = [];
// while($row = mysqli_fetch_assoc($result)){
// 	$rows[] = $row;
// }
    $rows = mysqli_num_rows($result);
    mysqli_free_result($result);
    return $rows;
}

// PEDIDOS NUEVOS para notifacaciones
function total_view_noti_pedidos_new() {
    global $db;

    $sql = "SELECT * FROM orders WHERE view_noti='0'";


// echo ($sql);

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
// $rows = [];
// while($row = mysqli_fetch_assoc($result)){
// 	$rows[] = $row;
// }
    $rows = mysqli_num_rows($result);
    mysqli_free_result($result);
    return $rows;
}

// New return number of notifiacion view
function total_visto_courier_pedidos() {
    global $db;

    $sql = "SELECT * FROM ordered_products WHERE visto = 'no'";


// echo ($sql);

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
// $rows = [];
// while($row = mysqli_fetch_assoc($result)){
// 	$rows[] = $row;
// }
    $rows = mysqli_num_rows($result);
    mysqli_free_result($result);
    return $rows;
}

// para las notificaiocna lcourier
function update_sellers_notif_courier() {
    global $db;

    $sql = "UPDATE ordered_products SET visto='si'";

// echo ($sql);

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
//confirm_result_set($result);
// $rows = [];
// while($row = mysqli_fetch_assoc($result)){
// 	$rows[] = $row;
// }
//$rows = mysqli_num_rows($result);
    mysqli_free_result($result);
//return $rows;
}

function find_user_by_id($user_id) {
    global $db;

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE user_id='" . db_escape($db, $user_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $admin; // returns an assoc. array
}

function find_products_tienda($order_id) {
    global $db;

    $sql = "SELECT DISTINCT p.user_id AS user_id FROM ordered_products AS o, products AS p WHERE o.product_id=p.id ";
    $sql .= "AND o.order_id=" . db_escape($db, $order_id) . "";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function fin_product_tienda_de_orden($order_id, $id_tienda) {

    global $db;

    $sql = "SELECT * FROM ordered_products AS o, products AS p WHERE o.product_id=p.id AND o.order_id='" . db_escape($db, $order_id) . "' ";
    $sql .= "AND p.user_id='" . db_escape($db, $id_tienda) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_products_user_by_id($user_id) {
    global $db;

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE user_id='" . db_escape($db, $user_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $admin; // returns an assoc. array
}

function find_user_by_mail($mail_id) {
    global $db;

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE email='" . db_escape($db, $mail_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $admin; // returns an assoc. array
}

function find_mail_by_id($mail_id) {
    global $db;

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE email='" . $mail_id . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    $num_rows = mysqli_num_rows($result);

    /* confirm_result_set($result);
      $admin = mysqli_fetch_assoc($result);
      mysqli_free_result($result); */
    return $num_rows; // returns an assoc. array
}

function find_address_by_user_id($user_id) {
    global $db;

    $sql = "SELECT * FROM address ";
    $sql .= "WHERE address_id='" . db_escape($db, $user_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $admin; // returns an assoc. array
}

function find_address_by_address_id($address_id) {
    global $db;

    $sql = "SELECT * FROM address ";
    $sql .= "WHERE address_id='" . db_escape($db, $address_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $admin; // returns an assoc. array
}

function user_exists_by_id($user_id) {

    global $db;
    $sql = "SELECT user_id FROM users ";
    $sql .= "WHERE user_id=" . db_escape($db, $user_id) . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $user = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    return ( $user['user_id'] > 0 ) ? true : false;
}

function find_user_by_email($email) {
    global $db;

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE email='" . db_escape($db, $email) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $user = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $user;
}

function find_user_by_username($username) {
    global $db;

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE username='" . db_escape($db, $username) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $user = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $user;
}

function insert_user_social($user) {
    global $db;

    $sql = "INSERT INTO users ";
    $sql .= "(first_name, last_name, username, email, password, image_name, address, user_number,membership) ";

    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $user['first_name']) . "',";
    $sql .= "'" . db_escape($db, $user['last_name']) . "',";
    $sql .= "'" . db_escape($db, $user['username']) . "',";
    $sql .= "'" . db_escape($db, $user['email']) . "',";
    $sql .= "'" . db_escape($db, $user['password']) . "',";
    $sql .= "'" . db_escape($db, $user['image_name']) . "',";
    $sql .= "'" . db_escape($db, $user['address']) . "',";
    $sql .= "'" . db_escape($db, $user['user_number']) . "', ";
    $sql .= "'" . db_escape($db, $user['membership']) . "' ";

    $sql .= ")";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function insert_user($user) {
    global $db;

    $sql = "INSERT INTO users ";
    $sql .= "(first_name, last_name, username, email, password, image_name, address, user_number,membership,department,district,province,mobile,useraddress) ";

    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $user['first_name']) . "',";
    $sql .= "'" . db_escape($db, $user['last_name']) . "',";
    $sql .= "'" . db_escape($db, $user['username']) . "',";
    $sql .= "'" . db_escape($db, $user['email']) . "',";
    $sql .= "'" . db_escape($db, $user['password']) . "',";
    $sql .= "'" . db_escape($db, $user['image_name']) . "',";
    $sql .= "'" . db_escape($db, $user['address']) . "',";
    $sql .= "'" . db_escape($db, $user['number']) . "', ";
    $sql .= "'" . db_escape($db, $user['membership']) . "', ";

    $sql .= "'" . db_escape($db, $user['department']) . "', ";
    $sql .= "'" . db_escape($db, $user['district']) . "', ";
    $sql .= "'" . db_escape($db, $user['province']) . "', ";
    $sql .= "'" . db_escape($db, $user['mobile']) . "', ";
    $sql .= "'" . db_escape($db, $user['useraddress']) . "'";
    $sql .= ")";


    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function insert_user_vender($user) {
    global $db;

    $sql = "INSERT INTO users ";
    $sql .= "(type,accept_terms,first_name, last_name, username, email, password, 
			image_name,membership,user_number,
			dni,ruc,business_name,
			mobile,store,gallery,
			useraddress,number_placed) ";

    $sql .= "VALUES ('2','1',";

    $sql .= "'" . db_escape($db, $user['first_name']) . "',";
    $sql .= "'" . db_escape($db, $user['last_name']) . "',";
    $sql .= "'" . db_escape($db, $user['username']) . "',";
    $sql .= "'" . db_escape($db, $user['email']) . "',";
    $sql .= "'" . db_escape($db, $user['password']) . "',";

    $sql .= "'" . db_escape($db, $user['image_name']) . "',";
    $sql .= "'" . db_escape($db, $user['membership']) . "', ";
    $sql .= "'" . db_escape($db, $user['number']) . "', ";

    $sql .= "'" . db_escape($db, $user['dni']) . "',";
    $sql .= "'" . db_escape($db, $user['ruc']) . "', ";
    $sql .= "'" . db_escape($db, $user['business_name']) . "', ";

    $sql .= "'" . db_escape($db, $user['mobile']) . "', ";
    $sql .= "'" . db_escape($db, $user['store']) . "', ";
    $sql .= "'" . db_escape($db, $user['gallery']) . "', ";

    $sql .= "'" . db_escape($db, $user['useraddress']) . "', ";
    $sql .= "'" . db_escape($db, $user['number_placed']) . "'
		";
    $sql .= ")";


    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function insert_address($address) {
    global $db;

    $sql = "INSERT INTO address ";
    $sql .= "(address_line_1,address_line_2,city,zip_code,state,province,reception_name,country) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $address['address_line_1']) . "',";
    $sql .= "'" . db_escape($db, $address['address_line_2']) . "',";
    $sql .= "'" . db_escape($db, $address['city']) . "',";
    $sql .= "'" . db_escape($db, $address['zip_code']) . "',";
    $sql .= "'" . db_escape($db, $address['state']) . "',";
    $sql .= "'" . db_escape($db, $address['province']) . "',";
    $sql .= "'" . db_escape($db, $address['reception_name']) . "',";
    $sql .= "'" . db_escape($db, $address['country']) . "' ";

    $sql .= ")";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_user($user) {
    global $db;

    $sql = "UPDATE users SET ";
    $sql .= "active=" . db_escape($db, $user['active']) . ", ";
    $sql .= "hash='" . db_escape($db, $user['hash']) . "' ";
    $sql .= "WHERE user_id=" . db_escape($db, $user['user_id']) . " ";
    $sql .= "LIMIT 1";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_user_image($user) {
    global $db;

    $sql = "UPDATE users SET ";
    $sql .= "image_name='" . db_escape($db, $user['image_name']) . "' ";
    $sql .= "WHERE user_id=" . db_escape($db, $user['user_id']) . " ";
    $sql .= "LIMIT 1";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

// Check uses with email
function user_exists($email) {
    global $db;

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE email='" . db_escape($db, $email) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $user = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return ( $user['user_id'] > 0 ) ? true : false;
}

function user_active($email) {
    global $db;

    $sql = "SELECT user_id FROM users ";
    $sql .= "WHERE email='" . db_escape($db, $email) . "' AND active = 1";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $user = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return ( $user['user_id'] > 0 ) ? true : false;
}

function login($email, $password) {

    $user = find_user_by_email($email);
// $password = md5($password);
    $typed_password = $user['password'];

    return ( $typed_password == $password) ? $user : false;
}

// END OF USER
// START OF ADMIN
function admin_login($email, $typed_password) {

    $admin = find_admin_by_email($email);
    $admin_password = $admin['password'];

    return ( $admin_password == $typed_password) ? $admin : false;

//return ( $admin_password == md5($typed_password)) ? $admin : false;
}

// Ahora es por Celular - 04.11.2020
function find_admin_by_email($email) {

    global $db;

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE mobile='" . db_escape($db, $email) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $admin; // returns an assoc. array
}

function find_admin_by_id($user_id) {

    global $db;

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE user_id=" . db_escape($db, $user_id) . " ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $admin; // returns an assoc. array
}

function update_admin_by_id($admin) {
    global $db;
    $sql = "UPDATE users SET ";
    $sql .= "email='" . db_escape($db, $admin['email']) . "', ";


    $sql .= "password='" . db_escape($db, $admin['password']) . "' ";
    $sql .= "WHERE user_id=" . db_escape($db, $admin['user_id']) . " ";
    $sql .= "LIMIT 1";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_admin_address_by_id($admin) {
    global $db;
    $sql = "UPDATE users SET ";
    $sql .= "username='" . db_escape($db, $admin['username']) . "', ";
    $sql .= "first_name='" . db_escape($db, $admin['first_name']) . "', ";
    $sql .= "last_name='" . db_escape($db, $admin['last_name']) . "', ";
    $sql .= "number='" . db_escape($db, $admin['number']) . "', ";
    $sql .= "email='" . db_escape($db, $admin['email']) . "', ";
    $sql .= "address='" . db_escape($db, $admin['address']) . "', ";
    $sql .= "gallery='" . db_escape($db, $admin['gallery']) . "', ";
    $sql .= "address_gallery='" . db_escape($db, $admin['address_gallery']) . "', ";
    $sql .= "store='" . db_escape($db, $admin['store']) . "', ";
    $sql .= "number_store='" . db_escape($db, $admin['number_store']) . "' ";
    $sql .= "WHERE user_id='" . db_escape($db, $admin['user_id']) . "' ";
    $sql .= "LIMIT 1";
//echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_password_by_id($user_id, $new_password) {
    global $db;


    $sql = "UPDATE users SET ";
    $sql .= "password='" . db_escape($db, $new_password) . "' ";
    $sql .= "WHERE user_id='" . db_escape($db, $user_id) . "' ";
    $sql .= "LIMIT 1";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function find_admin_by_username($username) {
    global $db;

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE username='" . db_escape($db, $username) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $admin; // returns an assoc. array
}

// END OF ADMIN
// START OF PRODUCT AREA

function search_products_by_name($searched_textx) {
    global $db;


    $sql = "SELECT  products.*,
	(select gallery from users where user_id=products.user_id) as gallery,
	(select store from users where user_id=products.user_id)  as store,
	(select title from categories where id=products.category)  as categoryname 

	FROM products   ";

//$porciones = explode("/", $searched_textx);
    $searched_textx = trim($searched_textx);

    $porciones = explode("/", $searched_textx);

    $searched = trim($porciones[0]);

    $searched_text = trim($porciones[1]);
    $var_text1 = trim($porciones[2]);
    $var_text2 = trim($porciones[3]);

    $searched0 = explode("-", trim($searched));

    $searched1 = trim($searched0[0]);
    $searched2 = trim($searched0[1]);


    if ($searched2 == "cat") {


        if ($searched_text == "relevantes") {

            $sql .= "  WHERE  category='" . $searched1 . "' order by relevant desc ";
        } elseif ($searched_text == "menoramayor") {

            $sql .= "  WHERE category='" . $searched1 . "' order by price asc ";
        } else if ($searched_text == "mayoramenor") {

            $sql .= "  WHERE category='" . $searched1 . "' order by price desc ";
        } else if ($searched_text == "tallas") {

            $sql .= " WHERE category='" . $searched1 . "' and  products.id in(SELECT product_id FROM `product_inventory` WHERE `size_id`=(SELECT size_id FROM `product_sizes` WHERE `size_name` = '" . $var_text1 . "') group by product_id)";
        } else if ($searched_text == "rangoprecio") {

//$sql.= " (category='". db_escape($db, $searched1) ."') and  price BETWEEN '".$var_text1."' AND '".$var_text2."'  order by price asc ";
            $sql .= "WHERE (category='" . $searched1 . "') and price BETWEEN '" . $var_text1 . "' AND '" . $var_text2 . "' order by price asc";
        } else {

            $sql .= " WHERE category='" . $searched1 . "' AND (`title` LIKE '%" . db_escape($db, $searched_text) . "%' or `brand` LIKE '%" . db_escape($db, $searched_text) . "%') ";
        }
    } else {



        if ($searched_text == "relevantes") {

            $sql .= " WHERE (`title` LIKE '%" . db_escape($db, $searched1) . "%' OR `brand`='" . $searched1 . "')  order by relevant desc ";
        } elseif ($searched_text == "menoramayor") {

            $sql .= " WHERE (`title` LIKE '%" . db_escape($db, $searched1) . "%' OR `brand`='" . $searched1 . "') order by price asc ";
        } else if ($searched_text == "mayoramenor") {

            $sql .= " WHERE (`title` LIKE '%" . db_escape($db, $searched1) . "%' OR `brand`='" . $searched1 . "')  order by price desc ";
        } else if ($searched_text == "tallas") {

            $sql .= " WHERE (`title` LIKE '%" . db_escape($db, $searched1) . "%' OR `brand`='" . $searched1 . "') and  products.id in(SELECT product_id FROM `product_inventory` WHERE `size_id`=(SELECT size_id FROM `product_sizes` WHERE `size_name` = '" . $var_text1 . "') group by product_id)";
        } else if ($searched_text == "rangoprecio") {

            $sql .= " WHERE (`title` LIKE '%" . db_escape($db, $searched1) . "%' OR `brand`='" . $searched1 . "') and  price BETWEEN " . $var_text1 . " AND " . $var_text2 . "  order by price asc ";
        } else {

            $sql .= " WHERE (`title` LIKE '%" . db_escape($db, $searched1) . "%' OR `brand`='" . $searched1 . "' OR palabras_claves LIKE '%" . db_escape($db, $searched1) . "%' ) ";
        }
    }

    /*
      if ($searched_text=="relevantes"){

      $sql.= "  WHERE (`title` LIKE '%". db_escape($db, $searched) ."%')  order by relevant desc ";

      }elseif ($searched_text=="menoramayor"){

      $sql.= "  WHERE (`title` LIKE '%". db_escape($db, $searched) ."%')  order by price asc ";

      }else if ($searched_text=="mayoramenor"){

      $sql.= "  WHERE (`title` LIKE '%". db_escape($db, $searched) ."%')  order by price desc ";

      }else if ($searched_text=="tallas"){

      $sql.= " WHERE (`title` LIKE '%". db_escape($db, $searched) ."%') and  products.id in(SELECT product_id FROM `product_inventory` WHERE `size_id`=(SELECT size_id FROM `product_sizes` WHERE `size_name` = '".$var_text1."') group by product_id)";

      }else if ($searched_text=="rangoprecio"){

      $sql.= "  WHERE (`title` LIKE '%". db_escape($db, $searched) ."%') and  price BETWEEN ".$var_text1." AND ".$var_text2."  order by price asc ";

      }else{

      $sql.= " WHERE (`title` LIKE '%". db_escape($db, $searched) ."%') ";

      }
     */

    $sql .= "  limit 10 ";


    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function search_products_by_name_s($searched_textx) {
    global $db;


    $sql = "";

    $searched_textx = trim($searched_textx);

    $porciones = explode("/", $searched_textx);

///////////////////////////////////////
    $searched = trim($porciones[0]);
    $searched0 = explode("-", trim($searched));

    $searched1 = trim($searched0[0]);
    $searched2 = trim($searched0[1]);
////////////////////////////////////////


    $searched_text = trim($porciones[1]);

    $var_text1 = trim($porciones[2]);
    $var_text2 = trim($porciones[3]);



    if ($searched_text == "store") {

        $sql .= " select user_id,store  from users where store LIKE '%" . db_escape($db, $searched) . "%'  

	order by store desc ";
    } elseif ($searched_text == "gallery") {

        $sql .= " select user_id,gallery  from users where gallery LIKE '%" . db_escape($db, $searched) . "%'  

	order by gallery asc ";
    }





    $sql .= "  limit 10 ";




    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function list_store_gallery_id($searched) {
    global $db;

    $sql = "SELECT user_id,store,gallery,image_name from users where `type` = '2' and gallery LIKE '%" . db_escape($db, $searched) . "%' order by gallery asc ";

    $sql .= "  limit 10 ";

    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function search_products_by_name_new($searched_textx) {
    global $db;


    $sql = "SELECT  products.*,
	(select gallery from users where user_id=products.user_id) as gallery,
	(select store from users where user_id=products.user_id)  as store,
	(select title from categories where id=products.category)  as categoryname 

	FROM products   ";


    $searched_textx = trim($searched_textx);

    $porciones = explode("/", $searched_textx);

///////////////////////////////////////
    $searched = trim($porciones[0]);
    $searched0 = explode("-", trim($searched));

    $searched1 = trim($searched0[0]);
    $searched2 = trim($searched0[1]);
////////////////////////////////////////


    $searched_text = trim($porciones[1]);

    $var_text1 = trim($porciones[2]);
    $var_text2 = trim($porciones[3]);

//$var_text3=trim($porciones[4]);




    if ($searched_text == "store") {

        $sql .= " WHERE user_id = '" . db_escape($db, $searched) . "' 	order by relevant desc ";
    } elseif ($searched_text == "gallery") {

        $sql .= " WHERE user_id = '" . db_escape($db, $searched) . "'	order by relevant desc ";
    }





    $sql .= "  limit 10 ";




    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function search_products_by_name_all($searched_text) {
    global $db;

    $sql = "SELECT  products.*,
	(select gallery from users where user_id=products.user_id) as gallery,
	(select store from users where user_id=products.user_id)  as store,
	(select title from categories where id=products.category)  as categoryname FROM products ";
    $sql .= "WHERE (`title` LIKE '%" . db_escape($db, $searched_text) . "%') ";
    $sql .= "OR (`description` LIKE '%" . db_escape($db, $searched_text) . "%') ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function insert_product($product) {
    global $db;

//
    $sql = "INSERT INTO products ";
    $sql .= "(title,category,description,marca,link_video_one,link_video_two,purchase_price,price,previous_price,
			date,sort,image_name,user_id,weight,back_width,longs,long_sleeve,breast_contour,waist,hip,status,brand, fotos_talla, palabras_claves,tipo_producto,fecha_inicio,fecha_fin,descuento,qty,promocion,id_product_size,horario,horario_foto,profesor,profesor_foto) ";
    $sql .= "VALUES (";

    $totales = $product['price'];
//$ptotales = $product['previous_price'];

    if (isset($product['previous_price'])) {
        $previousPrice = $product['previous_price'];
    } else {
        $previousPrice = 0;
    }

    if (isset($product['longs'])) {
        $longs = $product['longs'];
    } else {
        $longs = 0;
    }

    if (isset($product['long_sleeve'])) {
        $long_sleeve = $product['long_sleeve'];
    } else {
        $long_sleeve = 0;
    }

    if (isset($product['marca'])) {
        $prod_marca = $product['marca'];
    } else {
        $prod_marca = "";
    }

    if (isset($product['link_video_one'])) {
        $link_video_1 = $product['link_video_one'];
    } else {
        $link_video_1 = "";
    }
    if (isset($product['link_video_two'])) {
        $link_video_2 = $product['link_video_two'];
    } else {
        $link_video_2 = "";
    }



    if (isset($product['breast_contour'])) {
        $breast_contour = $product['breast_contour'];
    } else {
        $breast_contour = 0;
    }


    if (isset($product['waist'])) {
        $waist = $product['waist'];
    } else {
        $waist = 0;
    }

    if (isset($product['hip'])) {
        $hip = $product['hip'];
    } else {
        $hip = 0;
    }

    if (isset($product['tipo_producto'])) {
        $tipo_prod = $product['tipo_producto'];
    } else {
        $product['tipo_producto'] = 0;
    }

    if (isset($product['id_product_size'])) {
        $tamaño = $product['id_product_size'];
    } else {
        $product['id_product_size'] = 0;
    }

    if (isset($product['fecha_inicio'])) {
        $fecha_inicio = $product['fecha_inicio'];
    } else {
        $product['fecha_inicio'] = "";
    }

    if (isset($product['fecha_fin'])) {
        $fecha_inicio = $product['fecha_fin'];
    } else {
        $product['fecha_fin'] = "";
    }

    if (isset($product['qty'])) {
        $qty = $product['qty'];
    } else {
        $qty = 0;
    }

    if (isset($product['descuento'])) {
        $descuento = $product['descuento'];
    } else {
        $descuento = 0;
    }

    if (isset($product['description'])) {
        $descripcion = $product['description'];
    } else {
        $product['description'] = "";
    }

    if (isset($product['promocion'])) {
        $promocion = $product['promocion'];
    } else {
        $product['promocion'] = "";
    }

    /* if (isset($product['horario_image'])) {
      $horario_foto = $product['horario_image'];
      } else {
      $product['horario_image'] = "";
      }

      if (isset($product['profesor_image'])) {
      $profesor_foto = $product['profesor_image'];
      } else {
      $product['profesor_image'] = "";
      } */
    if (empty($product['horario_image']))
        $product['horario_image'] = "";

    if (empty($product['profesor_image']))
        $product['profesor_image'] = "";



    $sql .= "'" . db_escape($db, $product['title']) . "',";
    $sql .= "" . db_escape($db, $product['category']) . ",";
    $sql .= "'" . db_escape($db, $product['description']) . "',";
    $sql .= "'" . db_escape($db, $prod_marca) . "',";
    $sql .= "'" . db_escape($db, $link_video_1) . "',";
    $sql .= "'" . db_escape($db, $link_video_2) . "',";
    $sql .= "" . db_escape($db, $product['purchase_price']) . ",";
    $sql .= "" . db_escape($db, $totales) . ",";
    $sql .= "" . db_escape($db, $previousPrice) . ","; //Precio con descuento
    $sql .= "'" . db_escape($db, $product['date']) . "',";
    $sql .= "" . db_escape($db, $product['sort']) . ",";
    $sql .= "'" . db_escape($db, $product['image_name']) . "', ";
    $sql .= "'" . db_escape($db, $product['user_id']) . "', ";
    $sql .= "" . db_escape($db, $product['weight']) . ",";
    $sql .= "" . db_escape($db, $product['back_width']) . ",";
    $sql .= "" . db_escape($db, $product['longs']) . ",";
    $sql .= "'" . db_escape($db, $product['long_sleeve']) . "',";
    $sql .= "'" . db_escape($db, $product['breast_contour']) . "', ";
    $sql .= "'" . db_escape($db, $product['waist']) . "', ";
    $sql .= "" . db_escape($db, $product['hip']) . ",";
    $sql .= "'" . db_escape($db, $product['statu']) . "', ";
    $sql .= "'" . db_escape($db, $product['brand']) . "', ";
// new
    $sql .= "'" . db_escape($db, $product['fotos_talla']) . "', ";
    $sql .= "'" . db_escape($db, $product['palabras_claves']) . "' , ";
    $sql .= "'" . db_escape($db, $product['tipo_producto']) . "' , ";
    $sql .= "'" . db_escape($db, $product['fecha_inicio']) . "' , ";
    $sql .= "'" . db_escape($db, $product['fecha_fin']) . "' , ";
    $sql .= "'" . db_escape($db, $product['descuento']) . "' , ";
    $sql .= "'" . db_escape($db, $product['qty']) . "' , ";
    $sql .= "'" . db_escape($db, $product['promocion']) . "' , ";
    $sql .= "'" . db_escape($db, $product['id_product_size']) . "' , ";
    $sql .= "'" . db_escape($db, $product['horario']) . "' , ";
    $sql .= "'" . db_escape($db, $product['horario_image']) . "' , ";
    $sql .= "'" . db_escape($db, $product['profesor']) . "' , ";
    $sql .= "'" . db_escape($db, $product['profesor_image']) . "'  ";
    $sql .= ")";


    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function product_exists_by_id($product_id) {

    global $db;
    $sql = "SELECT id FROM products ";
    $sql .= "WHERE id=" . db_escape($db, $product_id) . " ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $product = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    if (!empty($product))
        return true;
    else
        return false;
}

function find_products_by_count($start, $count) {
    global $db;

    $sql = "SELECT * FROM products ";
    $sql .= "ORDER BY id DESC ";
    $sql .= "LIMIT " . $start . ", " . $count . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function traer_todo_productos() {
    global $db;

    $sql = "SELECT * FROM products ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function actualizar_productos_comision($id, $comision, $nuevo_precio) {
    global $db;

    $sql = "UPDATE products SET ";
    $sql .= "price='" . db_escape($db, $nuevo_precio) . "', ";
    $sql .= "previous_price='" . db_escape($db, $comision) . "' ";
    $sql .= "WHERE  id='" . db_escape($db, $id) . "'";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function find_products_by_count_system($types, $filtro, $start, $count, $user_id) {


    if ($types == 1) {
        $where = " and user_id in (select user_id from users where store like '%" . $filtro . "%' order by store asc) ";
        $orderx = " id DESC";
    } else if ($types == 2) {
//echo "entro";
//$where = " and user_id in (select user_id from users where gallery like '%" . $filtro . "%' order by gallery asc) ";
//$where = " and user_id in (select user_id from users where type = 2 and gallery like '%" . $filtro . "%' order by gallery asc) ";
        $where = " and user_id in (select user_id from users where user_id = '" . $user_id . "' and gallery like '%" . $filtro . "%' order by gallery asc) ";
        $orderx = " id DESC";
    } else if ($types == 3) {
        $where = " ";
        $orderx = " outstanding asc";
    } else {

        $where = " ";
        $orderx = " id DESC ";
    }

    global $db;

    $sql = "SELECT * FROM products where id >=1 $where ";
    $sql .= "ORDER BY $orderx ";
//	$sql .= "LIMIT " . $start. ", " . $count . " ";
//echo  $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_type_user($user_id) {
    global $db;

    $sql = "SELECT * FROM users ";
//$sql .= " where type='$user_id' ";
    $sql .= " WHERE user_id = $user_id ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    if ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_products_by_count_user($user_id) {
    global $db;

    $sql = "SELECT * FROM products ";
    $sql .= " where  user_id='$user_id'    ORDER BY id DESC ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_all_products() {
    global $db;

    $sql = "SELECT products.*,
		(select gallery from users where user_id=products.user_id) as gallery,
		(select store from users where user_id=products.user_id)  as store,
		(select title from categories where id=products.category)  as categoryname
		FROM products where outstanding=2 ORDER BY outstanding DESC,id DESC"; /**/


    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}



function find_product_by_id($product_id) {
    global $db;

    $sql = "SELECT products.*,
		(select gallery from users where user_id=products.user_id) as gallery,
		(select store from users where user_id=products.user_id)  as store,
		(select title from categories where id=products.category)  as categoryname,
		(select tipo_tabla from categories where id=products.category)  as tipotabla
		FROM products 

		WHERE id='" . db_escape($db, $product_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $product = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $product; // returns an assoc. array
}

function find_ordered_products_by_id($product_id) {
    global $db;

    $sql = "SELECT ordered_products.*,products.* FROM ordered_products,products 

		WHERE 

		products.id=ordered_products.product_id  

and ordered_id='" . db_escape($db, $product_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $product = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $product; // returns an assoc. array
}

function find_seller_by_id($product_id) {
    global $db;

    $sql = "SELECT products.*,
		(select gallery from users where user_id=products.user_id) as gallery,
		(select store from users where user_id=products.user_id)  as store,
		(select title from categories where id=products.category)  as categoryname
		FROM products 

		WHERE id='" . db_escape($db, $product_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $product = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $product; // returns an assoc. array
}

function find_order_by_id($order_id) {
    global $db;
    $sql = "SELECT orders.*,
		(SELECT first_name  FROM users WHERE  user_id=orders.order_user_id) as cliente,
	(SELECT city  FROM address WHERE  address_id= (SELECT address FROM users WHERE user_id= orders.order_user_id )) as district
		FROM orders 
		WHERE order_id='" . db_escape($db, $order_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $product = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $product; // returns an assoc. array
}

function find_order_by_idd($order_id) {
    global $db;
    $sql = "SELECT orders.*,
		(SELECT first_name FROM users WHERE  user_id=orders.order_user_id) as propietario,
	(SELECT nombres  FROM clientes WHERE id = orders.order_client_id)as cliente
		FROM orders 
		WHERE order_id='" . db_escape($db, $order_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $product = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $product; // returns an assoc. array
}

function find_order_by_id_admi($order_id) {
    global $db;

    $sql = "SELECT o.* , u.store, u.gallery, count(o.order_id) as count FROM orders o INNER JOIN ordered_products op ON o.order_id = op.order_id  INNER JOIN products p ON op.product_id=p.id INNER JOIN users u ON p.user_id = u.user_id   WHERE o.order_id='$order_id' GROUP BY o.order_id";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $product = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $product; // returns an assoc. array
}

function find_product_list_by_id($product_id) {
    global $db;

    $sql = "SELECT products.*,
		(select gallery from users where user_id=products.user_id) as gallery,
		(select store from users where user_id=products.user_id)  as store,
		(select title from categories where id=products.category)  as categoryname
		FROM products 

		WHERE id='" . db_escape($db, $product_id) . "' ";


    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $product = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $product; // returns an assoc. array
}

function get_products_by_category($category) {
    global $db;

    $sql = "SELECT products.*,
		(select gallery from users where user_id=products.user_id) as gallery,
		(select store from users where user_id=products.user_id)  as store,
		(select title from categories where id=products.category)  as categoryname
		FROM products ";
    $sql .= "WHERE category='" . db_escape($db, $category) . "' ";
    $sql .= "ORDER BY id DESC";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function update_product($product) {
    global $db;

    $sqlp = "SELECT COUNT(id) FROM products where id='" . db_escape($db, $product['id']) . "' 
		and price='" . db_escape($db, $product['price']) . "'";

    $resultp = mysqli_query($db, $sqlp);
    $count_p = mysqli_fetch_array($resultp);
    mysqli_free_result($resultp);

    $num_filap = $count_p[0];



    $sqlpp = "SELECT COUNT(id) FROM products where id='" . db_escape($db, $product['id']) . "' 
		and previous_price='" . db_escape($db, $product['previous_price']) . "'";

    $resultpp = mysqli_query($db, $sqlpp);
    $count_pp = mysqli_fetch_array($resultpp);
    mysqli_free_result($resultpp);

    $num_filapp = $count_pp[0];

    if (isset($product['link_video_one'])) {
        $link_video_1 = $product['link_video_one'];
    } else {
        $link_video_1 = "";
    }

    if (isset($product['link_video_two'])) {
        $link_video_2 = $product['link_video_two'];
    } else {
        $link_video_2 = "";
    }

    $sql = "UPDATE products SET ";
    $sql .= "title='" . db_escape($db, $product['title']) . "', ";
    $sql .= "category='" . db_escape($db, $product['category']) . "', ";
    $sql .= "description='" . db_escape($db, $product['description']) . "', ";
    $sql .= "marca='" . db_escape($db, $product['marca']) . "', ";
    $sql .= "link_video_one='" . db_escape($db, $link_video_1) . "', ";
    $sql .= "link_video_two='" . db_escape($db, $link_video_2) . "', ";
    $sql .= "descuento='" . db_escape($db, $product['descuento']) . "', ";
//$sql .= "precio='" . db_escape($db, $product['purchase_price']) . "', ";
    $sql .= "qty='" . db_escape($db, $product['qty']) . "', ";
    $sql .= "tipo_producto='" . db_escape($db, $product['tipo_producto']) . "', ";
    $sql .= "fecha_inicio='" . db_escape($db, $product['inicio']) . "', ";
    $sql .= "fecha_fin='" . db_escape($db, $product['fin']) . "', ";
    $sql .= "id_product_size='" . db_escape($db, $product['id_product_size']) . "', ";
    $sql .= "promocion='" . db_escape($db, $product['promocion']) . "', ";

    $sql .= "horario='" . db_escape($db, $product['horario']) . "', ";
    $sql .= "horario_foto='" . db_escape($db, $product['horario_image']) . "', ";
    $sql .= "profesor='" . db_escape($db, $product['profesor']) . "', ";
    $sql .= "profesor_foto='" . db_escape($db, $product['profesor_image']) . "', ";

// Verifiso si actualizo foto talla
    if (!empty($product['fotos_talla'])) {
        $sql .= "fotos_talla='" . db_escape($db, $product['fotos_talla']) . "', ";
    }

    if ($num_filapp == 0) {

        $previous_price = $product['previous_price'];

        $sql .= "previous_price='" . db_escape($db, $previous_price) . "', ";
    }


    if ($num_filap == 0) {

        $price = $product['price'];

        $sql .= "price='" . db_escape($db, $price) . "', ";
    }

// $sql .= "image_name='".db_escape($db, $product['image_name'])."', ";
    $sql .= "sort='" . db_escape($db, $product['sort']) . "', ";

    $sql .= "weight='" . db_escape($db, $product['weight']) . "', ";
    $sql .= "longs='" . db_escape($db, $product['longs']) . "', ";
    $sql .= "long_sleeve='" . db_escape($db, $product['long_sleeve']) . "', ";
    $sql .= "back_width='" . db_escape($db, $product['back_width']) . "', ";
    $sql .= "breast_contour='" . db_escape($db, $product['breast_contour']) . "', ";
    $sql .= "waist='" . db_escape($db, $product['waist']) . "', ";
    $sql .= "hip='" . db_escape($db, $product['hip']) . "', ";
    $sql .= "status='" . db_escape($db, $product['statu']) . "', ";
    $sql .= "brand='" . db_escape($db, $product['brand']) . "' ";

    $sql .= "WHERE id='" . db_escape($db, $product['id']) . "' ";
    $sql .= "LIMIT 1";
//echo$sql;
    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function insert_product_images($product_images) {
    global $db;

    $sql = "INSERT INTO product_images ";
    $sql .= "(image_name, color_id, product_id) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $product_images['image_name']) . "',";
    $sql .= "'" . db_escape($db, $product_images['id_color']) . "',";
    $sql .= "" . db_escape($db, $product_images['product_id']) . "";
    $sql .= ")";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_product_images($product_images) {
    global $db;
    if ($product_images['image_name'] == "") {
        $sql = "UPDATE product_images ";
        $sql .= "SET ";
        $sql .= "color_id ='" . db_escape($db, $product_images['id_color']) . "'";
        $sql .= " WHERE id =" . db_escape($db, $product_images['id_imagen']) . "";
    } else {
        $sql = "UPDATE product_images ";
        $sql .= "SET ";
        $sql .= "image_name ='" . db_escape($db, $product_images['image_name']) . "', ";
        $sql .= "color_id ='" . db_escape($db, $product_images['id_color']) . "'";
        $sql .= " WHERE id =" . db_escape($db, $product_images['id_imagen']) . "";
    }

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function get_images_by_product_id($product_id) {
    global $db;

    $sql = "SELECT * FROM product_images ";
    $sql .= "LEFT JOIN colors on product_images.color_id = colors.color_id ";
    $sql .= "WHERE product_id=" . db_escape($db, $product_id) . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_color_images_by_product_id($product_id) {
    global $db;

    $sql = "SELECT * FROM product_images AS p, colors AS c ";
    $sql .= "WHERE p.color_id=c.color_id AND p.product_id=" . db_escape($db, $product_id) . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_all_images() {
    global $db;

    $sql = "SELECT * FROM product_images ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

// END OF PRODUCT IMAGE
// START OF CATEGORY AREA
function insert_category($category) {
    global $db;

    $sql = "INSERT INTO categories ";
    $sql .= "(title,alias,sort, image_name,id_rubro,types,status,tipo_tabla) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $category['title']) . "',";
    $sql .= "'" . db_escape($db, $category['alias']) . "',";
    $sql .= "" . db_escape($db, $category['sort']) . ",";
    $sql .= "'" . db_escape($db, $category['image_name']) . "',";
    $sql .= "'" . db_escape($db, $category['rubro']) . "',";
//$sql .= "'" . db_escape($db, $category['user_id']) . "',";
    $sql .= "'" . db_escape($db, $category['type']) . "',";
    $sql .= "'" . db_escape($db, $category['statu']) . "',";
    $sql .= "'" . db_escape($db, $category['tabla_tallas']) . "'";
    $sql .= ")";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

// START OF CATEGORY AREA
function insert_slider($slider) {
    global $db;

    $sql = "INSERT INTO slider ";
    $sql .= "(id_user,title, sort, image_name,status) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $slider['id_user']) . "',";
    $sql .= "'" . db_escape($db, $slider['title']) . "',";
    $sql .= "" . db_escape($db, $slider['sort']) . ",";
    $sql .= "'" . db_escape($db, $slider['image_name']) . "',";
    $sql .= "'" . db_escape($db, $slider['statu']) . "'";
    $sql .= ")";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function find_all_categories() {
    global $db;

    $sql = "SELECT * FROM categories ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_categories_by_rubro_title($rubro_id) {
    global $db;

    $sql = "SELECT * FROM `categories` WHERE id_rubro = " . db_escape($db, $rubro_id) . " AND title = 'productos';  ";

//$sql .= "WHERE p.color_id=c.color_id AND p.product_id=" . db_escape($db, $product_id) . " ";
//echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_all_join_categories() {
    global $db;

    $sql = "SELECT c.id,c.title,c.alias,c.image_name,c.id_rubro,c.id_user_store,r.descripcion as rubro,c.status FROM categories c LEFT JOIN rubro r ON c.id_rubro = r.id";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_all_categories_types() {
    global $db;

    $sql = "SELECT c.id,c.title as categorie, t.title FROM categories c LEFT JOIN types t ON c.types = t.id";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    $res = [];
    foreach ($rows as $key) {
        $cat = $key['id'];
        $sql = "SELECT p.* FROM products p  Where p.category = $cat LIMIT 4";
        mysqli_set_charset($db, "utf8");
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $rows2 = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows2[] = $row;
        }
        $aux = ['id_category' => $key['id'],
            'categorie' => $key['categorie'],
            'title' => $key['title'],
            'products' => $rows2];
        array_push($res, $aux);
    }

    mysqli_free_result($result);
    return $res;
}

/*
  function find_all_slider() {
  global $db;

  $sql = "SELECT * FROM slider";

  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $rows = [];
  while($row = mysqli_fetch_assoc($result)){
  $rows[] = $row;
  }
  mysqli_free_result($result);
  return $rows;

  }
 */

function get_categoria_id_type($id_type) {
    global $db;

    $sql = "SELECT * FROM categories WHERE types='" . $id_type . "'";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_categoria_id_rubro($id_rubro) {
    global $db;

    $sql = "SELECT * FROM categories WHERE id_rubro='" . $id_rubro . "'";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_subcategoria_id_rubro($id_rubro) {
    global $db;

    $sql = "SELECT sub.id,sub.id_categoria as id_categoria,sub.nombre,sub.alias,cat.id,cat.id_rubro,cat.title,rub.id,rub.descripcion ";
    $sql .= "FROM `subcategorias` sub ";
    $sql .= "LEFT JOIN categories cat on sub.id_categoria = cat.id ";
    $sql .= "LEFT JOIN rubro rub on cat.id_rubro = rub.id ";
    $sql .= "WHERE rub.id=" . db_escape($db, $id_rubro) . " ";

//    echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_subcategoria_id_rubro_category($id_categoria) {
    global $db;

    $sql = "SELECT sub.id,sub.id_categoria as id_categoria,sub.nombre,sub.alias,cat.id,cat.id_rubro,cat.title,rub.id,rub.descripcion as descripcion ";
    $sql .= "FROM `subcategorias` sub ";
    $sql .= "LEFT OUTER JOIN categories cat on sub.id_categoria = cat.id ";
    $sql .= "LEFT OUTER JOIN rubro rub on cat.id_rubro = rub.id ";
    $sql .= "WHERE id_categoria=" . db_escape($db, $id_categoria) . " ";

//    echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $category = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $category; // returns an assoc. array
}

function buscar_categoria_por_id($id_categoria) {
    global $db;

    $sql = "SELECT c.id , c.title , c.id_rubro,rub.descripcion as descripcion ";
    $sql .= "FROM categories as c ";
    $sql .= "LEFT JOIN rubro as rub on c.id_rubro = rub.id ";
    $sql .= "WHERE c.id=" . db_escape($db, $id_categoria) . " ";

//echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $category = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $category; // returns an assoc. array
}

function find_all_categories_type($id_type) {
    global $db;

    $sql = "SELECT cat.id, cat.title, cat.sort, cat.image_name, cat.types, cat.status, 
(SELECT count(*) from products WHERE category= cat.id AND status=1) as count
FROM categories cat
 where cat.types='" . $id_type . "'";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_all_types() {
    global $db;

    $sql = "SELECT * FROM types";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_all_slider() {
    global $db;

    $sql = "SELECT * FROM slider ";

    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_all_settings() {
    global $db;

    $sql = "SELECT politicas FROM settings where setting_id='1'";

    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_all_settings_store($admin_id) {
    global $db;

//$sql = "SELECT politicas FROM settings where setting_id='1'";
    $sql = "SELECT * FROM settings where admin_id='" . db_escape($db, $admin_id) . "'";

    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_all_culqi() {
    global $db;

    $sql = "SELECT culqi_title,culqi_authorization,culqi_publickey FROM settings where setting_id='1'";

    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_culqi_id($product_id) {
    global $db;


    $sql = "SELECT culqi_title,culqi_authorization,culqi_publickey FROM settings where setting_id='" . db_escape($db, $product_id) . "'";



    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $color = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $color; // returns an assoc. array
}

// START OF type AREA
function insert_type($type) {
    global $db;

    $sql = "INSERT INTO types ";
    $sql .= "(title, sort, image_name) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $type['title']) . "',";
    $sql .= "" . db_escape($db, $type['sort']) . ",";
    $sql .= "'" . db_escape($db, $type['image_name']) . "'";
    $sql .= ")";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function find_type_by_id($type_id) {
    global $db;

    $sql = "SELECT * FROM types ";
    $sql .= "WHERE id='" . db_escape($db, $type_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $type = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $type; // returns an assoc. array
}

function update_type($type) {
    global $db;

    $sql = "UPDATE types SET ";
    $sql .= "title='" . db_escape($db, $type['title']) . "', ";
    $sql .= "image_name='" . db_escape($db, $type['image_name']) . "', ";
    $sql .= "sort=" . db_escape($db, $type['sort']) . " ";
    $sql .= "WHERE id=" . db_escape($db, $type['id']) . " ";
    $sql .= "LIMIT 1";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function find_all_status() {
    global $db;

    $sql = "SELECT * FROM status";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_all_address() {
    global $db;

    $sql = "SELECT * FROM address";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_category_by_id($category_id) {
    global $db;

    $sql = "SELECT * FROM categories ";
    $sql .= "WHERE id='" . db_escape($db, $category_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $category = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $category; // returns an assoc. array
}

function find_category_by_id_rubro($rubro_id) {
    global $db;

    $sql = "SELECT * FROM categories ";
    $sql .= "WHERE id_rubro='" . db_escape($db, $rubro_id) . "' AND title = 'productos' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $category = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $category; // returns an assoc. array
}

function find_adds_by_id($adds_id) {
    global $db;

    $sql = "SELECT * FROM anuncios ";
    $sql .= "WHERE id_anuncio='" . db_escape($db, $adds_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $adds = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $adds; // returns an assoc. array
}

function find_slider_by_id($slider_id) {
    global $db;

    $sql = "SELECT * FROM slider ";
    $sql .= "WHERE id='" . db_escape($db, $slider_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $slider = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $slider; // returns an assoc. array
}

function find_slider_by_usuario($id_user) {
    global $db;

    $sql = "SELECT * FROM slider ";
    $sql .= "WHERE id_user='" . db_escape($db, $id_user) . "' ";

    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function update_adds($adds) {
    global $db;

    $sql = "UPDATE anuncios SET ";
    $sql .= "titulo='" . db_escape($db, $adds['title']) . "', ";
    if (isset($adds['image_name'])) {
        $sql .= "url_foto='" . db_escape($db, $adds['image_name']) . "', ";
    }

    $sql .= "descripcion='" . db_escape($db, $adds['description']) . "', ";
    $sql .= "tipo_anuncio='" . db_escape($db, $adds['type']) . "', ";
    $sql .= "fecha_registro='" . db_escape($db, $adds['fecha_registro']) . "', ";
    $sql .= "fecha_expira='" . db_escape($db, $adds['fecha_expira']) . "', ";
    $sql .= "RazonSocial='" . db_escape($db, $adds['RazonSocial']) . "', ";
    $sql .= "Celular=" . db_escape($db, $adds['Celular']) . ", ";
    $sql .= "Correo='" . db_escape($db, $adds['Correo']) . "', ";
    $sql .= "Contacto='" . db_escape($db, $adds['Contacto']) . "' ";
    $sql .= "WHERE id_anuncio=" . db_escape($db, $adds['adds_id']) . " ";
    $sql .= "LIMIT 1";


    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_category($category) {
    global $db;

    $sql = "UPDATE categories SET ";
    $sql .= "title='" . db_escape($db, $category['title']) . "', ";
    $sql .= "alias='" . db_escape($db, $category['alias']) . "', ";
    $sql .= "image_name='" . db_escape($db, $category['image_name']) . "', ";
    $sql .= "id_rubro='" . db_escape($db, $category['rubro']) . "', ";
//$sql .= "id_user_store='" . db_escape($db, $category['user_id']) . "', ";
    $sql .= "types='" . db_escape($db, $category['type']) . "', ";
    $sql .= "status='" . db_escape($db, $category['statu']) . "', ";
    $sql .= "sort=" . db_escape($db, $category['sort']) . ", ";
    $sql .= "tipo_tabla=" . db_escape($db, $category['tabla_tallas']) . " ";
    $sql .= "WHERE id=" . db_escape($db, $category['id']) . " ";
    $sql .= "LIMIT 1";


    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

// END OF CATEGORY AREA


function update_slider($slider) {
    global $db;

    $sql = "UPDATE slider SET ";
    $sql .= "title='" . db_escape($db, $slider['title']) . "', ";
    $sql .= "image_name='" . db_escape($db, $slider['image_name']) . "', ";
    $sql .= "status='" . db_escape($db, $slider['statu']) . "', ";
    $sql .= "sort=" . db_escape($db, $slider['sort']) . " ";
    $sql .= "WHERE id=" . db_escape($db, $slider['id']) . " ";
    $sql .= "LIMIT 1";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

// END OF CATEGORY AREA
// START OF AVAILABLE PRODUCT COLOR
function get_inventory_by_product_id($product_id) {
    global $db;

    $sql = "SELECT s.size_name,p.available_qty,p.inventory_id,p.color_id,p.size_id,c.color_name FROM product_inventory AS p, product_sizes AS s, colors AS c  
		WHERE s.size_id=p.size_id AND c.color_id=p.color_id AND p.product_id=" . db_escape($db, $product_id) . " 
		";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function delete_medidas($id_medida) {
    global $db;

    $sql = "DELETE FROM product_sizes_2 ";
    $sql .= "WHERE id_zize=" . db_escape($db, $id_medida) . "";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
}

function medidas_product_by_id($product_id) {
    global $db;

    $sql = "SELECT * FROM product_sizes_2 AS p, product_sizes AS s WHERE p.size=s.size_id AND p.product_id=" . db_escape($db, $product_id) . " 
		 ORDER BY `p`.`id_zize` ASC";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

// START OF AVAILABLE PRODUCT COLOR
/* 	function get_product_id($product_id){
  global $db;


  $sql = "SELECT store,gallery
  FROM products, users
  WHERE products.user_id=users.user_id and  products.id='" . db_escape($db, $product_id) . "'
  ";


  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $rows = [];
  while($row = mysqli_fetch_assoc($result)){
  $rows[] = $row;
  }
  mysqli_free_result($result);
  return $rows;

  }
 */


function get_product_id($product_id) {
    global $db;

    $sql = "SELECT weight,longs,long_sleeve,back_width,breast_contour,waist,hip,brand,store,gallery,additional,politics, products.user_id as user_id
		FROM products, users 
		WHERE products.user_id=users.user_id and  products.id='" . db_escape($db, $product_id) . "' 
		";

    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $color = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $color; // returns an assoc. array
}

function get_inventory_by_id($inventory_id) {
    global $db;

    $sql = "SELECT * FROM product_inventory ";
    $sql .= "WHERE inventory_id=" . db_escape($db, $inventory_id) . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $color = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $color; // returns an assoc. array
}

function get_product_by_id($id) {
    global $db;

    $sql = "SELECT products.*,
		(select email from users where user_id=products.user_id) as email
		 FROM products ";
    $sql .= "WHERE id=" . db_escape($db, $id) . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $color = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $color; // returns an assoc. array
}

function insert_available_inventory($product_color_qty) {
    global $db;

    $sql = "INSERT INTO product_inventory ";
    $sql .= "(color_id, size_id, product_id, available_qty) ";
    $sql .= "VALUES (";
    $sql .= "" . db_escape($db, $product_color_qty['color_id']) . ", ";
    $sql .= "" . db_escape($db, $product_color_qty['size_id']) . ", ";
    $sql .= "" . db_escape($db, $product_color_qty['product_id']) . ", ";
    $sql .= "" . db_escape($db, $product_color_qty['available_qty']) . "";
    $sql .= ")";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function insert_sizes_product($id, $sizes, $medidasX, $medidasY, $medidasZ) {
    global $db;
    $sql = "INSERT INTO product_sizes_2 ";
    $sql .= "(product_id, medidax, mediday, medidaz, size) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $id) . "',";
    $sql .= "'" . db_escape($db, $medidasX) . "',";
    $sql .= "'" . db_escape($db, $medidasY) . "',";
    $sql .= "'" . db_escape($db, $medidasZ) . "',";
    $sql .= "'" . db_escape($db, $sizes) . "'";
    $sql .= ")";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);

// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function delete_inventory($product_inventory) {
    global $db;

    $sql = "DELETE FROM product_inventory ";
    $sql .= "WHERE inventory_id=" . db_escape($db, $product_inventory) . "";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
}

function update_inventory($product_inventory) {
    global $db;

    $sql = "UPDATE product_inventory SET ";

    $sql .= "color_id='" . db_escape($db, $product_inventory['color_id']) . "', ";
    $sql .= "size_id='" . db_escape($db, $product_inventory['size_id']) . "', ";
    $sql .= "available_qty='" . db_escape($db, $product_inventory['available_qty']) . "' ";
    $sql .= "WHERE inventory_id=" . db_escape($db, $product_inventory['inventory_id']) . " ";
    $sql .= "LIMIT 1";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_inventory_by_size_p_id($product_inventory) {
    global $db;

    $sql = "UPDATE product_inventory SET ";
    $sql .= "available_qty=" . db_escape($db, $product_inventory['available_qty']) . " ";
    $sql .= "WHERE product_id=" . db_escape($db, $product_inventory['product_id']) . " ";
    $sql .= "AND size_id='" . db_escape($db, $product_inventory['size_id']) . "' ";
    $sql .= "LIMIT 1";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_inventory_by_id($product_inventory) {
    global $db;

    $sql = "UPDATE product_inventory SET ";
    $sql .= "available_qty=" . db_escape($db, $product_inventory['available_qty']) . " ";
    $sql .= "WHERE inventory_id=" . db_escape($db, $product_inventory['inventory_id']) . " ";
    $sql .= "LIMIT 1";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function find_inventory_by_size_p_id($inventory) {
    global $db;

    $sql = "SELECT * FROM product_inventory ";
    $sql .= "WHERE product_id=" . db_escape($db, $inventory['product_id']) . " ";
    $sql .= "AND size_id=" . db_escape($db, $inventory['size_id']) . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $color = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $color; // returns an assoc. array
}

// END OF AVAILABLE PRODUCT COLOR
// START OF COLOR AREA
function insert_color($color) {
    global $db;

    $sql = "INSERT INTO colors ";
    $sql .= "(color_name, color_code) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $color['color_name']) . "',";
    $sql .= "'" . db_escape($db, $color['color_code']) . "'";
    $sql .= ")";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function find_all_colors() {
    global $db;

    $sql = "SELECT * FROM colors";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_color_producto_id($id_producto) {
    global $db;

    $sql = "SELECT DISTINCT(c.color_name),p.color_id FROM product_inventory AS p, colors AS c WHERE c.color_id=p.color_id AND p.product_id=" . db_escape($db, $id_producto) . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $product = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $product;
}

function delete_color_by_id($color_id) {
    global $db;

    $sql = "DELETE FROM colors ";
    $sql .= "WHERE color_id='" . db_escape($db, $color_id) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns an assoc. array
}

function find_color_by_id($color_id) {
    global $db;

    $sql = "SELECT * FROM colors ";
    $sql .= "WHERE color_id='" . db_escape($db, $color_id) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $color = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $color; // returns an assoc. array
}

function update_color($color) {
    global $db;

    $sql = "UPDATE colors SET ";
    $sql .= "color_name='" . db_escape($db, $color['color_name']) . "', ";
    $sql .= "color_code='" . db_escape($db, $color['color_code']) . "' ";
    $sql .= "WHERE color_id='" . db_escape($db, $color['color_id']) . "'";
    $sql .= "LIMIT 1";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

// END OF CATEGORY AREA

/* START OF SIZE */

function insert_size($product_size) {
    global $db;

    $sql = "INSERT INTO product_sizes ";
    $sql .= "(size_name, category_id) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $product_size['size_name']) . "',";
    $sql .= "'" . db_escape($db, $product_size['category']) . "'";
    $sql .= ")";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

// Cambios para categorias con tallas
function find_all_sizes() {
    global $db;

    $sql = "SELECT size.size_id, size.size_name, size.category_id, cate.title FROM product_sizes size INNER JOIN categories cate on size.category_id = cate.id";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_sizes_product($product_id) {
    global $db;

    $sql = "SELECT * FROM product_sizes_2 size Where product_id = $product_id";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

// Cambios para categorias con tallas de un producto
function find_all_sizes_product($id_product) {
    global $db;

    $sql = "SELECT size.size_id, size.size_name, size.category_id, cate.title FROM product_sizes size INNER JOIN categories cate on size.category_id = cate.id INNER JOIN products pro on pro.category = cate.id WHERE pro.id = $id_product";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

// ===================================
// Nuevos cambios - 26.05.2021
function find_all_sizes_category() {
    global $db;

    $sql = "SELECT cate.id as id ,cate.title FROM categories cate ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_all_sizes_rubro() {
    global $db;

    $sql = "SELECT r.id as id ,r.descripcion FROM rubro r where estado = 1 ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_size_by_category_id($category_id) {
    global $db;

// $sql = "SELECT * FROM product_sizes ";
    $sql = "SELECT size.size_name as size_name FROM product_sizes size ";

    $sql .= " WHERE size.category_id='" . db_escape($db, $category_id) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql) or die("Error: " . mysqli_error($db));
    confirm_result_set($result);

// 		var_dump($sql);

    $tallas = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $tallas[] = $row;
    }

// 		var_dump($tallas);

    mysqli_free_result($result);
    return $tallas; // returns an assoc. array
}

function find_size_by_rubro_tamaño_id($rubro_id) {
    global $db;

    $sql = "SELECT size.size_id as size_id,size.size_name as size_name FROM product_sizes size ";

    $sql .= " WHERE size.rubro_id='" . db_escape($db, $rubro_id) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql) or die("Error: " . mysqli_error($db));
    confirm_result_set($result);

    $tallas = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $tallas[] = $row;
    }

    mysqli_free_result($result);
    return $tallas; // returns an assoc. array
}

// Actualiza la talla y categoria
function update_size_for_Category($product_size) {
    global $db;

    $sql = "UPDATE product_sizes SET ";
    $sql .= "size_name='" . db_escape($db, $product_size['size_name']) . "', ";
    $sql .= "category_id='" . db_escape($db, $product_size['category']) . "' ";
    $sql .= "WHERE size_id='" . db_escape($db, $product_size['size_id']) . "' ";
    $sql .= "LIMIT 1";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

// Busca si existe Talla y Categoria.
function find_size_and_category($talla, $id_category) {
    global $db;

    $sql = "SELECT size_name FROM product_sizes ";
    $sql .= " WHERE category_id='" . db_escape($db, $id_category) . "' ";
    $sql .= " AND TRIM(UPPER(size_name))='" . db_escape($db, $talla) . "' ";

// 		var_dump($sql);

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    $rows = mysqli_num_rows($result);
    mysqli_free_result($result);

    if ($rows > 0) {
        return true;
    } else {
        return false;
    }
}

// Aqui registra nueva talla
function insert_size_for_catego($product_size, $size) {
    global $db;

    $sql = "INSERT INTO product_sizes ";
    $sql .= "(size_name, category_id,rubro_id) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $size) . "',";
    $sql .= "'" . db_escape($db, $product_size['category']) . "',";
    $sql .= "'" . db_escape($db, $product_size['rubro_id']) . "'";
    $sql .= ")";

//echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function insert_size_for_product_size_tam($id_product_size, $product_size, $size) {
    global $db;

    $sql = "INSERT INTO product_sizes ";
    $sql .= "(size_id ,size_name, category_id,rubro_id) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $id_product_size) . "',";
    $sql .= "'" . db_escape($db, $size) . "',";
    $sql .= "'" . db_escape($db, $product_size['category']) . "',";
    $sql .= "'" . db_escape($db, $product_size['rubro_id']) . "'";
    $sql .= ")";

//echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

// Me lista las tallas de acuerdo a las categoria seleccionada.
function find_all_sizes_for_category($id_category) {
    global $db;

    $sql = "SELECT size.size_id, size.size_name, size.category_id, cate.title FROM product_sizes size INNER JOIN categories cate on size.category_id = cate.id";
    $sql .= " WHERE category_id='" . db_escape($db, $id_category) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

//  ========================================

function get_product_size_rubro($id_rubro) {
    global $db;

    $sql = "SELECT size.size_id, size.size_name, size.category_id, cate.title FROM product_sizes size INNER JOIN categories cate on size.category_id = cate.id";
    $sql .= " WHERE category_id='" . db_escape($db, $id_category) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function delete_size_by_id($size_id) {
    global $db;

    $sql = "DELETE FROM product_sizes ";
    $sql .= "WHERE size_id='" . db_escape($db, $size_id) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns an assoc. array
}

function delete_type_by_id($type_id) {
    global $db;

    $sql = "DELETE FROM types ";
    $sql .= "WHERE id='" . db_escape($db, $type_id) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns an assoc. array
}

//aqui modifique
function update_size($product_size, $tam_id, $tam_nombre) {
    global $db;

    $sql = "UPDATE product_sizes SET ";
    $sql .= "size_name='" . db_escape($db, $tam_nombre) . "', ";
    $sql .= "category_id='" . db_escape($db, $product_size['category']) . "', ";
    $sql .= "rubro_id='" . db_escape($db, $product_size['rubro_id']) . "' ";
    $sql .= "WHERE size_id='" . db_escape($db, $tam_id) . "' ";
    $sql .= "LIMIT 1";

//echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
//$result = true;
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function delete_product_size_by_id($size_id) {
    global $db;

    $sql = "DELETE FROM product_sizes ";
    $sql .= "WHERE size_id='" . db_escape($db, $size_id) . "' ";
//echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns an assoc. array
}

function find_size_by_id($size_id) {
    global $db;

// $sql = "SELECT * FROM product_sizes ";
    $sql = "SELECT size.size_id, size.size_name, size.category_id, cate.id, cate.title FROM product_sizes size INNER JOIN categories cate on size.category_id = cate.id";

    $sql .= " WHERE size.size_id='" . db_escape($db, $size_id) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql) or die("Error: " . mysqli_error($db));
    confirm_result_set($result);
    $color = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $color; // returns an assoc. array
}

function find_size_name_id($id_size) {
    global $db;

    $sql = "SELECT * FROM product_sizes ";
    $sql .= "WHERE size_id='" . db_escape($db, $id_size) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $color = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $color; // returns an assoc. array
}

function find_size_rubro_id($id_rubro) {
    global $db;

    $sql = "SELECT * FROM product_sizes ";
    $sql .= "WHERE rubro_id='" . db_escape($db, $id_rubro) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $color = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $color; // returns an assoc. array
}

function find_size_by_size_name($size_name) {
    global $db;

    $sql = "SELECT * FROM product_sizes ";
    $sql .= "WHERE size_name='" . db_escape($db, $size_name) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $color = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $color; // returns an assoc. array
}

/* END OF SIZE */


/* START OF PRODUCT RATING */

function insert_product_rating($product_rating) {
    global $db;

    $sql = "INSERT INTO product_rating";
    $sql .= "(product_id, user_id, rating) ";
    $sql .= "VALUES (";
    $sql .= "" . db_escape($db, $product_rating['product_id']) . ", ";
    $sql .= "'" . db_escape($db, $product_rating['user_id']) . "', ";
    $sql .= "" . db_escape($db, $product_rating['rating']) . "";
    $sql .= ")";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_rating($product_rating) {
    global $db;

    $sql = "UPDATE product_rating SET ";
    $sql .= "rating=" . db_escape($db, $product_rating['rating']) . " ";
    $sql .= "WHERE user_id='" . db_escape($db, $product_rating['user_id']) . "' ";
    $sql .= "AND product_id='" . db_escape($db, $product_rating['product_id']) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function get_avg_rating_of_product($product_id) {
    global $db;

    $sql = "SELECT AVG(rating) FROM product_rating ";
    $sql .= "WHERE product_id='" . db_escape($db, $product_id) . "' ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $avg_raing = mysqli_fetch_array($result);
    mysqli_free_result($result);
    return $avg_raing[0]; // returns an assoc. array
}

function get_rating_count_of_product($product_id) {
    global $db;

    $sql = "SELECT count(rating_id) FROM product_rating ";
    $sql .= "WHERE product_id='" . db_escape($db, $product_id) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $count_raing = mysqli_fetch_array($result);
    mysqli_free_result($result);
    return $count_raing[0]; // returns an assoc. array
}

function get_rating_by_user_product($product_rating) {

    global $db;
    $sql = "SELECT * FROM product_rating ";
    $sql .= "WHERE user_id='" . db_escape($db, $product_rating['user_id']) . "' ";
    $sql .= "AND product_id='" . db_escape($db, $product_rating['product_id']) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $p_rating = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    return $p_rating;
}

function rating_exists_by_user_product($product_rating) {

    global $db;
    $sql = "SELECT * FROM product_rating ";
    $sql .= "WHERE user_id='" . db_escape($db, $product_rating['user_id']) . "' ";
    $sql .= "AND product_id='" . db_escape($db, $product_rating['product_id']) . "' ";

// echo $sql;
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $p_rating = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    return ( $p_rating['user_id'] > 0 ) ? true : false;
}

/* END OF PRODUCT RATING */

/* START OF PRODUCT FAVOURITE */

function insert_product_favourite($product_favourite) {
    global $db;

    $sql = "INSERT INTO product_favourites ";
    $sql .= "(user_id, product_id) ";
    $sql .= "VALUES (";
    $sql .= "" . db_escape($db, $product_favourite['user_id']) . ", ";
    $sql .= "" . db_escape($db, $product_favourite['product_id']) . "";
    $sql .= ")";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function delete_product_favourite($product_favourite) {
    global $db;

    $sql = "DELETE FROM product_favourites ";
    $sql .= "WHERE user_id='" . db_escape($db, $product_favourite['user_id']) . "' ";
    $sql .= "AND product_id='" . db_escape($db, $product_favourite['product_id']) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns an assoc. array
}

function get_fav_count_of_product($product_id) {
    global $db;

    $sql = "SELECT count(product_id) FROM product_favourites ";
    $sql .= "WHERE product_id='" . db_escape($db, $product_id) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $fav_count = mysqli_fetch_array($result);
    mysqli_free_result($result);
    return $fav_count[0]; // returns an assoc. array
}

/* END OF PRODUCT FAVOURITE */

// START OF BRAINTREE

function insert_braintree($braintree) {
    global $db;

    $sql = "INSERT INTO braintree_credentials ";
    $sql .= "(environment, merchant_id, public_key, private_key, user_id) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $braintree['environment']) . "',";
    $sql .= "'" . db_escape($db, $braintree['merchant_id']) . "',";
    $sql .= "'" . db_escape($db, $braintree['public_key']) . "',";
    $sql .= "'" . db_escape($db, $braintree['private_key']) . "',";
    $sql .= "" . db_escape($db, $braintree['user_id']) . "";
    $sql .= ")";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_braintree($braintree) {
    global $db;

    $sql = "UPDATE braintree_credentials SET ";
    $sql .= "environment='" . db_escape($db, $braintree['environment']) . "', ";
    $sql .= "merchant_id='" . db_escape($db, $braintree['merchant_id']) . "', ";
    $sql .= "public_key='" . db_escape($db, $braintree['public_key']) . "', ";
    $sql .= "private_key='" . db_escape($db, $braintree['private_key']) . "', ";
    $sql .= "user_id=" . db_escape($db, $braintree['user_id']) . " ";
    $sql .= "WHERE id=" . db_escape($db, $braintree['id']) . " ";
    $sql .= "LIMIT 1";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function find_braintree_by_user_id($user_id) {
    global $db;

    $sql = "SELECT * FROM braintree_credentials ";
    $sql .= "WHERE user_id='" . db_escape($db, $user_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $braintree = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $braintree; // returns an assoc. array
}

function find_braintree() {
    global $db;

    $sql = "SELECT * FROM braintree_credentials";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

// END OF BRAINTREE

function find_stores() {
    global $db;
    $sql = "SELECT * FROM users WHERE store != NULL or store != '' or gallery != NULL or gallery != '' ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_ads_api() {
    global $db;
    $date = date('Y-m-d');
    $sql = "SELECT * FROM anuncios WHERE '$date' > fecha_registro and '$date' < fecha_expira";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_ads() {
    global $db;
    $date = date('Y-m-d');
    $sql = "SELECT * FROM anuncios WHERE 1";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function insert_adds($adds) {
    global $db;

    $sql = "INSERT INTO anuncios ";
    $sql .= "(titulo , descripcion , fecha_registro ,tipo_anuncio ,url_foto , fecha_expira, RazonSocial, Celular, Correo, Contacto ) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $adds['title']) . "',";
    $sql .= "'" . db_escape($db, $adds['description']) . "',";
    $sql .= "'" . db_escape($db, $adds['fecha_registro']) . "',";
    $sql .= "'" . db_escape($db, $adds['type']) . "',";
    $sql .= "'" . db_escape($db, $adds['url_foto']) . "',";
    $sql .= "'" . db_escape($db, $adds['fecha_expira']) . "',";
    $sql .= "'" . db_escape($db, $adds['RazonSocial']) . "',";
    $sql .= "'" . db_escape($db, $adds['Celular']) . "',";
    $sql .= "'" . db_escape($db, $adds['Correo']) . "',";
    $sql .= "'" . db_escape($db, $adds['Contacto']) . "'";
    $sql .= ")";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function traer_departamentos_registrados($id_departamento) {
    global $db;

    $sql = "SELECT * FROM destinos WHERE id_departamento='" . db_escape($db, $id_departamento) . "'";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function actualizar_por_departamentos($id_destino, $estado) {
    global $db;

    $sql = "UPDATE destinos SET ";
    $sql .= "estado='" . db_escape($db, $estado) . "' ";
    $sql .= "WHERE id_destino='" . db_escape($db, $id_destino) . "'";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function traer_departamentos_activos() {
    global $db;

    $sql = "SELECT DISTINCT(d.id_departamento), ud.name FROM ubigeo_peru_departments AS ud, destinos AS d WHERE d.id_departamento=ud.id AND d.estado='Activo'";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function traer_departamentos_destino() {
    global $db;

    $sql = "SELECT DISTINCT(d.id_departamento), ud.name FROM ubigeo_peru_departments AS ud, destinos AS d WHERE d.id_departamento=ud.id";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function traer_departamentos() {
    global $db;

    $sql = "SELECT * FROM ubigeo_peru_departments";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function traer_provincias_destino($id_departamento) {
    global $db;

    $sql = "SELECT DISTINCT(d.id_departamento),d.id_provincia, p.name FROM destinos AS d, ubigeo_peru_provinces AS p WHERE d.id_provincia=p.id ";
    $sql .= "AND d.id_departamento='" . db_escape($db, $id_departamento) . "' ";


// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function traer_provincias_all($id_departamento, $id_provincia) {
    global $db;

    $sql = "SELECT * FROM destinos  WHERE id_provincia='" . db_escape($db, $id_provincia) . "' ";
    $sql .= "AND id_departamento='" . db_escape($db, $id_departamento) . "' ";


// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function actualizar_por_provincias($id_destino, $estado) {
    global $db;

    $sql = "UPDATE destinos SET ";
    $sql .= "estado='" . db_escape($db, $estado) . "' ";
    $sql .= "WHERE id_destino='" . db_escape($db, $id_destino) . "'";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function traer_provincias($id_departamento) {
    global $db;

    $sql = "SELECT * FROM ubigeo_peru_provinces ";
    $sql .= "WHERE department_id='" . db_escape($db, $id_departamento) . "' ";


// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function traer_provincia_activa($id_departamento) {
    global $db;

    $sql = "SELECT DISTINCT(d.id_provincia),p.department_id,p.name FROM destinos AS d, ubigeo_peru_provinces AS p WHERE p.id=d.id_provincia AND d.estado='Activo' ";
    $sql .= "AND p.department_id='" . db_escape($db, $id_departamento) . "' ";


// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function traer_distrito($id_provincia, $id_departamento) {
    global $db;

    $sql = "SELECT * FROM ubigeo_peru_districts ";
    $sql .= "WHERE province_id='" . db_escape($db, $id_provincia) . "' ";
    $sql .= "AND department_id='" . db_escape($db, $id_departamento) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function traer_distrito_vender_md($id_departamento) {
    global $db;
//Solo Lima
//$id_departamento = 15;
    $sql = "SELECT * FROM ubigeo_peru_districts ";
    $sql .= "WHERE department_id='" . db_escape($db, $id_departamento) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

//function getDistritoJSON() {
//    $datos = traer_distrito_vender_md(15);
//    echo json_encode($datos);
//}

function traer_distrito_avtiva($id_provincia, $id_departamento) {
    global $db;
    $sql = "SELECT d.id_distrito, di.name, di.province_id, di.department_id FROM destinos AS d, ubigeo_peru_districts AS di WHERE di.id=d.id_distrito AND d.estado='Activo' ";
    $sql .= "AND di.province_id='" . db_escape($db, $id_provincia) . "' ";
    $sql .= "AND di.department_id='" . db_escape($db, $id_departamento) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function insertar_destino($datos_destino) {
    global $db;

    $sql = "INSERT INTO destinos ";
    $sql .= "(id_departamento, id_provincia, id_distrito, precio, estado) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $datos_destino['CodD']) . "',";
    $sql .= "'" . db_escape($db, $datos_destino['CodP']) . "',";
    $sql .= "'" . db_escape($db, $datos_destino['CodDi']) . "',";
    $sql .= "'" . db_escape($db, $datos_destino['Precio']) . "',";
    $sql .= "'" . db_escape($db, $datos_destino['Estado']) . "'";
    $sql .= ")";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function traer_destinos() {
    global $db;

    $sql = "SELECT d.id_destino,de.name AS departamento, p.name AS provincia, di.name AS distrito, d.precio, d.estado FROM destinos AS d, ubigeo_peru_provinces AS p, ubigeo_peru_departments AS de, ubigeo_peru_districts AS di WHERE d.id_provincia=p.id AND d.id_departamento=de.id AND d.id_distrito=di.id";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function eliminar_destino($id_destino) {
    global $db;
    $sql = "DELETE FROM destinos ";
    $sql .= "WHERE id_destino='" . db_escape($db, $id_destino) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function traer_destino_id($id_destino) {
    global $db;

    $sql = "SELECT d.id_destino,de.name AS departamento, p.name AS provincia, di.name AS distrito, d.precio, d.estado FROM destinos AS d, ubigeo_peru_provinces AS p, ubigeo_peru_departments AS de, ubigeo_peru_districts AS di WHERE d.id_provincia=p.id AND d.id_departamento=de.id AND d.id_distrito=di.id ";
    $sql .= "AND d.id_destino='" . db_escape($db, $id_destino) . "' ";


// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function editar_destino_id($id_destino, $precio, $estado) {
    global $db;

    $sql = "UPDATE destinos SET ";
    $sql .= "precio='" . db_escape($db, $precio) . "', ";
    $sql .= "estado='" . db_escape($db, $estado) . "' ";
    $sql .= "WHERE id_destino=" . db_escape($db, $id_destino);

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function evaluar_existe_destino($datos_destino) {
    global $db;

    $sql = "SELECT * FROM destinos AS d ";
    $sql .= "WHERE d.id_departamento='" . db_escape($db, $datos_destino['CodD']) . "' ";
    $sql .= "AND d.id_provincia='" . db_escape($db, $datos_destino['CodP']) . "' ";
    $sql .= "AND d.id_distrito='" . db_escape($db, $datos_destino['CodDi']) . "' ";


// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    $rows = mysqli_num_rows($result);
    mysqli_free_result($result);

    if ($rows > 0) {
        return true;
    } else {
        return false;
    }
}

function traer_destino_precio($cod_depa, $cod_prov, $cod_dis) {
    global $db;

    $sql = "SELECT * FROM destinos AS d ";
    $sql .= "WHERE d.id_departamento='" . db_escape($db, $cod_depa) . "' ";
    $sql .= "AND d.id_provincia='" . db_escape($db, $cod_prov) . "' ";
    $sql .= "AND d.id_distrito='" . db_escape($db, $cod_dis) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function traer_comisiones() {
    global $db;

    $sql = "SELECT * FROM comisiones";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function traer_comision_activa() {
    global $db;

    $sql = "SELECT * FROM comisiones ";
    $sql .= "WHERE estado='1'";
// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function actualizar_comision($id_activo, $monto, $estado) {
    global $db;

    $sql = "UPDATE comisiones SET ";
    $sql .= "cantidad='" . db_escape($db, $monto) . "', ";
    $sql .= "estado='" . db_escape($db, $estado) . "' ";
    $sql .= "WHERE id_comision='" . db_escape($db, $id_activo) . "'";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function actualizar_comision_activa($id_comision, $estado) {
    global $db;

    $sql = "UPDATE comisiones SET ";
    $sql .= "estado='" . db_escape($db, $estado) . "' ";
    $sql .= "WHERE id_comision='" . db_escape($db, $id_comision) . "'";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

//TRAER MEDIDAS LARGO DEL PRODUCTO ,  CONTORNO DEL PECHO , LARGO DE LA MANGA

function obtener_productos_tallas($product_id, $size) {
    global $db;

//$sql = "SELECT id_zize,product_id,medidax,mediday,medidaz,size FROM product_sizes_2 WHERE product_id='" . db_escape($db, $product_id) ."'";
    $sql = "SELECT id_zize,product_id,medidax,mediday,medidaz,size FROM product_sizes_2 WHERE product_id='" . db_escape($db, $product_id) . " ' AND size='" . db_escape($db, $size) . "'";


    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function traer_rubro_vender_md() {
    global $db;
    $activo = 1;
    $sql = "SELECT * FROM rubro ";
    $sql .= "WHERE estado='" . db_escape($db, $activo) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_product_sizes_rubro($rubro_id) {
    global $db;
    $sql = "SELECT p.size_id,p.size_name,p.category_id, p.rubro_id , c.title as title , r.descripcion as descripcion  ";
    $sql .= "FROM product_sizes as p ";
    $sql .= "LEFT JOIN categories c ON p.category_id = c.id ";
    $sql .= "LEFT JOIN rubro r ON p.rubro_id = r.id ";
    $sql .= "WHERE p.rubro_id='" . db_escape($db, $rubro_id) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_restricciones() {
    global $db;
//$activo = 1;
    $sql = "SELECT r.id, r.id_negocio,r.limite_producto,r.limite_foto , u.business_name as negocio ";
    $sql .= "FROM restricciones as r ";
    $sql .= "LEFT JOIN users u ON r.id_negocio = u.user_id ";

//$sql .= "WHERE estado='" . db_escape($db, $activo) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_tipo_servicio_md() {
    global $db;
    $activo = 1;
    $sql = "SELECT * FROM tipo_servicio ";
    $sql .= "WHERE estado='" . db_escape($db, $activo) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_rubro_by_id($rubro_id) {
    global $db;

    $sql = "SELECT * FROM rubro ";
    $sql .= "WHERE id='" . db_escape($db, $rubro_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $category = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $category; // returns an assoc. array
}

function find_restriccion_by_id($restriccion_id) {
    global $db;

    $sql = "SELECT * FROM restricciones ";
    $sql .= "WHERE id='" . db_escape($db, $restriccion_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $restriccion = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $restriccion; // returns an assoc. array
}

function update_rubro($rubro) {
    global $db;

    $sql = "UPDATE rubro SET ";
    $sql .= "codigo='" . db_escape($db, $rubro['codigo']) . "', ";
    $sql .= "descripcion='" . db_escape($db, $rubro['descripcion']) . "', ";
    $sql .= "estado='" . db_escape($db, $rubro['statu']) . "' ";
    $sql .= "WHERE id=" . db_escape($db, $rubro['id']) . " ";
//$sql .= "LIMIT 1";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_sucursal($sucursal) {
    global $db;
    $sql = "UPDATE sucursal SET ";
    $sql .= "user_id='" . db_escape($db, $sucursal['sucursal_id_admin']) . "', ";
    $sql .= "nombre='" . db_escape($db, $sucursal['nombre']) . "', ";
    $sql .= "distrito='" . db_escape($db, $sucursal['distrito']) . "', ";
    $sql .= "direccion='" . db_escape($db, $sucursal['direccion']) . "', ";
    $sql .= "numero_sucursal='" . db_escape($db, $sucursal['numero_sucursal']) . "', ";
    $sql .= "correo='" . db_escape($db, $sucursal['correo']) . "', ";
    $sql .= "celular='" . db_escape($db, $sucursal['celular']) . "', ";
    $sql .= "latitud='" . db_escape($db, $sucursal['latitud']) . "', ";
    $sql .= "longitud='" . db_escape($db, $sucursal['longitud']) . "', ";
    $sql .= "status='" . db_escape($db, $sucursal['statu']) . "' ";
    $sql .= "WHERE id=" . db_escape($db, $sucursal['sucursal_id']) . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);

    if ($result) {
        return true;
    } else {
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_envio($envio) {
    global $db;
    $sql = "UPDATE envios SET ";
    $sql .= "user_id='" . db_escape($db, $envio['envio_id_admin']) . "', ";
    $sql .= "sucursal_id='" . db_escape($db, $envio['sucursal_id']) . "', ";
    $sql .= "distrito='" . db_escape($db, $envio['distrito']) . "', ";
    $sql .= "precio='" . db_escape($db, $envio['precio']) . "', ";
    $sql .= "status='" . db_escape($db, $envio['statu']) . "' ";
    $sql .= "WHERE id=" . db_escape($db, $envio['envio_id']) . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);

    if ($result) {
        return true;
    } else {
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_restriccion($restriccion) {
    global $db;

    $sql = "UPDATE restricciones SET ";
    $sql .= "id_negocio='" . db_escape($db, $restriccion['id_negocio']) . "', ";
    $sql .= "limite_producto='" . db_escape($db, $restriccion['limite_producto']) . "', ";
    $sql .= "limite_foto='" . db_escape($db, $restriccion['limite_foto']) . "' ";
    $sql .= "WHERE id=" . db_escape($db, $restriccion['id']) . " ";
//$sql .= "LIMIT 1";


    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function insert_rubro($rubro) {
    global $db;

    $sql = "INSERT INTO rubro ";
    $sql .= "(codigo,descripcion,estado) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $rubro['codigo']) . "',";
    $sql .= "'" . db_escape($db, $rubro['descripcion']) . "',";
    $sql .= "'" . db_escape($db, $rubro['statu']) . "'";
    $sql .= ")";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function insert_sucursal($sucursal) {
    global $db;
    $sql = "INSERT INTO sucursal ";
    $sql .= "(user_id,nombre,distrito,direccion,numero_sucursal,correo,celular,latitud,longitud,status) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $sucursal['sucursal_id_admin']) . "',";
    $sql .= "'" . db_escape($db, $sucursal['nombre']) . "',";
    $sql .= "'" . db_escape($db, $sucursal['distrito']) . "',";
    $sql .= "'" . db_escape($db, $sucursal['direccion']) . "',";
    $sql .= "'" . db_escape($db, $sucursal['numero_sucursal']) . "',";
    $sql .= "'" . db_escape($db, $sucursal['correo']) . "',";
    $sql .= "'" . db_escape($db, $sucursal['celular']) . "',";
    $sql .= "'" . db_escape($db, $sucursal['latitud']) . "',";
    $sql .= "'" . db_escape($db, $sucursal['longitud']) . "',";
    $sql .= "'" . db_escape($db, $sucursal['statu']) . "'";
    $sql .= ")";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

// insert envios

function insert_envios($envio) {
    global $db;
    $sql = "INSERT INTO envios ";
    $sql .= "(user_id,sucursal_id,distrito,precio,status) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $envio['envio_id_admin']) . "',";
    $sql .= "'" . db_escape($db, $envio['sucursal_id']) . "',";
    $sql .= "'" . db_escape($db, $envio['distrito']) . "',";
    $sql .= "'" . db_escape($db, $envio['precio']) . "',";
    $sql .= "'" . db_escape($db, $envio['statu']) . "'";
    $sql .= ")";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    if ($result) {
        return mysqli_insert_id($db);
    } else {
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

// agregar restriccion

function insert_restriccion($restriccion) {
    global $db;

    $sql = "INSERT INTO restricciones ";
    $sql .= "(id_negocio,limite_producto,limite_foto) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $restriccion['id_negocio']) . "',";
    $sql .= "'" . db_escape($db, $restriccion['limite_producto']) . "',";
    $sql .= "'" . db_escape($db, $restriccion['limite_foto']) . "'";
    $sql .= ")";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

//delete rubro
function delete_rubro_by_id($rubro_id) {
    global $db;

    $sql = "DELETE FROM rubro ";
    $sql .= "WHERE id='" . db_escape($db, $rubro_id) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns an assoc. array
}

function delete_sucursal_by_id($sucursal_id) {
    global $db;
    $sql = "DELETE FROM sucursal ";
    $sql .= "WHERE id='" . db_escape($db, $sucursal_id) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns an assoc. array
}

//actualizar estado
function delete_rubro_by_id_statu($rubro_id) {
    global $db;

    $sql = "UPDATE rubro SET ";
    $sql .= "estado='" . db_escape($db, 2) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $rubro_id) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns an assoc. array
}

function delete_envio_by_id($envio_id) {
    global $db;
    $sql = "DELETE FROM envios ";
    $sql .= "WHERE id ='" . db_escape($db, $envio_id) . "' ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function delete_usuario_by_id_rol($usuario_id) {
    global $db;

    $sql = "DELETE FROM users ";
    $sql .= "WHERE user_id ='" . db_escape($db, $usuario_id) . "' ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns an assoc. array
}

function delete_restriccion_by_id_statu($restriccion_id) {
    global $db;

    $sql = "DELETE FROM restricciones ";
    $sql .= "WHERE id='" . db_escape($db, $restriccion_id) . "' ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns an assoc. array
}

function find_all_join_subcategories() {
    global $db;

    $sql = "SELECT s.id,s.id_categoria,s.nombre,s.image_name,s.alias,s.estado,c.title as categoria , r.descripcion ";
    $sql .= "FROM subcategorias s ";
    $sql .= "LEFT JOIN categories c ON s.id_categoria = c.id ";
    $sql .= "LEFT JOIN rubro r ON c.id_rubro = r.id ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_subcategory_by_id($subcategory_id) {
    global $db;

    $sql = "SELECT * FROM subcategorias ";
    $sql .= "WHERE id='" . db_escape($db, $subcategory_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $category = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $category; // returns an assoc. array
}

function insert_subcategory($subcategory) {
    global $db;

    $sql = "INSERT INTO subcategorias ";
    $sql .= "(id_categoria,nombre,image_name,alias,estado) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $subcategory['subcategory_id_categoria']) . "',";
    $sql .= "'" . db_escape($db, $subcategory['subcategory_nombre']) . "',";
    $sql .= "'" . db_escape($db, $subcategory['image_name']) . "',";
    $sql .= "'" . db_escape($db, $subcategory['alias']) . "',";
    $sql .= "'" . db_escape($db, $subcategory['statu']) . "'";
    $sql .= ")";

//echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function find_all_rubros() {
    global $db;

    $sql = "SELECT * FROM rubro";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function insert_pantalla_color($sreen) {
    global $db;
    $sql = "INSERT INTO screen ";
    $sql .= "(id_tienda,color,codigo,image_logo,image_icono,nombre,facebook_url,instagram_url,mision , vision , objetivos,nosotros,icono_cat_productos,icono_cat_servicios,"
        . " icono_cat_membresias,icono_cat_ofertas_promociones,icono_cat_otros,div_cat_productos,div_cat_servicios,div_cat_membresias,div_cat_ofertas_promociones,div_cat_otros,url_video,color_texto,estado) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $sreen['tienda']) . "',";
    $sql .= "'" . db_escape($db, $sreen['color']) . "',";
    $sql .= "'" . db_escape($db, $sreen['codigo']) . "',";
    $sql .= "'" . db_escape($db, $sreen['tienda_app_logo']) . "',";
    $sql .= "'" . db_escape($db, $sreen['tienda_app_icono']) . "',";
    $sql .= "'" . db_escape($db, $sreen['nombre']) . "',";
    $sql .= "'" . db_escape($db, $sreen['facebook_url']) . "',";
    $sql .= "'" . db_escape($db, $sreen['instagram_url']) . "',";
    $sql .= "'" . db_escape($db, $sreen['mision']) . "',";
    $sql .= "'" . db_escape($db, $sreen['vision']) . "',";
    $sql .= "'" . db_escape($db, $sreen['objetivos']) . "',";
    $sql .= "'" . db_escape($db, $sreen['tienda_app_nosotros']) . "',";
    $sql .= "'" . db_escape($db, $sreen['tienda_app_icon_cat_producto']) . "',";
    $sql .= "'" . db_escape($db, $sreen['tienda_app_icon_cat_servicio']) . "',";
    $sql .= "'" . db_escape($db, $sreen['tienda_app_icon_cat_membresia']) . "',";
    $sql .= "'" . db_escape($db, $sreen['tienda_app_icon_cat_ofertas']) . "',";
    $sql .= "'" . db_escape($db, $sreen['tienda_app_icon_cat_otros']) . "',";
    $sql .= "'" . db_escape($db, $sreen['div_cat_productos']) . "',";
    $sql .= "'" . db_escape($db, $sreen['div_cat_servicios']) . "',";
    $sql .= "'" . db_escape($db, $sreen['div_cat_membresias']) . "',";
    $sql .= "'" . db_escape($db, $sreen['div_cat_ofertas_promociones']) . "',";
    $sql .= "'" . db_escape($db, $sreen['div_cat_otros']) . "',";
    $sql .= "'" . db_escape($db, $sreen['url_video']) . "',";
    $sql .= "'" . db_escape($db, $sreen['color_texto']) . "',";
    $sql .= "'" . db_escape($db, $sreen['statu']) . "'";
    $sql .= ")";

    echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function get_screen() {
    global $db;
    $activo = 1;
    $sql = "SELECT s.id,s.id_tienda,s.color,s.codigo,s.image_logo,s.image_icono,s.nombre,s.estado,u.store as tienda , u.business_name as negocio ";
    $sql .= "FROM screen s ";
    $sql .= "LEFT JOIN users u on s.id_tienda = u.user_id ";
    $sql .= "WHERE estado='" . db_escape($db, $activo) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_screen_by_id($screen_id) {
    global $db;

    $sql = "SELECT * FROM screen ";
    $sql .= "WHERE id='" . db_escape($db, $screen_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $screen = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $screen; // returns an assoc. array
}

function update_screen($screen) {
    global $db;

    $sql = "UPDATE screen SET ";
    $sql .= "id_tienda='" . db_escape($db, $screen['tienda']) . "', ";
    $sql .= "color='" . db_escape($db, $screen['color']) . "', ";
    $sql .= "codigo='" . db_escape($db, $screen['codigo']) . "', ";
    $sql .= "image_logo='" . db_escape($db, $screen['tienda_app_logo']) . "', ";
    $sql .= "image_icono='" . db_escape($db, $screen['tienda_app_icono']) . "', ";
    $sql .= "nombre='" . db_escape($db, $screen['nombre']) . "', ";
    $sql .= "facebook_url='" . db_escape($db, $screen['facebook_url']) . "', ";
    $sql .= "instagram_url='" . db_escape($db, $screen['instagram_url']) . "', ";
    $sql .= "mision='" . db_escape($db, $screen['mision']) . "', ";
    $sql .= "vision='" . db_escape($db, $screen['vision']) . "', ";
    $sql .= "objetivos='" . db_escape($db, $screen['objetivos']) . "', ";
    $sql .= "nosotros='" . db_escape($db, $screen['tienda_app_nosotros']) . "', ";

    $sql .= "icono_cat_productos='" . db_escape($db, $screen['tienda_app_icon_cat_producto']) . "', ";
    $sql .= "icono_cat_servicios='" . db_escape($db, $screen['tienda_app_icon_cat_servicio']) . "', ";
    $sql .= "icono_cat_membresias='" . db_escape($db, $screen['tienda_app_icon_cat_membresia']) . "', ";
    $sql .= "icono_cat_ofertas_promociones='" . db_escape($db, $screen['tienda_app_icon_cat_ofertas']) . "', ";
    $sql .= "icono_cat_otros='" . db_escape($db, $screen['tienda_app_icon_cat_otros']) . "', ";

    $sql .= "div_cat_productos='" . db_escape($db, $screen['div_cat_productos']) . "', ";
    $sql .= "div_cat_servicios='" . db_escape($db, $screen['div_cat_servicios']) . "', ";
    $sql .= "div_cat_membresias='" . db_escape($db, $screen['div_cat_membresias']) . "', ";
    $sql .= "div_cat_ofertas_promociones='" . db_escape($db, $screen['div_cat_ofertas_promociones']) . "', ";
    $sql .= "div_cat_otros='" . db_escape($db, $screen['div_cat_otros']) . "', ";
    $sql .= "url_video='" . db_escape($db, $screen['url_video']) . "', ";
    $sql .= "color_texto='" . db_escape($db, $screen['color_texto']) . "', ";
    $sql .= "estado='" . db_escape($db, $screen['statu']) . "' ";
    $sql .= "WHERE id=" . db_escape($db, $screen['id']) . " ";
    $sql .= "LIMIT 1";

    echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function delete_screen_by_id($screen_id) {
    global $db;
    $sql = "DELETE FROM screen ";
    $sql .= "WHERE id='" . db_escape($db, $screen_id) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns an assoc. array
}

//SERVICIOS MY APP

function find_all_settings_pantalla() {
    global $db;
    $sql = "SELECT * FROM screen where id_tienda='168'";
    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_all_settings_pantalla_service($id_tienda) {
    global $db;
    $sql = "SELECT * FROM screen ";
    $sql .= "WHERE id_tienda='" . db_escape($db, $id_tienda) . "' ";

    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

//SUBCATEGORIA

function update_subcategory($subcategory) {
    global $db;

    $sql = "UPDATE subcategorias SET ";
    $sql .= "id_categoria='" . db_escape($db, $subcategory['subcategory_id_categoria']) . "', ";
    $sql .= "nombre='" . db_escape($db, $subcategory['subcategory_nombre']) . "', ";
    $sql .= "image_name='" . db_escape($db, $subcategory['image_name']) . "', ";
    $sql .= "alias='" . db_escape($db, $subcategory['alias']) . "', ";
    $sql .= "estado=" . db_escape($db, $subcategory['statu']) . " ";
    $sql .= "WHERE id=" . db_escape($db, $subcategory['subcategory_id']) . " ";
    $sql .= "LIMIT 1";


    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

//Devuelve la restriccion de limite de producto y limite foto del usuario
function get_limite_producto_slider($user_id) {
    global $db;

    $sql = "SELECT limite_producto , limite_foto FROM restricciones ";
    $sql .= "WHERE id_negocio='" . db_escape($db, $user_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $screen = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $screen; // returns an assoc. array
}

//Devuelve el numero de fotos del slider que tiene el usuario
function get_number_slider_user_id($user_id) {
    global $db;

    $sql = "SELECT COUNT(*) as valor FROM slider ";
    $sql .= "WHERE id_user='" . db_escape($db, $user_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $screen = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $screen; // returns an assoc. array
}

//LISTA DE TAMAÑOS ( PRODUCT SIZES)

function get_product_sizes() {
    global $db;
    $sql = "SELECT p.size_id,p.size_name,p.category_id, p.rubro_id , c.title as title , r.descripcion as descripcion  ";
    $sql .= "FROM product_sizes as p ";
    $sql .= "LEFT JOIN categories c ON p.category_id = c.id ";
    $sql .= "LEFT JOIN rubro r ON p.rubro_id = r.id ";

    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

/* function get_product_sizes_by_rubro_user($rubro_id) {
  global $db;
  $sql = "SELECT p.size_id,p.size_name,p.category_id, p.rubro_id , c.title as title , r.descripcion as descripcion  ";
  $sql .= "FROM product_sizes as p ";
  $sql .= "LEFT JOIN categories c ON p.category_id = c.id ";
  $sql .= "LEFT JOIN rubro r ON p.rubro_id = r.id ";
  $sql .= "WHERE p.rubro_id='" . db_escape($db, $rubro_id) . "' ";

  //echo $sql;

  mysqli_set_charset($db, "utf8");

  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
  $rows[] = $row;
  }
  mysqli_free_result($result);
  return $rows;
  } */

function get_product_sizes_by_rubro_user($rubro_id) {
    global $db;
    $sql = "SELECT DISTINCT p.size_id,p.size_name,p.category_id, p.rubro_id , c.title as title , r.descripcion as descripcion  ";
    $sql .= "FROM product_sizes as p ";
    $sql .= "LEFT JOIN categories c ON p.category_id = c.id ";
    $sql .= "LEFT JOIN rubro r ON p.rubro_id = r.id ";
    $sql .= "WHERE p.rubro_id='" . db_escape($db, $rubro_id) . "' ";

//echo $sql;

    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_rubro_by_users($user_id) {
    global $db;

    $sql = "SELECT cod_rubro from users ";
    $sql .= "WHERE user_id='" . db_escape($db, $user_id) . "' ";

//echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $category = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $category; // returns an assoc. array
}

function all_rubros_by_user($user_id) {
    global $db;
    $sql = "SELECT  u.user_id as user_id , u.cod_rubro as cod_rubro , r.id as id, r.descripcion as descripcion ";
    $sql .= "FROM users as u ";
    $sql .= "LEFT JOIN rubro r ON u.cod_rubro = r.id ";
    $sql .= "WHERE u.user_id='" . db_escape($db, $user_id) . "' ";

//    echo $sql;

    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function obtener_categoria_by_id($id_categoria) {
    global $db;

    $sql = "SELECT sub.id,sub.id_categoria,sub.nombre,sub.alias,cat.id,cat.id_rubro,cat.title ";
    $sql .= "FROM subcategorias as sub ";
    $sql .= "LEFT JOIN categories as cat on sub.id_categoria = cat.id ";
    $sql .= "WHERE id_categoria=" . db_escape($db, $id_categoria) . " ";

//    echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function tienda_existe_por_id($user_id) {

    global $db;
    $sql = "SELECT id_tienda FROM screen ";
    $sql .= "WHERE id_tienda=" . db_escape($db, $user_id) . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $user = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return ( $user['id_tienda'] > 0 ) ? true : false;
}

function tienda_existe_por_id_restriccion($user_id) {

    global $db;
    $sql = "SELECT * FROM restricciones ";
    $sql .= "WHERE id_negocio=" . db_escape($db, $user_id) . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $user = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return ( $user['id_negocio'] > 0 ) ? true : false;
}

/*
  function insert_plan($plan) {
  global $db;

  $sql = "INSERT INTO plan ";
  $sql .= "(id_user,descripcion,precio_plan,precio_normal,promocion,fecha_inicio,fecha_fin,horario,horario_foto,profesor,profesor_foto,estado) ";
  $sql .= "VALUES (";
  $sql .= "'" . db_escape($db, $plan['id_user']) . "',";
  $sql .= "'" . db_escape($db, $plan['descripcion']) . "',";
  $sql .= "'" . db_escape($db, $plan['precio_plan']) . "',";
  $sql .= "'" . db_escape($db, $plan['precio_normal']) . "',";
  $sql .= "'" . db_escape($db, $plan['promocion']) . "',";
  $sql .= "'" . db_escape($db, $plan['fecha_inicio']) . "',";
  $sql .= "'" . db_escape($db, $plan['fecha_fin']) . "',";
  $sql .= "'" . db_escape($db, $plan['horario']) . "',";
  $sql .= "'" . db_escape($db, $plan['horario_image']) . "',";
  $sql .= "'" . db_escape($db, $plan['profesor']) . "',";
  $sql .= "'" . db_escape($db, $plan['profesor_image']) . "',";
  $sql .= "'" . db_escape($db, $plan['statu']) . "'";
  $sql .= ")";

  echo $sql;

  mysqli_set_charset($db, "utf8");
  $result = mysqli_query($db, $sql);
  // For INSERT statements, $result is true/false
  if ($result) {
  return mysqli_insert_id($db);
  } else {
  // INSERT failed
  echo mysqli_error($db);
  db_disconnect($db);
  exit;
  }
  } */

function get_plan() {
    global $db;
    $activo = 1;
    $sql = "SELECT p.id,p.id_user,p.descripcion,p.precio_plan,p.precio_normal,p.promocion,p.horario,p.horario_foto,p.profesor,p.profesor_foto,p.estado,u.store as tienda , u.business_name as negocio ";
    $sql .= "FROM plan p ";
    $sql .= "LEFT JOIN users u on p.id_user = u.user_id ";
    $sql .= "WHERE estado='" . db_escape($db, $activo) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function actualizar_plan($plan) {
    global $db;
    $sql = "UPDATE plan SET ";
    $sql .= "id_user='" . db_escape($db, $plan['id_user']) . "', ";
    $sql .= "descripcion='" . db_escape($db, $plan['descripcion']) . "', ";
    $sql .= "precio_plan='" . db_escape($db, $plan['precio_plan']) . "', ";
    $sql .= "precio_normal='" . db_escape($db, $plan['precio_normal']) . "', ";
    $sql .= "promocion='" . db_escape($db, $plan['promocion']) . "', ";
    $sql .= "fecha_inicio='" . db_escape($db, $plan['fecha_inicio']) . "', ";
    $sql .= "fecha_fin='" . db_escape($db, $plan['fecha_fin']) . "', ";
    $sql .= "horario='" . db_escape($db, $plan['horario']) . "', ";
    $sql .= "horario_foto='" . db_escape($db, $plan['horario_image']) . "', ";
    $sql .= "profesor='" . db_escape($db, $plan['profesor']) . "', ";
    $sql .= "profesor_foto='" . db_escape($db, $plan['profesor_image']) . "', ";
    $sql .= "estado='" . db_escape($db, $plan['statu']) . "' ";
    $sql .= "WHERE id=" . db_escape($db, $plan['id']) . " ";
    $sql .= "LIMIT 1";

    echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function delete_plan_by_id($plan_id) {
    global $db;

    $sql = "DELETE FROM plan ";
    $sql .= "WHERE id='" . db_escape($db, $plan_id) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns an assoc. array
}

function get_descuentos() {
    global $db;
    $activo = 1;
    $sql = "SELECT p.id,p.id_user,p.nombre,p.descripcion,p.precio_normal,p.porcentaje,p.precio_descuento,p.promocion,p.fecha_inicio,p.fecha_fin,p.horario,p.horario_foto,p.profesor,p.profesor_foto,p.estado,u.store as tienda , u.business_name as negocio ";
    $sql .= "FROM descuentos p ";
    $sql .= "LEFT JOIN users u on p.id_user = u.user_id ";
    $sql .= "WHERE estado='" . db_escape($db, $activo) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function insert_descuento($descuento) {
    global $db;

    $sql = "INSERT INTO descuentos ";
    $sql .= "(id_user,nombre,descripcion,precio_normal,porcentaje,precio_descuento,promocion,fecha_inicio,fecha_fin,horario,horario_foto,profesor,profesor_foto,estado) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $descuento['id_user']) . "',";
    $sql .= "'" . db_escape($db, $descuento['nombre']) . "',";
    $sql .= "'" . db_escape($db, $descuento['descripcion']) . "',";
    $sql .= "'" . db_escape($db, $descuento['precio_normal']) . "',";
    $sql .= "'" . db_escape($db, $descuento['porcentaje']) . "',";
    $sql .= "'" . db_escape($db, $descuento['precio_descuento']) . "',";
    $sql .= "'" . db_escape($db, $descuento['promocion']) . "',";
    $sql .= "'" . db_escape($db, $descuento['fecha_inicio']) . "',";
    $sql .= "'" . db_escape($db, $descuento['fecha_fin']) . "',";
    $sql .= "'" . db_escape($db, $descuento['horario']) . "',";
    $sql .= "'" . db_escape($db, $descuento['horario_image']) . "',";
    $sql .= "'" . db_escape($db, $descuento['profesor']) . "',";
    $sql .= "'" . db_escape($db, $descuento['profesor_image']) . "',";
    $sql .= "'" . db_escape($db, $descuento['statu']) . "'";
    $sql .= ")";

    echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function actualizar_descuento($descuento) {
    global $db;
    $sql = "UPDATE descuentos SET ";
    $sql .= "id_user='" . db_escape($db, $descuento['id_user']) . "', ";
    $sql .= "nombre='" . db_escape($db, $descuento['nombre']) . "', ";
    $sql .= "descripcion='" . db_escape($db, $descuento['descripcion']) . "', ";
    $sql .= "precio_normal='" . db_escape($db, $descuento['precio_normal']) . "', ";
    $sql .= "porcentaje='" . db_escape($db, $descuento['porcentaje']) . "', ";
    $sql .= "precio_descuento='" . db_escape($db, $descuento['precio_descuento']) . "', ";
    $sql .= "promocion='" . db_escape($db, $descuento['promocion']) . "', ";
    $sql .= "fecha_inicio='" . db_escape($db, $descuento['fecha_inicio']) . "', ";
    $sql .= "fecha_fin='" . db_escape($db, $descuento['fecha_fin']) . "', ";
    $sql .= "horario='" . db_escape($db, $descuento['horario']) . "', ";
    $sql .= "horario_foto='" . db_escape($db, $descuento['horario_image']) . "', ";
    $sql .= "profesor='" . db_escape($db, $descuento['profesor']) . "', ";
    $sql .= "profesor_foto='" . db_escape($db, $descuento['profesor_image']) . "', ";
    $sql .= "estado='" . db_escape($db, $descuento['statu']) . "' ";
    $sql .= "WHERE id=" . db_escape($db, $descuento['id']) . " ";
    $sql .= "LIMIT 1";

//    echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function delete_descuento_by_id($descuento_id) {
    global $db;

    $sql = "DELETE FROM descuentos ";
    $sql .= "WHERE id='" . db_escape($db, $descuento_id) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns an assoc. array
}

function delete_estrategia_by_id($estrategia_id) {
    global $db;

    $sql = "DELETE FROM estrategia_ventas ";
    $sql .= "WHERE id='" . db_escape($db, $estrategia_id) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns an assoc. array
}

function get_usuario_tipo_servicio($user_id) {

    global $db;
    $sql = "SELECT * FROM users ";
    $sql .= "WHERE user_id=" . db_escape($db, $user_id) . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $usuario = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $usuario; // returns an assoc. array
}

function insert_usuario($usuario) {
    global $db;
    $sql = "INSERT INTO users ";
    $sql .= "(type,first_name,username,mobile,password,id_user_create,id_rol,alias,status) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $usuario['type']) . "',";
    $sql .= "'" . db_escape($db, $usuario['first_name']) . "',";
    $sql .= "'" . db_escape($db, $usuario['username']) . "',";
    $sql .= "'" . db_escape($db, $usuario['mobile']) . "',";
    $sql .= "'" . db_escape($db, $usuario['password']) . "',";
    $sql .= "'" . db_escape($db, $usuario['id_user_create']) . "',";
    $sql .= "'" . db_escape($db, $usuario['id_rol']) . "',";
    $sql .= "'" . db_escape($db, $usuario['alias']) . "',";
    $sql .= "'" . db_escape($db, $usuario['status']) . "'";
    $sql .= ")";

    echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function insert_permiso($modulo) {
    global $db;
    $sql = "INSERT INTO modulos ";
    $sql .= "(id_user_admin ,id_user_new,carro_compras) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $modulo['admin_id']) . "',";
    $sql .= "'" . db_escape($db, $modulo['id_user_new']) . "',";
    $sql .= "'" . db_escape($db, $modulo['carro_compras']) . "'";
    $sql .= ")";

    echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function insertar_rol($rol) {
    global $db;
    $sql = "INSERT INTO rol ";
    $sql .= "(id_user_admin,nombre,permiso,carro_compras,planes,descuentos,estrategia,ventas,productos_destacados,slider,politicas,estado) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $rol['admin_id']) . "',";
    $sql .= "'" . db_escape($db, $rol['nombre']) . "',";
    $sql .= "'" . db_escape($db, $rol['permiso']) . "',";
    $sql .= "'" . db_escape($db, $rol['carro_compras']) . "',";
    $sql .= "'" . db_escape($db, $rol['planes']) . "',";
    $sql .= "'" . db_escape($db, $rol['descuentos']) . "',";
    $sql .= "'" . db_escape($db, $rol['estrategia']) . "',";
    $sql .= "'" . db_escape($db, $rol['ventas']) . "',";
    $sql .= "'" . db_escape($db, $rol['productos_destacados']) . "',";
    $sql .= "'" . db_escape($db, $rol['slider']) . "',";
    $sql .= "'" . db_escape($db, $rol['politicas']) . "',";
    $sql .= "'" . db_escape($db, $rol['statu']) . "'";
    $sql .= ")";

// echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function get_usuario_modulo($user_id) {

    global $db;
    $sql = "SELECT * FROM modulos ";
    $sql .= "WHERE id_user_new =" . db_escape($db, $user_id) . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $usuario = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $usuario; // returns an assoc. array
}

function get_usuario_roles_permisos($user_id) {
    global $db;
    $sql = "SELECT u.user_id,u.type,u.id_user_create,u.id_rol,r.id_user_admin,r.permiso,r.carro_compras,r.planes,r.descuentos,r.estrategia,r.ventas,r.productos_destacados,r.slider,r.politicas,r.clientes ";
    $sql .= "FROM users u ";
    $sql .= "LEFT JOIN rol r on u.id_rol = r.id ";
    $sql .= "WHERE u.user_id='" . db_escape($db, $user_id) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $usuario = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $usuario; // returns an assoc. array
}

function get_usuarios_modulos($id_user_admin) {
    global $db;
    $sql = "SELECT m.id,u.first_name,u.business_name,u.mobile,u.rol,u.alias,u.permiso ";
    $sql .= "FROM modulos m ";
    $sql .= "LEFT JOIN users u on m.id_user_new = u.user_id ";
    $sql .= "WHERE m.id_user_admin='" . db_escape($db, $id_user_admin) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_usuarios_roles($id_user_admin) {
    global $db;
    $sql = "SELECT * FROM rol ";
    $sql .= "WHERE id_user_admin ='" . db_escape($db, $id_user_admin) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_usuarios_rol($id_user_admin) {
    global $db;
    $sql = "SELECT u.user_id,u.type,u.first_name,u.password,u.mobile,u.id_rol,u.id_user_create,u.alias,r.nombre ";
    $sql .= "FROM users u ";
    $sql .= "LEFT JOIN rol r on u.id_rol = r.id ";
    $sql .= "WHERE u.id_user_create='" . db_escape($db, $id_user_admin) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_row_by_id_user($id_user) {
    global $db;
    $sql = "SELECT u.user_id,u.type,u.first_name,u.password,u.mobile,u.id_rol,u.id_user_create,u.alias,u.status,r.nombre ";
    $sql .= "FROM users u ";
    $sql .= "LEFT JOIN rol r on u.id_rol = r.id ";
    $sql .= "WHERE u.user_id='" . db_escape($db, $id_user) . "' ";

    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $user_rol = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $user_rol; // returns an assoc. array
}

function get_row_by_id_rol($id_rol) {
    global $db;
    $sql = "SELECT * from rol ";
    $sql .= "WHERE id='" . db_escape($db, $id_rol) . "' ";

    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $user_rol = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $user_rol; // returns an assoc. array
}

function update_usuario_rol($usuario) {
    global $db;

    $sql = "UPDATE users SET ";
    $sql .= "first_name ='" . db_escape($db, $usuario['first_name']) . "', ";
    $sql .= "mobile ='" . db_escape($db, $usuario['mobile']) . "', ";
    $sql .= "password ='" . db_escape($db, $usuario['password']) . "', ";
    $sql .= "id_rol ='" . db_escape($db, $usuario['id_rol']) . "', ";
    $sql .= "alias ='" . db_escape($db, $usuario['alias']) . "', ";
    $sql .= "status='" . db_escape($db, $usuario['status']) . "' ";
    $sql .= "WHERE user_id=" . db_escape($db, $usuario['user_id']) . " ";
//$sql .= "LIMIT 1";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function find_usuario_by_id_rol($usuario_id) {
    global $db;

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE user_id='" . db_escape($db, $usuario_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $category = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $category; // returns an assoc. array
}

function update_rol_permisos($rol) {
    global $db;

    $sql = "UPDATE rol SET ";
    $sql .= "nombre='" . db_escape($db, $rol['nombre']) . "', ";
    $sql .= "permiso='" . db_escape($db, $rol['permiso']) . "', ";
    $sql .= "carro_compras='" . db_escape($db, $rol['carro_compras']) . "', ";
    $sql .= "planes='" . db_escape($db, $rol['planes']) . "', ";
    $sql .= "descuentos='" . db_escape($db, $rol['descuentos']) . "', ";
    $sql .= "estrategia='" . db_escape($db, $rol['estrategia']) . "', ";
    $sql .= "ventas='" . db_escape($db, $rol['ventas']) . "', ";
    $sql .= "productos_destacados='" . db_escape($db, $rol['productos_destacados']) . "', ";
    $sql .= "slider='" . db_escape($db, $rol['slider']) . "', ";
    $sql .= "politicas='" . db_escape($db, $rol['politicas']) . "', ";
    $sql .= "estado='" . db_escape($db, $rol['statu']) . "' ";
    $sql .= "WHERE id=" . db_escape($db, $rol['id']) . " ";
//$sql .= "LIMIT 1";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function find_rol_by_id($rol_id) {
    global $db;
    $sql = "SELECT * FROM rol ";
    $sql .= "WHERE id='" . db_escape($db, $rol_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $admin; // returns an assoc. array
}

function delete_rol_by_id($rol_id) {
    global $db;

    $sql = "DELETE FROM rol ";
    $sql .= "WHERE id='" . db_escape($db, $rol_id) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns an assoc. array
}

// CATALOGO

function find_catalogo_by_count_user($user_id) {
    global $db;
    $sql = "SELECT * FROM catalogo ";
    $sql .= " where  user_id='$user_id' ORDER BY id DESC ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_images_by_catalog_id($catalog_id) {
    global $db;

    $sql = "SELECT * FROM product_images_catalog ";
    $sql .= "WHERE catalogo_id=" . db_escape($db, $catalog_id) . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

// insertar catalogo

function insertar_catalogo($catalog) {
    global $db;
//
    $sql = "INSERT INTO catalogo ";
    $sql .= "(titulo,category,tipo_producto,user_id,image_name,price,precio_descuento,id_product_size,qty,
			porcentaje,descripcion,marca,link_video_one,link_video_two,fecha_registro,promocion,fecha_inicio,fecha_fin,status) ";
    $sql .= "VALUES (";

    $totales = $catalog['price'];
//$ptotales = $catalog['previous_price'];

    if (isset($catalog['title'])) {
        $tipo_prod = $catalog['title'];
    } else {
        $catalog['title'] = "";
    }

    if (isset($catalog['marca'])) {
        $marca = $catalog['marca'];
    } else {
        $marca = "";
    }

    if (isset($catalog['link_video_one'])) {
        $link_video_1 = $catalog['link_video_one'];
    } else {
        $link_video_1 = "";
    }

    if (isset($catalog['link_video_two'])) {
        $link_video_2 = $catalog['link_video_two'];
    } else {
        $link_video_2 = "";
    }


    if (isset($catalog['tipo_producto'])) {
        $tipo_prod = $catalog['tipo_producto'];
    } else {
        $catalog['tipo_producto'] = 0;
    }

    if (isset($catalog['porcentaje'])) {
        $porcentaje = $catalog['porcentaje'];
    } else {
        $catalog['porcentaje'] = 0;
    }

    if (isset($catalog['id_product_size'])) {
        $porcentaje = $catalog['id_product_size'];
    } else {
        $catalog['id_product_size'] = 0;
    }

    if (isset($catalog['fecha_inicio'])) {
        $fecha_inicio = $catalog['fecha_inicio'];
    } else {
        $catalog['fecha_inicio'] = "";
    }

    if (isset($catalog['fecha_fin'])) {
        $fecha_inicio = $catalog['fecha_fin'];
    } else {
        $catalog['fecha_fin'] = "";
    }

    if (isset($catalog['description'])) {
        $descripcion = $catalog['description'];
    } else {
        $catalog['description'] = "";
    }

    if (isset($catalog['fecha_registro'])) {
        $fecha_registro = $catalog['fecha_registro'];
    } else {
        $catalog['fecha_registro'] = "";
    }

    if (isset($catalog['promocion'])) {
        $promocion = $catalog['promocion'];
    } else {
        $catalog['promocion'] = "";
    }

    if (isset($catalog['previous_price'])) {
        $previousPrice = $catalog['previous_price'];
    } else {
        $previousPrice = 0;
    }
    echo $catalog['image_name'];
    $sql .= "'" . db_escape($db, $catalog['title']) . "',";
    $sql .= "" . db_escape($db, $catalog['category']) . ",";
    $sql .= "'" . db_escape($db, $catalog['tipo_producto']) . "' , ";
    $sql .= "'" . db_escape($db, $catalog['user_id']) . "', ";
    $sql .= "'" . db_escape($db, $catalog['image_name']) . "', ";
    $sql .= "" . db_escape($db, $catalog['price']) . ",";
    $sql .= "" . db_escape($db, $previousPrice) . ","; //Precio con descuento
    $sql .= "" . db_escape($db, $catalog['id_product_size']) . ",";
    $sql .= "" . db_escape($db, $catalog['qty']) . ",";
    $sql .= "'" . db_escape($db, $catalog['porcentaje']) . "',";
    $sql .= "'" . db_escape($db, $catalog['description']) . "',";
    $sql .= "'" . db_escape($db, $marca) . "',";
    $sql .= "'" . db_escape($db, $link_video_1) . "',";
    $sql .= "'" . db_escape($db, $link_video_2) . "',";
    $sql .= "'" . db_escape($db, $catalog['fecha_registro']) . "',";
    $sql .= "'" . db_escape($db, $catalog['promocion']) . "' , ";
    $sql .= "'" . db_escape($db, $catalog['fecha_inicio']) . "' , ";
    $sql .= "'" . db_escape($db, $catalog['fecha_fin']) . "' , ";
    $sql .= "'" . db_escape($db, $catalog['statu']) . "' ";
    $sql .= ")";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

// insertar arreglo de imagenes catalogo

function insert_catalog_images($catalog_images) {
    global $db;
    $sql = "INSERT INTO  product_images_catalog ";
    $sql .= "(image_name,catalogo_id) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $catalog_images['image_name']) . "',";
    $sql .= "" . db_escape($db, $catalog_images['catalogo_id']) . "";
    $sql .= ")";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function find_catalog_by_id($catalog_id) {
    global $db;

    $sql = "SELECT catalogo.*,
		(select gallery from users where user_id=catalogo.user_id) as gallery,
		(select store from users where user_id=catalogo.user_id)  as store,
		(select title from categories where id=catalogo.category)  as categoryname,
		(select tipo_tabla from categories where id=catalogo.category)  as tipotabla
		FROM catalogo 
		WHERE id='" . db_escape($db, $catalog_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $product = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $product; // returns an assoc. array
}

function get_images_by_array_catalog($catalog_id) {
    global $db;
    $sql = "SELECT * FROM  product_images_catalog ";
    $sql .= "WHERE catalogo_id=" . db_escape($db, $catalog_id) . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function update_catalog_images($product_images) {
    global $db;
    if ($product_images['image_name'] == "") {
        $sql = "UPDATE  product_images_catalog ";
        $sql .= "SET ";
//$sql .= "color_id ='" . db_escape($db, $product_images['id_color']) . "'";
        $sql .= " WHERE id =" . db_escape($db, $product_images['id_imagen']) . "";
    } else {
        $sql = "UPDATE product_images_catalog ";
        $sql .= "SET ";
        $sql .= "image_name ='" . db_escape($db, $product_images['image_name']) . "' ";
//$sql .= "color_id ='" . db_escape($db, $product_images['id_color']) . "'";
        $sql .= " WHERE id =" . db_escape($db, $product_images['id_imagen']) . "";
    }

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_catalog($product) {
    global $db;
    /* $sqlp = "SELECT COUNT(id) FROM catalogo where id='" . db_escape($db, $product['id']) . "'
      and price='" . db_escape($db, $product['price']) . "'";
      $resultp = mysqli_query($db, $sqlp);
      $count_p = mysqli_fetch_array($resultp);
      mysqli_free_result($resultp);
      $num_filap = $count_p[0]; */

//$sqlpp = "SELECT COUNT(id) FROM catalogo where id='" . db_escape($db, $product['id']) . "'
//	and previous_price='" . db_escape($db, $product['previous_price']) . "'";
//$resultpp = mysqli_query($db, $sqlpp);
//$count_pp = mysqli_fetch_array($resultpp);
//mysqli_free_result($resultpp);
//$num_filapp = $count_pp[0];

    if (isset($product['marca'])) {
        $marca = $product['marca'];
    } else {
        $marca = "";
    }

    if (isset($product['link_video_one'])) {
        $link_video_1 = $product['link_video_one'];
    } else {
        $link_video_1 = "";
    }

    if (isset($product['link_video_two'])) {
        $link_video_2 = $product['link_video_two'];
    } else {
        $link_video_2 = "";
    }


    $sql = "UPDATE catalogo SET ";
    $sql .= "titulo='" . db_escape($db, $product['title']) . "', ";
    $sql .= "category='" . db_escape($db, $product['category']) . "', ";
    $sql .= "tipo_producto='" . db_escape($db, $product['tipo_producto']) . "', ";
    $sql .= "price='" . db_escape($db, $product['price']) . "', ";
    $sql .= "precio_descuento='" . db_escape($db, $product['price_previous']) . "', ";
    $sql .= "id_product_size='" . db_escape($db, $product['id_product_size']) . "', ";
    $sql .= "qty='" . db_escape($db, $product['qty']) . "', ";
    $sql .= "porcentaje='" . db_escape($db, $product['descuento']) . "', ";
    $sql .= "descripcion='" . db_escape($db, $product['description']) . "', ";
    $sql .= "marca='" . db_escape($db, $marca) . "', ";
    $sql .= "link_video_one='" . db_escape($db, $link_video_1) . "', ";
    $sql .= "link_video_two='" . db_escape($db, $link_video_2) . "', ";
    $sql .= "promocion='" . db_escape($db, $product['promocion']) . "', ";
    $sql .= "fecha_inicio='" . db_escape($db, $product['inicio']) . "', ";
    $sql .= "image_name='" . db_escape($db, $product['image_name']) . "', ";
    $sql .= "fecha_fin='" . db_escape($db, $product['fin']) . "', ";


// Verifiso si actualizo foto talla

    /* if (!empty($product['fotos_talla'])) {
      $sql .= "fotos_talla='" . db_escape($db, $product['fotos_talla']) . "', ";
      } */


    /* if ($num_filapp == 0) {

      $previous_price = $product['previous_price'];

      $sql .= "previous_price='" . db_escape($db, $previous_price) . "', ";
      } */


    /* if ($num_filap == 0) {

      $price = $product['price'];

      $sql .= "price='" . db_escape($db, $price) . "', ";
      } */


//$sql .= "sort='" . db_escape($db, $product['sort']) . "', ";
//$sql .= "weight='" . db_escape($db, $product['weight']) . "', ";
//$sql .= "longs='" . db_escape($db, $product['longs']) . "', ";
//$sql .= "long_sleeve='" . db_escape($db, $product['long_sleeve']) . "', ";
//$sql .= "back_width='" . db_escape($db, $product['back_width']) . "', ";
//$sql .= "breast_contour='" . db_escape($db, $product['breast_contour']) . "', ";
//$sql .= "waist='" . db_escape($db, $product['waist']) . "', ";
//$sql .= "hip='" . db_escape($db, $product['hip']) . "', ";
    $sql .= "status='" . db_escape($db, $product['statu']) . "' ";
//$sql .= "brand='" . db_escape($db, $product['brand']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $product['id']) . "' ";
    $sql .= "LIMIT 1";
//echo$sql;
    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function delete_catalog_by_id($catalog_id) {
    global $db;

    $sql = "DELETE FROM catalogo ";
    $sql .= "WHERE id='" . db_escape($db, $catalog_id) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns an assoc. array
}

function delete_catalog_image_by_product($catalogo_id) {
    global $db;

    $sql = "DELETE FROM product_images_catalog ";
    $sql .= "WHERE catalogo_id=" . db_escape($db, $catalogo_id) . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns an assoc. array
}

// PLANES

function find_plan_by_count_user($user_id) {
    global $db;
    $sql = "SELECT * FROM plan ";
    $sql .= " where  user_id='$user_id'    ORDER BY id DESC ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_estrategia_by_count_user($user_id) {
    global $db;
    $sql = "SELECT * FROM estrategia_ventas ";
    $sql .= " where  user_id='$user_id'    ORDER BY id DESC ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_plan_by_id($plan_id) {
    global $db;

    $sql = "SELECT plan.*,
		(select gallery from users where user_id=plan.user_id) as gallery,
		(select store from users where user_id=plan.user_id)  as store,
		(select title from categories where id=plan.category)  as categoryname,
		(select tipo_tabla from categories where id=plan.category)  as tipotabla
		FROM plan 
		WHERE id='" . db_escape($db, $plan_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $product = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $product; // returns an assoc. array
}

function get_images_by_array_plan($plan_id) {
    global $db;
    $sql = "SELECT * FROM  product_images_plan ";
    $sql .= "WHERE plan_id=" . db_escape($db, $plan_id) . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function insertar_plan($plan) {
    global $db;
//
    $sql = "INSERT INTO plan ";
    /* $sql .= "(user_id,title,category,tipo_producto,image_name,descripcion,precio_plan,precio_normal,porcentaje,id_product_size,qty,
      promocion,fecha_inicio,fecha_fin,horario,horario_foto,profesor,profesor_foto,status) "; */

    $sql .= "(user_id,title,category,tipo_producto,image_name,descripcion,precio_plan,precio_normal,porcentaje,
			promocion,fecha_inicio,fecha_fin,horario,horario_foto,profesor,profesor_foto,link_video_one,link_video_two,status) ";

    $sql .= "VALUES (";


    if (isset($plan['title'])) {
        $title = $plan['title'];
    } else {
        $plan['title'] = "";
    }

    if (isset($plan['tipo_producto'])) {
        $tipo_prod = $plan['tipo_producto'];
    } else {
        $plan['tipo_producto'] = 0;
    }

    if (isset($plan['porcentaje'])) {
        $porcentaje = $plan['porcentaje'];
    } else {
        $plan['porcentaje'] = 0;
    }

    /* if (isset($plan['id_product_size'])) {
      $porcentaje = $plan['id_product_size'];
      } else {
      $plan['id_product_size'] = 0;
      } */

    if (isset($plan['fecha_inicio'])) {
        $fecha_inicio = $plan['fecha_inicio'];
    } else {
        $plan['fecha_inicio'] = "";
    }

    if (isset($plan['fecha_fin'])) {
        $fecha_inicio = $plan['fecha_fin'];
    } else {
        $plan['fecha_fin'] = "";
    }

    if (isset($plan['description'])) {
        $descripcion = $plan['description'];
    } else {
        $plan['description'] = "";
    }

    if (isset($plan['promocion'])) {
        $promocion = $plan['promocion'];
    } else {
        $plan['promocion'] = "";
    }

    if (isset($plan['link_video_one'])) {
        $link_video_1 = $plan['link_video_one'];
    } else {
        $link_video_1 = "";
    }

    if (isset($plan['link_video_two'])) {
        $link_video_2 = $plan['link_video_two'];
    } else {
        $link_video_2 = "";
    }

    $sql .= "'" . db_escape($db, $plan['user_id']) . "', ";
    $sql .= "'" . db_escape($db, $plan['title']) . "',";
    $sql .= "" . db_escape($db, $plan['category']) . ",";
    $sql .= "'" . db_escape($db, $plan['tipo_producto']) . "' , ";
    $sql .= "'" . db_escape($db, $plan['image_name']) . "', ";
    $sql .= "'" . db_escape($db, $plan['description']) . "',";
    $sql .= "" . db_escape($db, $plan['price_plan']) . ",";
    $sql .= "" . db_escape($db, $plan['price']) . ",";
    $sql .= "'" . db_escape($db, $plan['porcentaje']) . "',";
//$sql .= "" . db_escape($db, $plan['id_product_size']) . ",";
//$sql .= "" . db_escape($db, $plan['qty']) . ",";
    $sql .= "'" . db_escape($db, $plan['promocion']) . "' , ";
    $sql .= "'" . db_escape($db, $plan['fecha_inicio']) . "' , ";
    $sql .= "'" . db_escape($db, $plan['fecha_fin']) . "' , ";
    $sql .= "'" . db_escape($db, $plan['horario']) . "' , ";
    $sql .= "'" . db_escape($db, $plan['horario_image']) . "' , ";
    $sql .= "'" . db_escape($db, $plan['profesor']) . "' , ";
    $sql .= "'" . db_escape($db, $plan['profesor_image']) . "' ,  ";
    $sql .= "'" . db_escape($db, $link_video_1) . "' ,  ";
    $sql .= "'" . db_escape($db, $link_video_2) . "' ,  ";
    $sql .= "'" . db_escape($db, $plan['statu']) . "' ";
    $sql .= ")";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function insert_plan_images($plan_images) {
    global $db;
    $sql = "INSERT INTO  product_images_plan ";
    $sql .= "(image_name,plan_id) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $plan_images['image_name']) . "',";
    $sql .= "" . db_escape($db, $plan_images['plan_id']) . "";
    $sql .= ")";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function insert_estrategia_images($plan_images) {
    global $db;
    $sql = "INSERT INTO product_images_estrategias ";
    $sql .= "(image_name,estrategia_id) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $plan_images['image_name']) . "',";
    $sql .= "" . db_escape($db, $plan_images['estrategia_id']) . "";
    $sql .= ")";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function get_images_by_plan_id($plan_id) {
    global $db;

    $sql = "SELECT * FROM product_images_plan ";
    $sql .= "WHERE plan_id=" . db_escape($db, $plan_id) . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function update_plan_images($product_images) {
    global $db;
    if ($product_images['image_name'] == "") {
        $sql = "UPDATE  product_images_descuentos ";
        $sql .= "SET ";
//$sql .= "color_id ='" . db_escape($db, $product_images['id_color']) . "'";
        $sql .= " WHERE id =" . db_escape($db, $product_images['id_imagen']) . "";
    } else {
        $sql = "UPDATE product_images_plan ";
        $sql .= "SET ";
        $sql .= "image_name ='" . db_escape($db, $product_images['image_name']) . "' ";
//$sql .= "color_id ='" . db_escape($db, $product_images['id_color']) . "'";
        $sql .= " WHERE id =" . db_escape($db, $product_images['id_imagen']) . "";
    }

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_plan($product) {
    global $db;

    if (isset($product['link_video_one'])) {
        $link_video_1 = $product['link_video_one'];
    } else {
        $link_video_1 = "";
    }

    if (isset($product['link_video_two'])) {
        $link_video_2 = $product['link_video_two'];
    } else {
        $link_video_2 = "";
    }

    $sql = "UPDATE plan SET ";
    $sql .= "title='" . db_escape($db, $product['title']) . "', ";
    $sql .= "category='" . db_escape($db, $product['category']) . "', ";
    $sql .= "tipo_producto='" . db_escape($db, $product['tipo_producto']) . "', ";
    $sql .= "precio_plan='" . db_escape($db, $product['price_plan']) . "', ";
    $sql .= "precio_normal='" . db_escape($db, $product['price']) . "', ";
//$sql .= "id_product_size='" . db_escape($db, $product['id_product_size']) . "', ";
//$sql .= "qty='" . db_escape($db, $product['qty']) . "', ";
    $sql .= "porcentaje='" . db_escape($db, $product['descuento']) . "', ";
    $sql .= "descripcion='" . db_escape($db, $product['description']) . "', ";
    $sql .= "promocion='" . db_escape($db, $product['promocion']) . "', ";
    $sql .= "fecha_inicio='" . db_escape($db, $product['inicio']) . "', ";
//$sql .= "image_name='".db_escape($db, $product['image_name'])."', ";
    $sql .= "fecha_fin='" . db_escape($db, $product['fin']) . "', ";
    $sql .= "horario='" . db_escape($db, $product['horario']) . "', ";
    $sql .= "horario_foto='" . db_escape($db, $product['horario_image']) . "', ";
    $sql .= "profesor='" . db_escape($db, $product['profesor']) . "', ";
    $sql .= "profesor_foto='" . db_escape($db, $product['profesor_image']) . "', ";
    $sql .= "link_video_one='" . db_escape($db, $link_video_1) . "', ";
    $sql .= "link_video_two='" . db_escape($db, $link_video_2) . "', ";
    $sql .= "status='" . db_escape($db, $product['statu']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $product['id']) . "' ";
    $sql .= "LIMIT 1";
//echo$sql;
    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function delete_plan_image_by_product($plan_id) {
    global $db;

    $sql = "DELETE FROM product_images_plan ";
    $sql .= "WHERE plan_id=" . db_escape($db, $plan_id) . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns an assoc. array
}

function find_descuentos_by_count_user($user_id) {
    global $db;

    $sql = "SELECT * FROM descuentos ";
    $sql .= " where  user_id='$user_id'    ORDER BY id DESC ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_images_by_descuento_id($descuento_id) {
    global $db;

    $sql = "SELECT * FROM product_images_descuentos ";
    $sql .= "WHERE descuento_id=" . db_escape($db, $descuento_id) . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_images_by_array_descuento($descuento_id) {
    global $db;
    $sql = "SELECT * FROM  product_images_descuentos ";
    $sql .= "WHERE descuento_id=" . db_escape($db, $descuento_id) . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_descuento_by_id($descuento_id) {
    global $db;

    $sql = "SELECT descuentos.*,
		(select gallery from users where user_id=descuentos.user_id) as gallery,
		(select store from users where user_id=descuentos.user_id)  as store,
		(select title from categories where id=descuentos.category)  as categoryname,
		(select tipo_tabla from categories where id=descuentos.category)  as tipotabla
		FROM descuentos
		WHERE id='" . db_escape($db, $descuento_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $product = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $product; // returns an assoc. array
}

function find_estrategia_by_del_id($estrategia_id) {
    global $db;

    $sql = "SELECT * FROM estrategia_ventas ";
    $sql .= " WHERE id='" . db_escape($db, $estrategia_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $resultado = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $resultado; // returns an assoc. array
}

function insertar_descuento($descuento) {
    global $db;
//
    $sql = "INSERT INTO descuentos ";
    $sql .= "(user_id,title,category,tipo_producto,image_name,descripcion,marca,precio_descuento,precio_normal,porcentaje,id_product_size,qty,
			promocion,fecha_inicio,fecha_fin,horario,horario_foto,profesor,profesor_foto,link_video_one,link_video_two,status) ";
    $sql .= "VALUES (";


    if (isset($descuento['title'])) {
        $title = $descuento['title'];
    } else {
        $descuento['title'] = "";
    }

    if (isset($descuento['tipo_producto'])) {
        $tipo_prod = $descuento['tipo_producto'];
    } else {
        $descuento['tipo_producto'] = 0;
    }

    if (isset($descuento['porcentaje'])) {
        $porcentaje = $descuento['porcentaje'];
    } else {
        $descuento['porcentaje'] = 0;
    }

    if (isset($descuento['id_product_size'])) {
        $id_product_size = $descuento['id_product_size'];
    } else {
        $descuento['id_product_size'] = 0;
    }

    if (isset($descuento['fecha_inicio'])) {
        $fecha_inicio = $descuento['fecha_inicio'];
    } else {
        $descuento['fecha_inicio'] = "";
    }

    if (isset($descuento['fecha_fin'])) {
        $fecha_inicio = $descuento['fecha_fin'];
    } else {
        $descuento['fecha_fin'] = "";
    }

    if (isset($descuento['description'])) {
        $descripcion = $descuento['description'];
    } else {
        $descuento['description'] = "";
    }

    if (isset($descuento['promocion'])) {
        $promocion = $descuento['promocion'];
    } else {
        $descuento['promocion'] = "";
    }

    if (isset($descuento['marca'])) {
        $marca = $descuento['marca'];
    } else {
        $marca = "";
    }

    if (isset($descuento['link_video_one'])) {
        $link_video_1 = $descuento['link_video_one'];
    } else {
        $link_video_1 = "";
    }

    if (isset($descuento['link_video_two'])) {
        $link_video_2 = $descuento['link_video_two'];
    } else {
        $link_video_2 = "";
    }

    $sql .= "'" . db_escape($db, $descuento['user_id']) . "', ";
    $sql .= "'" . db_escape($db, $descuento['title']) . "',";
    $sql .= "" . db_escape($db, $descuento['category']) . ",";
    $sql .= "'" . db_escape($db, $descuento['tipo_producto']) . "' , ";
    $sql .= "'" . db_escape($db, $descuento['image_name']) . "', ";
    $sql .= "'" . db_escape($db, $descuento['description']) . "',";
    $sql .= "'" . db_escape($db, $marca) . "',";
    $sql .= "" . db_escape($db, $descuento['price_descuento']) . ",";
    $sql .= "" . db_escape($db, $descuento['price']) . ",";
    $sql .= "'" . db_escape($db, $descuento['porcentaje']) . "',";
    $sql .= "" . db_escape($db, $descuento['id_product_size']) . ",";
    $sql .= "" . db_escape($db, $descuento['qty']) . ",";
    $sql .= "'" . db_escape($db, $descuento['promocion']) . "' , ";
    $sql .= "'" . db_escape($db, $descuento['fecha_inicio']) . "' , ";
    $sql .= "'" . db_escape($db, $descuento['fecha_fin']) . "' , ";
    $sql .= "'" . db_escape($db, $descuento['horario']) . "' , ";
    $sql .= "'" . db_escape($db, $descuento['horario_image']) . "' , ";
    $sql .= "'" . db_escape($db, $descuento['profesor']) . "' , ";
    $sql .= "'" . db_escape($db, $descuento['profesor_image']) . "' ,  ";
    $sql .= "'" . db_escape($db, $link_video_1) . "' ,  ";
    $sql .= "'" . db_escape($db, $link_video_2) . "' ,  ";
    $sql .= "'" . db_escape($db, $descuento['statu']) . "' ";
    $sql .= ")";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function insert_descuentos_images($descuento_images) {
    global $db;
    $sql = "INSERT INTO  product_images_descuentos ";
    $sql .= "(image_name,descuento_id) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $descuento_images['image_name']) . "',";
    $sql .= "" . db_escape($db, $descuento_images['descuento_id']) . "";
    $sql .= ")";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_descuento_images($product_images) {
    global $db;

    if ($product_images['image_name'] == "") {
        $sql = "UPDATE  product_images_descuentos ";
        $sql .= "SET ";
//$sql .= "color_id ='" . db_escape($db, $product_images['id_color']) . "'";
        $sql .= " WHERE id =" . db_escape($db, $product_images['id_imagen']) . "";
    } else {
        $sql = "UPDATE product_images_descuentos ";
        $sql .= "SET ";
        $sql .= "image_name ='" . db_escape($db, $product_images['image_name']) . "' ";
//$sql .= "color_id ='" . db_escape($db, $product_images['id_color']) . "'";
        $sql .= " WHERE id =" . db_escape($db, $product_images['id_imagen']) . "";
    }

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_descuento($descuento) {
    global $db;

    if (isset($descuento['title'])) {
        $title = $descuento['title'];
    } else {
        $descuento['title'] = "";
    }

    if (isset($descuento['tipo_producto'])) {
        $tipo_prod = $descuento['tipo_producto'];
    } else {
        $descuento['tipo_producto'] = 0;
    }

    if (isset($descuento['porcentaje'])) {
        $porcentaje = $descuento['porcentaje'];
    } else {
        $descuento['porcentaje'] = 0;
    }

    if (isset($descuento['id_product_size'])) {
        $id_product_size = $descuento['id_product_size'];
    } else {
        $descuento['id_product_size'] = 0;
    }

    if (isset($descuento['fecha_inicio'])) {
        $fecha_inicio = $descuento['fecha_inicio'];
    } else {
        $descuento['fecha_inicio'] = "";
    }

    if (isset($descuento['fecha_fin'])) {
        $fecha_inicio = $descuento['fecha_fin'];
    } else {
        $descuento['fecha_fin'] = "";
    }

    if (isset($descuento['description'])) {
        $descripcion = $descuento['description'];
    } else {
        $descuento['description'] = "";
    }

    if (isset($descuento['promocion'])) {
        $promocion = $descuento['promocion'];
    } else {
        $descuento['promocion'] = "";
    }

    if (isset($descuento['horario'])) {
        $horario = $descuento['horario'];
    } else {
        $descuento['horario'] = "";
    }

    if (isset($descuento['profesor'])) {
        $profesor = $descuento['profesor'];
    } else {
        $descuento['profesor'] = "";
    }

    if (isset($descuento['horario_image'])) {
        $horario_image = $descuento['horario_image'];
    } else {
        $descuento['horario_image'] = "";
    }

    if (isset($descuento['profesor_image'])) {
        $profesor_image = $descuento['profesor_image'];
    } else {
        $descuento['profesor_image'] = "";
    }

    if (isset($descuento['marca'])) {
        $marca = $descuento['marca'];
    } else {
        $marca = "";
    }

    if (isset($descuento['link_video_one'])) {
        $link_video_1 = $descuento['link_video_one'];
    } else {
        $link_video_1 = "";
    }

    if (isset($descuento['link_video_two'])) {
        $link_video_2 = $descuento['link_video_two'];
    } else {
        $link_video_2 = "";
    }

    $sql = "UPDATE descuentos SET ";
    $sql .= "title='" . db_escape($db, $descuento['title']) . "', ";
    $sql .= "category='" . db_escape($db, $descuento['category']) . "', ";
    $sql .= "tipo_producto='" . db_escape($db, $descuento['tipo_producto']) . "', ";
    $sql .= "precio_descuento='" . db_escape($db, $descuento['price_descuento']) . "', ";
    $sql .= "precio_normal='" . db_escape($db, $descuento['price']) . "', ";
    $sql .= "id_product_size='" . db_escape($db, $descuento['id_product_size']) . "', ";
    $sql .= "qty='" . db_escape($db, $descuento['qty']) . "', ";
    $sql .= "porcentaje='" . db_escape($db, $descuento['descuento']) . "', ";
    $sql .= "descripcion='" . db_escape($db, $descuento['description']) . "', ";
    $sql .= "marca='" . db_escape($db, $marca) . "', ";
    $sql .= "promocion='" . db_escape($db, $descuento['promocion']) . "', ";
    $sql .= "fecha_inicio='" . db_escape($db, $descuento['inicio']) . "', ";
//$sql .= "image_name='".db_escape($db, $product['image_name'])."', ";
    $sql .= "fecha_fin='" . db_escape($db, $descuento['fin']) . "', ";
    $sql .= "horario='" . db_escape($db, $descuento['horario']) . "', ";
    $sql .= "horario_foto='" . db_escape($db, $descuento['horario_image']) . "', ";
    $sql .= "profesor='" . db_escape($db, $descuento['profesor']) . "', ";
    $sql .= "profesor_foto='" . db_escape($db, $descuento['profesor_image']) . "', ";
    $sql .= "link_video_one='" . db_escape($db, $link_video_1) . "', ";
    $sql .= "link_video_two='" . db_escape($db, $link_video_2) . "', ";
    $sql .= "status='" . db_escape($db, $descuento['statu']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $descuento['id']) . "' ";
    $sql .= "LIMIT 1";
//echo$sql;
    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function delete_descuento_image_by_product($descuento_id) {
    global $db;

    $sql = "DELETE FROM product_images_descuentos ";
    $sql .= "WHERE descuento_id=" . db_escape($db, $descuento_id) . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns an assoc. array
}

//ESTRATEGIA DE VENTAS

function get_images_by_estrategia_id($estrategia_id) {
    global $db;

    $sql = "SELECT * FROM product_images_estrategias ";
    $sql .= "WHERE estrategia_id=" . db_escape($db, $estrategia_id) . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function insertar_estrategia($estrategia) {
    global $db;
//
    $sql = "INSERT INTO estrategia_ventas ";
    $sql .= "(user_id,title,category,tipo_producto,image_name,descripcion,marca,tipo_promocion,precio_normal,precio_oferta,precio_paquete,id_product_size,id_product_images,id_product_mitad_precio,id_product_dos_uno,qty,
			promocion,fecha_inicio,fecha_fin,horario,horario_foto,profesor,profesor_foto,link_video_one,link_video_two,status) ";
    $sql .= "VALUES (";


    if (isset($estrategia['title'])) {
        $title = $estrategia['title'];
    } else {
        $estrategia['title'] = "";
    }

    if (isset($estrategia['tipo_producto'])) {
        $tipo_prod = $estrategia['tipo_producto'];
    } else {
        $estrategia['tipo_producto'] = 0;
    }

    if (isset($estrategia['porcentaje'])) {
        $porcentaje = $estrategia['porcentaje'];
    } else {
        $estrategia['porcentaje'] = 0;
    }

    if (isset($estrategia['id_product_size'])) {
        $tamano = $estrategia['id_product_size'];
    } else {
        $estrategia['id_product_size'] = 0;
    }

    if (isset($estrategia['id_product_images'])) {
        $cortesia = $estrategia['id_product_images'];
    } else {
        $estrategia['id_product_images'] = 0;
    }

    if (isset($estrategia['fecha_inicio'])) {
        $fecha_inicio = $estrategia['fecha_inicio'];
    } else {
        $estrategia['fecha_inicio'] = "";
    }

    if (isset($estrategia['fecha_fin'])) {
        $fecha_inicio = $estrategia['fecha_fin'];
    } else {
        $estrategia['fecha_fin'] = "";
    }

    if (isset($estrategia['description'])) {
        $descripcion = $estrategia['description'];
    } else {
        $estrategia['description'] = "";
    }

    if (isset($estrategia['marca'])) {
        $marca = $estrategia['marca'];
    } else {
        $marca = "";
    }

    if (isset($estrategia['link_video_one'])) {
        $link_video_1 = $estrategia['link_video_one'];
    } else {
        $link_video_1 = "";
    }

    if (isset($estrategia['link_video_two'])) {
        $link_video_2 = $estrategia['link_video_two'];
    } else {
        $link_video_2 = "";
    }

    /* if (isset($estrategia['promocion'])) {
      $promocion = $estrategia['promocion'];
      } else {
      $promocion = $estrategia['promocion'] = 2;
      } */

    $precio_oferta = "";
    $precio_paquete = "";

    /* if (isset($estrategia['price_oferta'])) {
      $precio_oferta = $estrategia['price_oferta'];
      } else {
      $estrategia['price_oferta'] = 0;
      } */

    /* if (isset($estrategia['price_paquete'])) {


      $precio_paquete = $estrategia['price_paquete'];
      } else {
      $estrategia['price_paquete'] = 0;
      $precio_paquete = 0;
      } */

    /* if (isset($estrategia['price_oferta'])) {
      $precio_oferta = $estrategia['price_oferta'];
      } else {
      $precio_oferta=0;

      }

      if (isset($estrategia['price_paquete'])) {
      $precio_paquete = $estrategia['price_paquete'];
      } else {
      $precio_paquete=0;
      } */

    /* if (is_null($estrategia['price_paquete'])) {
      $precio_paquete = 0;
      } else {
      $precio_paquete = $estrategia['price_paquete'];
      } */

    /*
      if (is_null($estrategia['price_oferta'])) {
      $precio_oferta = 0;
      } else {
      $precio_oferta = $estrategia['price_oferta'];
      } */

    $sql .= "'" . db_escape($db, $estrategia['user_id']) . "', ";
    $sql .= "'" . db_escape($db, $estrategia['title']) . "',";
    $sql .= "" . db_escape($db, $estrategia['category']) . ",";
    $sql .= "'" . db_escape($db, $estrategia['tipo_producto']) . "' , ";
    $sql .= "'" . db_escape($db, $estrategia['image_name']) . "', ";
    $sql .= "'" . db_escape($db, $estrategia['description']) . "',";
    $sql .= "'" . db_escape($db, $marca) . "',";
    $sql .= "'" . db_escape($db, $estrategia['tipo_promocion']) . "', ";
    $sql .= "" . db_escape($db, $estrategia['price']) . ",";
//$sql .= "" . db_escape($db, $estrategia['precio_oferta']) . "',";
    $sql .= "" . db_escape($db, $estrategia['price_oferta']) . ",";
    $sql .= "" . db_escape($db, $estrategia['price_paquete']) . ",";

    $sql .= "" . db_escape($db, $estrategia['id_product_size']) . ",";
    $sql .= "" . db_escape($db, $estrategia['id_product_images']) . ",";
    $sql .= "" . db_escape($db, $estrategia['id_product_mitad_precio']) . ",";
    $sql .= "" . db_escape($db, $estrategia['id_product_dos_uno']) . ",";
    $sql .= "" . db_escape($db, $estrategia['qty']) . ",";
    $sql .= " " . db_escape($db, $estrategia['promocion']) . ",";
    $sql .= "'" . db_escape($db, $estrategia['fecha_inicio']) . "' , ";
    $sql .= "'" . db_escape($db, $estrategia['fecha_fin']) . "' , ";
    $sql .= "'" . db_escape($db, $estrategia['horario']) . "' , ";
    $sql .= "'" . db_escape($db, $estrategia['horario_image']) . "' , ";
    $sql .= "'" . db_escape($db, $estrategia['profesor']) . "' , ";
    $sql .= "'" . db_escape($db, $estrategia['profesor_image']) . "' ,  ";
    $sql .= "'" . db_escape($db, $link_video_1) . "' ,  ";
    $sql .= "'" . db_escape($db, $link_video_2) . "' ,  ";
    $sql .= " " . db_escape($db, $estrategia['statu']) . " ";
    $sql .= ")";

    echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

// Lista de productos por usuario

function get_products_sales_by_product_user($user_id) {
    global $db;
    $tipo_producto = 1;
    $sql = "SELECT pm.id, pm.product_id, p.title,p.price,p.tipo_producto , p.user_id ";
    $sql .= "FROM product_images as pm ";
    $sql .= "LEFT JOIN products  as p on pm.product_id = p.id ";
    $sql .= "WHERE user_id=" . db_escape($db, $user_id) . "  ";
    $sql .= "AND p.tipo_producto=" . db_escape($db, $tipo_producto) . "  ";

//echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_products_sales_by_product_user_cortesia($user_id) {
    global $db;
    $tipo_producto = 1;
    $sql = "SELECT * FROM products ";
    $sql .= "WHERE user_id=" . db_escape($db, $user_id) . "  ";
    $sql .= "AND tipo_producto=" . db_escape($db, $tipo_producto) . "  ";

    //echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

//CLIENTES

function find_clientes_by_usuario($user_id) {
    global $db;
    $estado = 1;
    $sql = "SELECT * FROM clientes ";
    $sql .= "WHERE user_id='" . db_escape($db, $user_id) . "' ";
    $sql .= "AND status='" . db_escape($db, $estado) . "' ";

    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_clientes_by_id($cliente_id) {
    global $db;

    $sql = "SELECT * FROM clientes ";
    $sql .= "WHERE id='" . db_escape($db, $cliente_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $cliente = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $cliente; // returns an assoc. array
}

function insert_cliente($cliente) {
    global $db;

    $sql = "INSERT INTO clientes ";
    $sql .= "(user_id,codigo, nombres,celular,email,direccion,image_name,status) ";
    $sql .= "VALUES (";
    $sql .= "" . db_escape($db, $cliente['user_id']) . ",";
    $sql .= "'" . db_escape($db, $cliente['codigo']) . "',";
    $sql .= "'" . db_escape($db, $cliente['nombres']) . "',";
    $sql .= "" . db_escape($db, $cliente['celular']) . ",";
    $sql .= "'" . db_escape($db, $cliente['email']) . "',";
    $sql .= "'" . db_escape($db, $cliente['direccion']) . "',";
    $sql .= "'" . db_escape($db, $cliente['image_name']) . "',";
    $sql .= "'" . db_escape($db, $cliente['status']) . "'";
    $sql .= ")";

    echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_clientes($cliente) {
    global $db;

    $sql = "UPDATE clientes SET ";
    $sql .= "codigo='" . db_escape($db, $cliente['codigo']) . "', ";
    $sql .= "nombres='" . db_escape($db, $cliente['nombres']) . "', ";
    $sql .= "celular=" . db_escape($db, $cliente['celular']) . ", ";
    $sql .= "email='" . db_escape($db, $cliente['email']) . "', ";
    $sql .= "direccion='" . db_escape($db, $cliente['direccion']) . "', ";
    $sql .= "image_name='" . db_escape($db, $cliente['image_name']) . "', ";
    $sql .= "status='" . db_escape($db, $cliente['status']) . "' ";
    $sql .= "WHERE id=" . db_escape($db, $cliente['id']) . " ";
    $sql .= "LIMIT 1";

//echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function delete_cliente_by_id($cliente_id) {
    global $db;

    $sql = "DELETE FROM clientes ";
    $sql .= "WHERE id='" . db_escape($db, $cliente_id) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns an assoc. array
}

function insert_info_cliente($cliente) {
    global $db;

    $sql = "INSERT INTO info_tecnica ";
    $sql .= "(user_id,cliente_id,fecha,	fecha_inicio_rutina,fecha_fin_rutina,frecuencia_rutina,image_rutina,image_dieta,status) ";
    $sql .= "VALUES (";
    $sql .= "" . db_escape($db, $cliente['user_id']) . ",";
    $sql .= "" . db_escape($db, $cliente['cliente_id']) . ",";
    $sql .= "'" . db_escape($db, $cliente['fecha']) . "',";
    $sql .= "'" . db_escape($db, $cliente['fecha_inicio_rutina']) . "',";
    $sql .= "'" . db_escape($db, $cliente['fecha_fin_rutina']) . "',";
    $sql .= "'" . db_escape($db, $cliente['frecuencia_rutina']) . "',";
    $sql .= "'" . db_escape($db, $cliente['image_rutina']) . "',";
    $sql .= "'" . db_escape($db, $cliente['image_dieta']) . "',";
    $sql .= "'" . db_escape($db, $cliente['status']) . "'";
    $sql .= ")";

    echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

//SUCURSALES

function find_sucursal_by_usuario($user_id) {
    global $db;
    $estado = 1;
    $sql = "SELECT * FROM sucursal ";
    $sql .= "WHERE user_id='" . db_escape($db, $user_id) . "' ";
    //$sql .= "AND status='" . db_escape($db, $estado) . "' ";

    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_sucursal_by_id($sucursal_id) {
    global $db;

    $sql = "SELECT * FROM sucursal ";
    $sql .= "WHERE id='" . db_escape($db, $sucursal_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $cliente = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $cliente; // returns an assoc. array
}

//ENVIOS

function find_envio_by_usuario($user_id) {
    global $db;
    $estado = 1;
    $sql = "SELECT envios.id,envios.user_id,envios.sucursal_id,envios.distrito,";
    $sql .= "envios.precio ,envios.status,sucursal.nombre as sucursales  ";
    $sql .= "FROM envios ";
    $sql .= "LEFT JOIN sucursal ON envios.sucursal_id = sucursal.id ";
    $sql .= "WHERE envios.user_id='" . db_escape($db, $user_id) . "' ";
    $sql .= "AND envios.status='" . db_escape($db, $estado) . "' ";
    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_envio_by_id($envio_id) {
    global $db;
    $sql = "SELECT * FROM envios ";
    $sql .= "WHERE id='" . db_escape($db, $envio_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $cliente = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $cliente; // returns an assoc. array
}

//INFO TECNICAS

function find_info_clientes_by_usuario($user_id) {
    global $db;
    $estado = 1;
    $sql = "SELECT info.id , info.user_id,info.cliente_id,info.fecha,info.image_rutina,info.image_dieta,info.status,cl.codigo,cl.nombres,cl.celular,cl.email,cl.direccion,cl.image_name ";
    $sql .= "FROM info_tecnica as info ";
    $sql .= "LEFT JOIN clientes  as cl on info.cliente_id = cl.id ";
    $sql .= "WHERE info.user_id=" . db_escape($db, $user_id) . "  ";
    $sql .= "AND info.status='" . db_escape($db, $estado) . "' ";

    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function insert_progreso_cliente($cliente) {
    global $db;

    $sql = "INSERT INTO progreso_cliente ";
    $sql .= "(user_id,cliente_id,fecha,asunto,detalle,progreso_image,progreso_fisico_image,status) ";
    $sql .= "VALUES (";
    $sql .= "" . db_escape($db, $cliente['user_id']) . ",";
    $sql .= "" . db_escape($db, $cliente['cliente_id']) . ",";
    $sql .= "'" . db_escape($db, $cliente['fecha']) . "',";
    $sql .= "'" . db_escape($db, $cliente['asunto']) . "',";
    $sql .= "'" . db_escape($db, $cliente['detalle']) . "',";
    $sql .= "'" . db_escape($db, $cliente['progreso_image']) . "',";
    $sql .= "'" . db_escape($db, $cliente['progreso_fisico_image']) . "',";
    $sql .= "'" . db_escape($db, $cliente['status']) . "'";
    $sql .= ")";

    echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function find_info_progreso_clientes_by_usuario($user_id) {
    global $db;
    $estado = 1;
    $sql = "SELECT info.id , info.user_id,info.cliente_id,info.fecha,info.asunto,info.detalle,info.progreso_image,info.progreso_fisico_image,info.status,cl.codigo,cl.nombres,cl.celular,cl.email,cl.direccion,cl.image_name ";
    $sql .= "FROM progreso_cliente as info ";
    $sql .= "LEFT JOIN clientes  as cl on info.cliente_id = cl.id ";
    $sql .= "WHERE info.user_id=" . db_escape($db, $user_id) . "  ";
    $sql .= "AND info.status='" . db_escape($db, $estado) . "' ";

    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

//informacion tecnica - update

function find_info_tecnica_clientes_by_id($info_id) {
    global $db;
    $estado = 1;
    $sql = "SELECT info.id , info.user_id,info.cliente_id,info.fecha,info.fecha_inicio_rutina,info.fecha_fin_rutina,info.frecuencia_rutina,info.image_rutina,info.image_dieta,info.status,cl.codigo,cl.nombres,cl.celular,cl.email,cl.direccion,cl.image_name ";
    $sql .= "FROM info_tecnica as info ";
    $sql .= "LEFT JOIN clientes  as cl on info.cliente_id = cl.id ";
    $sql .= "WHERE info.id=" . db_escape($db, $info_id) . "  ";
    $sql .= "AND info.status='" . db_escape($db, $estado) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $cliente = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $cliente; // returns an assoc. array
}

function update_info_tecnica_clientes($info) {
    global $db;

    $sql = "UPDATE info_tecnica SET ";
    $sql .= "fecha_inicio_rutina='" . db_escape($db, $info['fecha_inicio_rutina']) . "', ";
    $sql .= "fecha_fin_rutina='" . db_escape($db, $info['fecha_fin_rutina']) . "', ";
    $sql .= "frecuencia_rutina='" . db_escape($db, $info['frecuencia_rutina']) . "', ";
    $sql .= "image_rutina='" . db_escape($db, $info['image_rutina']) . "', ";
    $sql .= "image_dieta='" . db_escape($db, $info['image_dieta']) . "', ";
    $sql .= "status='" . db_escape($db, $info['status']) . "' ";
    $sql .= "WHERE id=" . db_escape($db, $info['id']) . " ";
    $sql .= "LIMIT 1";

//echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function delete_info_tecnica_cliente_by_id($info_id) {
    global $db;

    $sql = "DELETE FROM info_tecnica ";
    $sql .= "WHERE id='" . db_escape($db, $info_id) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns an assoc. array
}

function find_progreso_tecnica_clientes_by_id($progreso_id) {
    global $db;
    $estado = 1;
    $sql = "SELECT info.id ,info.user_id,info.cliente_id,info.fecha,info.asunto,info.detalle,info.progreso_image,info.progreso_fisico_image,info.status,cl.codigo,cl.nombres,cl.celular,cl.email,cl.direccion,cl.image_name ";
    $sql .= "FROM progreso_cliente as info ";
    $sql .= "LEFT JOIN clientes  as cl on info.cliente_id = cl.id ";
    $sql .= "WHERE info.id=" . db_escape($db, $progreso_id) . "  ";
    $sql .= "AND info.status='" . db_escape($db, $estado) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $cliente = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $cliente; // returns an assoc. array
}

function update_progreso_fisico_clientes($progreso) {
    global $db;

    $sql = "UPDATE progreso_cliente SET ";
    $sql .= "progreso_image='" . db_escape($db, $progreso['progreso_image']) . "', ";
    $sql .= "progreso_fisico_image='" . db_escape($db, $progreso['progreso_fisico_image']) . "', ";
    $sql .= "asunto='" . db_escape($db, $progreso['asunto']) . "', ";
    $sql .= "detalle='" . db_escape($db, $progreso['detalle']) . "', ";
    $sql .= "status='" . db_escape($db, $progreso['status']) . "' ";
    $sql .= "WHERE id=" . db_escape($db, $progreso['id']) . " ";
    $sql .= "LIMIT 1";

//echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function delete_progreso_fisico_cliente_by_id($progreso_id) {
    global $db;

    $sql = "DELETE FROM progreso_cliente ";
    $sql .= "WHERE id='" . db_escape($db, $progreso_id) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns an assoc. array
}

function get_images_by_array_estrategia($estrategia_id) {
    global $db;
    $sql = "SELECT * FROM   product_images_estrategias ";
    $sql .= "WHERE estrategia_id=" . db_escape($db, $estrategia_id) . " ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function insert_estrategia_ventas_images($estrategia_images) {
    global $db;
    $sql = "INSERT INTO product_images_estrategias ";
    $sql .= "(image_name,estrategia_id) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $estrategia_images['image_name']) . "',";
    $sql .= "" . db_escape($db, $estrategia_images['estrategia_id']) . "";
    $sql .= ")";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function find_user_by_rubro_gym($user_id) {
    global $db;

    $sql = "SELECT u.user_id , u.cod_rubro , r.codigo,u.cod_tipo_servicio ";
    $sql .= "FROM users as u ";
    $sql .= "LEFT JOIN rubro as r on u.cod_rubro = r.id ";
    $sql .= "WHERE user_id='" . db_escape($db, $user_id) . "' ";

    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function service_usuario_id($id_user) {
    global $db;

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE user_id='" . db_escape($db, $id_user) . "' ";

    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function find_estrategia_venta_by_id($estrategia_id) {
    global $db;
    $sql = "SELECT estrategia_ventas.*,
		(select gallery from users where user_id=estrategia_ventas.user_id) as gallery,
		(select store from users where user_id=estrategia_ventas.user_id)  as store,
		(select title from categories where id=estrategia_ventas.category)  as categoryname,
		(select tipo_tabla from categories where id=estrategia_ventas.category)  as tipotabla
		FROM estrategia_ventas 
		WHERE id='" . db_escape($db, $estrategia_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $product = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $product; // returns an assoc. array
}

function update_estrategia_images($product_images) {
    global $db;

    if ($product_images['image_name'] == "") {
        $sql = "UPDATE  product_images_estrategias ";
        $sql .= "SET ";
//$sql .= "color_id ='" . db_escape($db, $product_images['id_color']) . "'";
        $sql .= " WHERE id =" . db_escape($db, $product_images['id_imagen']) . "";
    } else {
        $sql = "UPDATE product_images_estrategias ";
        $sql .= "SET ";
        $sql .= "image_name ='" . db_escape($db, $product_images['image_name']) . "' ";
//$sql .= "color_id ='" . db_escape($db, $product_images['id_color']) . "'";
        $sql .= " WHERE id =" . db_escape($db, $product_images['id_imagen']) . "";
    }

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
// For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
// INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_estrategia_venta($estrategia) {
    global $db;

    if (isset($estrategia['title'])) {
        $title = $estrategia['title'];
    } else {
        $estrategia['title'] = "";
    }

    if (isset($estrategia['tipo_producto'])) {
        $tipo_prod = $estrategia['tipo_producto'];
    } else {
        $estrategia['tipo_producto'] = 0;
    }

    if (isset($estrategia['porcentaje'])) {
        $porcentaje = $estrategia['porcentaje'];
    } else {
        $estrategia['porcentaje'] = 0;
    }

    if (isset($estrategia['id_product_size'])) {
        $id_product_size = $estrategia['id_product_size'];
    } else {
        $estrategia['id_product_size'] = 0;
    }

    if (isset($estrategia['fecha_inicio'])) {
        $fecha_inicio = $estrategia['fecha_inicio'];
    } else {
        $estrategia['fecha_inicio'] = "";
    }

    if (isset($estrategia['fecha_fin'])) {
        $fecha_inicio = $estrategia['fecha_fin'];
    } else {
        $estrategia['fecha_fin'] = "";
    }

    if (isset($estrategia['description'])) {
        $descripcion = $estrategia['description'];
    } else {
        $estrategia['description'] = "";
    }

    if (isset($estrategia['promocion'])) {
        $promocion = $estrategia['promocion'];
    } else {
        $estrategia['promocion'] = "";
    }

    if (isset($estrategia['horario'])) {
        $horario = $estrategia['horario'];
    } else {
        $estrategia['horario'] = "";
    }

    if (isset($estrategia['profesor'])) {
        $profesor = $estrategia['profesor'];
    } else {
        $estrategia['profesor'] = "";
    }

    if (isset($estrategia['horario_image'])) {
        $horario_image = $estrategia['horario_image'];
    } else {
        $estrategia['horario_image'] = "";
    }

    if (isset($estrategia['profesor_image'])) {
        $profesor_image = $estrategia['profesor_image'];
    } else {
        $estrategia['profesor_image'] = "";
    }

    if (isset($estrategia['marca'])) {
        $marca = $estrategia['marca'];
    } else {
        $marca = "";
    }

    if (isset($estrategia['link_video_one'])) {
        $link_video_1 = $estrategia['link_video_one'];
    } else {
        $link_video_1 = "";
    }

    if (isset($estrategia['link_video_two'])) {
        $link_video_2 = $estrategia['link_video_two'];
    } else {
        $link_video_2 = "";
    }

    $sql = "UPDATE estrategia_ventas SET ";
    $sql .= "title='" . db_escape($db, $estrategia['title']) . "', ";
    $sql .= "category='" . db_escape($db, $estrategia['category']) . "', ";
    $sql .= "tipo_producto='" . db_escape($db, $estrategia['tipo_producto']) . "', ";
    $sql .= "descripcion='" . db_escape($db, $estrategia['description']) . "', ";
    $sql .= "marca='" . db_escape($db, $marca) . "', ";
    $sql .= "tipo_promocion='" . db_escape($db, $estrategia['tipo_promocion']) . "', ";
    $sql .= "precio_normal='" . db_escape($db, $estrategia['price']) . "', ";
    $sql .= "precio_oferta='" . db_escape($db, $estrategia['price_oferta']) . "', ";
    $sql .= "precio_paquete='" . db_escape($db, $estrategia['price_paquete']) . "', ";
    $sql .= "id_product_size='" . db_escape($db, $estrategia['id_product_size']) . "', ";
    $sql .= "id_product_images='" . db_escape($db, $estrategia['id_product_images']) . "', ";
    $sql .= "id_product_dos_uno='" . db_escape($db, $estrategia['id_product_dos_uno']) . "', ";
    $sql .= "qty='" . db_escape($db, $estrategia['qty']) . "', ";
    $sql .= "promocion='" . db_escape($db, $estrategia['promocion']) . "', ";
    $sql .= "fecha_inicio='" . db_escape($db, $estrategia['fecha_inicio']) . "', ";
//$sql .= "image_name='".db_escape($db, $estrategia['image_name'])."', ";
    $sql .= "fecha_fin='" . db_escape($db, $estrategia['fecha_fin']) . "', ";
    $sql .= "horario='" . db_escape($db, $estrategia['horario']) . "', ";
    $sql .= "horario_foto='" . db_escape($db, $estrategia['horario_image']) . "', ";
    $sql .= "profesor='" . db_escape($db, $estrategia['profesor']) . "', ";
    $sql .= "profesor_foto='" . db_escape($db, $estrategia['profesor_image']) . "', ";
    $sql .= "link_video_one='" . db_escape($db, $link_video_1) . "', ";
    $sql .= "link_video_two='" . db_escape($db, $link_video_2) . "', ";
    $sql .= "status='" . db_escape($db, $estrategia['statu']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $estrategia['id']) . "' ";
    $sql .= "LIMIT 1";
//echo$sql;
    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
// For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
// UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

//DIETAS

function find_dietas_by_count_user($user_id) {
    global $db;

    $sql = "SELECT * FROM dieta ";
    $sql .= " where  user_id='$user_id'    ORDER BY id DESC ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_row_by_id_dieta($id_dieta) {
    global $db;
    $sql = "SELECT * FROM dieta ";
    $sql .= " where  id='$id_dieta'    ORDER BY id DESC ";

    mysqli_set_charset($db, "utf8");

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $user_rol = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $user_rol; // returns an assoc. array
}

function insertar_dieta($dieta) {
    global $db;
    $sql = "INSERT INTO dieta ";
    $sql .= "(user_id,tipo_dieta,nombre_dieta,dias_semana,duracion_dieta,fecha_inicio,fecha_fin,alumno,disciplina,alergias,edad,enfermedad_cronica,alergia_medicamento,status) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $dieta['user_id']) . "',";
    $sql .= "'" . db_escape($db, $dieta['tipo_dieta']) . "',";
    $sql .= "'" . db_escape($db, $dieta['nombre']) . "',";
    $sql .= "'" . db_escape($db, $dieta['dias']) . "',";
    $sql .= "'" . db_escape($db, $dieta['duracion']) . "',";
    $sql .= "'" . db_escape($db, $dieta['fecha_inicio']) . "',";
    $sql .= "'" . db_escape($db, $dieta['fecha_fin']) . "',";
    $sql .= "'" . db_escape($db, $dieta['alumno']) . "',";
    $sql .= "'" . db_escape($db, $dieta['disciplina']) . "',";
    $sql .= "'" . db_escape($db, $dieta['alergias']) . "',";
    $sql .= "'" . db_escape($db, $dieta['edad']) . "',";
    $sql .= "'" . db_escape($db, $dieta['enfermedad_cronica']) . "',";
    $sql .= "'" . db_escape($db, $dieta['alergia_medicamento']) . "',";
    $sql .= "'" . db_escape($db, $dieta['statu']) . "'";
    $sql .= ")";

    // echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
        // INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function count_get_dieta_detalle($dieta_id) {
    global $db;
    $sql = "SELECT COUNT(*) AS countDetalleDieta FROM dieta_detalle ";
    $sql .= "WHERE dieta_id='" . db_escape($db, $dieta_id) . "' ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $fav_count = mysqli_fetch_array($result);
    mysqli_free_result($result);
    return $fav_count[0]; // returns an assoc. array
}

function get_detail_dietas_by_dieta($dieta_id) {
    global $db;

    $sql = "SELECT * FROM dieta_detalle ";
    $sql .= " where  dieta_id='$dieta_id'    ORDER BY id DESC ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function update_dieta($dieta) {
    global $db;

    $sql = "UPDATE dieta SET ";
    $sql .= "user_id='" . db_escape($db, $dieta['user_id']) . "', ";
    $sql .= "tipo_dieta='" . db_escape($db, $dieta['tipo_dieta']) . "', ";
    $sql .= "nombre_dieta='" . db_escape($db, $dieta['nombre']) . "', ";
    $sql .= "dias_semana='" . db_escape($db, $dieta['dias']) . "', ";
    $sql .= "duracion_dieta='" . db_escape($db, $dieta['duracion']) . "', ";
    $sql .= "fecha_inicio='" . db_escape($db, $dieta['fecha_inicio']) . "', ";
    $sql .= "fecha_fin='" . db_escape($db, $dieta['fecha_fin']) . "', ";
    $sql .= "alumno='" . db_escape($db, $dieta['alumno']) . "', ";
    $sql .= "disciplina='" . db_escape($db, $dieta['disciplina']) . "', ";
    $sql .= "alergias='" . db_escape($db, $dieta['alergias']) . "', ";
    $sql .= "edad='" . db_escape($db, $dieta['edad']) . "', ";
    $sql .= "enfermedad_cronica='" . db_escape($db, $dieta['enfermedad_cronica']) . "', ";
    $sql .= "alergia_medicamento='" . db_escape($db, $dieta['alergia_medicamento']) . "', ";
    $sql .= "status='" . db_escape($db, $dieta['statu']) . "' ";
    $sql .= "WHERE id=" . db_escape($db, $dieta['id']) . " ";
    //$sql .= "LIMIT 1";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_dieta_detalle($dieta) {
    global $db;
    $sql = "UPDATE dieta_detalle SET ";
    $sql .= "user_id='" . db_escape($db, $dieta['user_id']) . "', ";
    $sql .= "dia_dieta='" . db_escape($db, $dieta['dia_dieta']) . "', ";
    $sql .= "tipo_comida='" . db_escape($db, $dieta['tipo_comida']) . "', ";
    $sql .= "nombre_comida='" . db_escape($db, $dieta['nombre_comida']) . "', ";
    $sql .= "hora='" . db_escape($db, $dieta['hora']) . "', ";
    $sql .= "descripcion='" . db_escape($db, $dieta['descripcion']) . "', ";
    $sql .= "recomendacion='" . db_escape($db, $dieta['recomendacion']) . "', ";
    $sql .= "image_name='" . db_escape($db, $dieta['image_name']) . "' ";
    $sql .= "WHERE id=" . db_escape($db, $dieta['id']) . " ";
    //$sql .= "LIMIT 1";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function get_row_by_id_dieta_detail($id_dieta_detail) {
    global $db;
    $sql = "SELECT * FROM dieta_detalle ";
    $sql .= " where  id='$id_dieta_detail'    ORDER BY id ASC ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function delete_detalle_dieta_by_id($dieta_detalle_id) {
    global $db;

    $sql = "DELETE FROM dieta_detalle ";
    $sql .= "WHERE id='" . db_escape($db, $dieta_detalle_id) . "' ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function delete_dieta($id) {
    global $db;

    $sql = "DELETE FROM dieta ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function insert_dieta_detalle($dieta) {
    global $db;
    $status = 1;
    $sql = "INSERT INTO dieta_detalle ";
    $sql .= "(dieta_id,user_id,dia_dieta,tipo_comida,nombre_comida,hora,descripcion,image_name,recomendacion,status) ";
    $sql .= "VALUES (";
    $sql .= "" . db_escape($db, $dieta['dieta_id']) . ",";
    $sql .= "'" . db_escape($db, $dieta['user_id']) . "',";
    $sql .= "'" . db_escape($db, $dieta['dia_dieta']) . "',";
    $sql .= "'" . db_escape($db, $dieta['tipo_comida']) . "',";
    $sql .= "'" . db_escape($db, $dieta['nombre_comida']) . "',";
    $sql .= "'" . db_escape($db, $dieta['hora']) . "',";
    $sql .= "'" . db_escape($db, $dieta['descripcion']) . "',";
    $sql .= "'" . db_escape($db, $dieta['image_name']) . "',";
    $sql .= "'" . db_escape($db, $dieta['recomendacion']) . "',";
    $sql .= "'" . db_escape($db, $status) . "'";
    $sql .= ")";

    //echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
        // INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function json_obtener_tienda_id($id_user) {
    global $db;
    $sql = "SELECT * FROM users ";
    $sql .= "WHERE user_id='" . db_escape($db, $id_user) . "' ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function obtener_catalogo_user_categoria_servicio($user_id) {
    global $db;
    $sql = "SELECT * FROM catalogo ";
    $sql .= " where user_id='$user_id' and category=2 ORDER BY id DESC ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function obtener_catalogo_user_categoria_producto($user_id) {
    global $db;
    $sql = "SELECT * FROM catalogo ";
    $sql .= " where user_id='$user_id' and category=1 ORDER BY id DESC ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

//Servicios JSON CATALOGO DESCUENTO : PRODUCTO / SERVICIO

function obtener_catalogo_descuento_producto($user_id) {
    global $db;
    $sql = "SELECT * FROM descuentos ";
    $sql .= " where  user_id='$user_id' and category='1' ORDER BY id DESC ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function obtener_catalogo_descuento_servicio($user_id) {
    global $db;
    $sql = "SELECT * FROM descuentos ";
    $sql .= " where  user_id='$user_id' and category='2' ORDER BY id DESC ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_catalogo_by_id($id) {
    global $db;
    $sql = "SELECT * FROM catalogo ";
    $sql .= " where  id='$id' ORDER BY id DESC ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_productos_images_catalog_by_id($catalog_id) {
    global $db;
    $sql = "SELECT * FROM product_images_catalog ";
    $sql .= " where  catalogo_id='$catalog_id' ORDER BY id DESC ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_plan_by_id($id) {
    global $db;
    $sql = "SELECT * FROM plan ";
    $sql .= " where  id='$id' ORDER BY id DESC ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_productos_images_plan_by_id($Plan_id) {
    global $db;
    $sql = "SELECT * FROM product_images_plan ";
    $sql .= " where  plan_id='$Plan_id' ORDER BY id DESC ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_estrategia_by_id($id) {
    global $db;
    $sql = "SELECT * FROM estrategia_ventas";
    $sql .= " where id='$id' ORDER BY id DESC ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_productos_images_estrategia_by_id($estrategia_id) {
    global $db;
    $sql = "SELECT * FROM product_images_estrategias ";
    $sql .= " where  estrategia_id='$estrategia_id' ORDER BY id DESC ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_descuentos_by_id($id) {
    global $db;
    $sql = "SELECT * FROM descuentos";
    $sql .= " where id='$id' ORDER BY id DESC ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_productos_images_descuentos_by_id($descuentos_id) {
    global $db;
    $sql = "SELECT * FROM product_images_descuentos ";
    $sql .= " where  descuento_id='$descuentos_id' ORDER BY id DESC ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}
// NO ELIMINAR
function get_videos_by_user_id($user_id) {
    global $db;
    $sql = "SELECT * FROM settings_videos ";
    $sql .= " where user_id='$user_id' ORDER BY id DESC ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}


/* -------------------- Servicios flutter ------------------- */

function get_info_gym($id_tienda) {
    global $db;
    $sql = "SELECT user_id ,business_name,image_name ";
    $sql .= "from users ";
    $sql .= "WHERE user_id='" . db_escape($db, $id_tienda) . "' ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
//$rows['datos'] = $row;
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}
//NO ELIMINAR
function get_info_gym_screen($id_tienda) {
    global $db;
    $sql = "SELECT * ";
    $sql .= "from screen ";
    $sql .= "WHERE id_tienda='" . db_escape($db, $id_tienda) . "' ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}
//NO ELIMINAR
function get_info_gym_slider($id_tienda) {
    global $db;
    $sql = "SELECT * ";
    $sql .= "from slider ";
    $sql .= "WHERE id_user='" . db_escape($db, $id_tienda) . "' ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}
//NO ELIMINAR
function get_categories_by_rubro($cod_rubro) {
    global $db;
    $sql = "SELECT * ";
    $sql .= "from categories ";
    $sql .= "WHERE id_rubro='" . db_escape($db, $cod_rubro) . "' ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}
// NO ELIMINAR
function get_carro_cabecera_products($user_id) {
    global $db;
    $sql = "SELECT * FROM products ";
//$sql .= " where user_id='$user_id' and category=2 ORDER BY id DESC ";
    $sql .= " where user_id='$user_id' ORDER BY id DESC ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_cabecera_plan($user_id) {
    global $db;
    $sql = "SELECT * FROM plan ";
//$sql .= " where user_id='$user_id' and category=2 ORDER BY id DESC ";
    $sql .= " where user_id='$user_id' ORDER BY id DESC ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_cabecera_descuentos($user_id) {
    global $db;
    $sql = "SELECT * FROM descuentos ";
//$sql .= " where user_id='$user_id' and category=2 ORDER BY id DESC ";
    $sql .= " where user_id='$user_id' ORDER BY id DESC ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_cabecera_estrategias($user_id) {
    global $db;
    $sql = "SELECT * FROM estrategia_ventas ";
//$sql .= " where user_id='$user_id' and category=2 ORDER BY id DESC ";
    $sql .= " where user_id='$user_id' ORDER BY id DESC ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_cabecera_catalogo($user_id) {
    global $db;
    $sql = "SELECT * FROM catalogo ";
    $sql .= " where user_id='$user_id' ORDER BY id DESC ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}
//NO ELIMINAR
function get_clientes_by_tienda($user_id) {
    global $db;
    $sql = "SELECT * FROM clientes ";
//$sql .= " where user_id='$user_id' and category=2 ORDER BY id DESC ";
    $sql .= " where user_id='$user_id' ORDER BY id DESC ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}
// NO ELIMINAR
function get_sucursales_by_tienda($user_id) {
    global $db;
    $sql = "SELECT * FROM sucursal ";
    $sql .= " where user_id='$user_id' ORDER BY id DESC ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}
//NO ELIMINAR
function get_envios_by_tienda($user_id) {
    global $db;
    $sql = "SELECT envios.id,envios.sucursal_id,envios.user_id,envios.distrito,envios.precio,sucursal.nombre ";
    $sql .= " FROM envios";
    $sql .= " LEFT JOIN sucursal on envios.sucursal_id = sucursal.id ";
    $sql .= " where envios.user_id='$user_id' ORDER BY id DESC ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}
// NO ELIMINAR
function get_dietas_by_tienda($user_id) {
    global $db;
    $sql = "SELECT * ";
    $sql .= " FROM dieta";
    //$sql .= " LEFT JOIN sucursal on envios.sucursal_id = sucursal.id ";
    $sql .= " where user_id='$user_id' ORDER BY id DESC ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}
//NO ELIMINAR
function get_carro_detalle_images_products($product_id) {
    global $db;
    $sql = "SELECT * FROM product_images ";
    $sql .= " where  product_id='$product_id' ORDER BY id DESC ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

/* * ***PUBLICACIONES******* */

function find_all_publicaciones($tipoSeccion = 'publicacion', $desdeWs = false, $user_id = '') {
    global $db;

    $sql = "SELECT * FROM publicaciones ";
    $sql .= "WHERE tipo_seccion = '$tipoSeccion'";
    $sql .= " ORDER BY id DESC ";
    if ($desdeWs) {
        $sql = "SELECT * FROM publicaciones ";
        $sql .= "WHERE user_id='$user_id'";
        $sql .= " ORDER BY id DESC ";
    }

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];

    // Generar la URL base automáticamente
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $base_url = "$protocol://$host/public/uploads/publicaciones/";

    $fields_to_update = [
        'imagen',
        'adjunto1_1_imagen',
        'adjunto1_2_imagen',
        'adjunto2_1_imagen',
        'adjunto2_2_imagen',
        'adjunto3_1_imagen',
        'adjunto3_2_imagen'
    ];

    while ($row = mysqli_fetch_assoc($result)) {

        if ($desdeWs) {
            foreach ($fields_to_update as $field) {
                if (!empty($row[$field])) {
                    $row[$field] = $base_url . $row[$field];
                }
            }
        }
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function insert_publicacion($publicacion) {
    global $db;

    // Check and assign default values if necessary
    $titulo = isset($publicacion['titulo']) ? $publicacion['titulo'] : "";
    $imagen = isset($publicacion['imagen']) ? $publicacion['imagen'] : "";
    $estado = isset($publicacion['estado']) ? $publicacion['estado'] : "";
    $tipo_seccion = isset($publicacion['tipo_seccion']) ? $publicacion['tipo_seccion'] : "";
    $resumen = isset($publicacion['resumen']) ? $publicacion['resumen'] : "";
    $link_video = isset($publicacion['link_video']) ? $publicacion['link_video'] : "";
    $categoria = isset($publicacion['categoria']) ? $publicacion['categoria'] : "";
    $current_date = isset($publicacion['current_date']) ? $publicacion['current_date'] : "";
    $user_id = isset($publicacion['user_id']) ? $publicacion['user_id'] : "";

    $subtitulo1 = isset($publicacion['subtitulo1']) ? $publicacion['subtitulo1'] : "";
    $descripcion1 = isset($publicacion['descripcion1']) ? $publicacion['descripcion1'] : "";
    $tipo_adjunto1_1 = isset($publicacion['tipo_adjunto1_1']) ? $publicacion['tipo_adjunto1_1'] : "";
    $adjunto1_1_imagen = isset($publicacion['adjunto1_1_imagen']) ? $publicacion['adjunto1_1_imagen'] : "";
    $adjunto1_1_video = isset($publicacion['adjunto1_1_video']) ? $publicacion['adjunto1_1_video'] : "";
    $tipo_adjunto1_2 = isset($publicacion['tipo_adjunto1_2']) ? $publicacion['tipo_adjunto1_2'] : "";
    $adjunto1_2_imagen = isset($publicacion['adjunto1_2_imagen']) ? $publicacion['adjunto1_2_imagen'] : "";
    $adjunto1_2_video = isset($publicacion['adjunto1_2_video']) ? $publicacion['adjunto1_2_video'] : "";

    $subtitulo2 = isset($publicacion['subtitulo2']) ? $publicacion['subtitulo2'] : "";
    $descripcion2 = isset($publicacion['descripcion2']) ? $publicacion['descripcion2'] : "";
    $tipo_adjunto2_1 = isset($publicacion['tipo_adjunto2_1']) ? $publicacion['tipo_adjunto2_1'] : "";
    $adjunto2_1_imagen = isset($publicacion['adjunto2_1_imagen']) ? $publicacion['adjunto2_1_imagen'] : "";
    $adjunto2_1_video = isset($publicacion['adjunto2_1_video']) ? $publicacion['adjunto2_1_video'] : "";
    $tipo_adjunto2_2 = isset($publicacion['tipo_adjunto2_2']) ? $publicacion['tipo_adjunto2_2'] : "";
    $adjunto2_2_imagen = isset($publicacion['adjunto2_2_imagen']) ? $publicacion['adjunto2_2_imagen'] : "";
    $adjunto2_2_video = isset($publicacion['adjunto2_2_video']) ? $publicacion['adjunto2_2_video'] : "";


    $subtitulo3 = isset($publicacion['subtitulo3']) ? $publicacion['subtitulo3'] : "";
    $descripcion3 = isset($publicacion['descripcion3']) ? $publicacion['descripcion3'] : "";
    $tipo_adjunto3_1 = isset($publicacion['tipo_adjunto3_1']) ? $publicacion['tipo_adjunto3_1'] : "";
    $adjunto3_1_imagen = isset($publicacion['adjunto3_1_imagen']) ? $publicacion['adjunto3_1_imagen'] : "";
    $adjunto3_1_video = isset($publicacion['adjunto3_1_video']) ? $publicacion['adjunto3_1_video'] : "";
    $tipo_adjunto3_2 = isset($publicacion['tipo_adjunto3_2']) ? $publicacion['tipo_adjunto3_2'] : "";
    $adjunto3_2_imagen = isset($publicacion['adjunto3_2_imagen']) ? $publicacion['adjunto3_2_imagen'] : "";
    $adjunto3_2_video = isset($publicacion['adjunto3_2_video']) ? $publicacion['adjunto3_2_video'] : "";



    $sql = "INSERT INTO publicaciones (titulo, imagen, estado, tipo_seccion,
    categoria, resumen, link_video, user_id,
    subtitulo1, descripcion1, 
    tipo_adjunto1_1, adjunto1_1_imagen, adjunto1_1_video, 
    tipo_adjunto1_2, adjunto1_2_imagen, adjunto1_2_video,

    subtitulo2, descripcion2, 
    tipo_adjunto2_1, adjunto2_1_imagen, adjunto2_1_video, 
    tipo_adjunto2_2, adjunto2_2_imagen, adjunto2_2_video,

    subtitulo3, descripcion3, 
    tipo_adjunto3_1, adjunto3_1_imagen, adjunto3_1_video, 
    tipo_adjunto3_2, adjunto3_2_imagen, adjunto3_2_video,

    fecha_creacion
    ) VALUES (";

    $sql .= "'" . db_escape($db, $titulo) . "',";
    $sql .= "'" . db_escape($db, $imagen) . "',";
    $sql .= "'" . db_escape($db, $estado) . "',";
    $sql .= "'" . db_escape($db, $tipo_seccion) . "',";
    $sql .= "'" . db_escape($db, $categoria) . "',";
    $sql .= "'" . db_escape($db, $resumen) . "',";
    $sql .= "'" . db_escape($db, $link_video) . "',";
    $sql .= "'" . db_escape($db, $user_id) . "',";

    $sql .= "'" . db_escape($db, $subtitulo1) . "',";
    $sql .= "'" . db_escape($db, $descripcion1) . "',";
    $sql .= "'" . db_escape($db, $tipo_adjunto1_1) . "',";
    $sql .= "'" . db_escape($db, $adjunto1_1_imagen) . "',";
    $sql .= "'" . db_escape($db, $adjunto1_1_video) . "',";
    $sql .= "'" . db_escape($db, $tipo_adjunto1_2) . "',";
    $sql .= "'" . db_escape($db, $adjunto1_2_imagen) . "',";
    $sql .= "'" . db_escape($db, $adjunto1_2_video) . "',";

    $sql .= "'" . db_escape($db, $subtitulo2) . "',";
    $sql .= "'" . db_escape($db, $descripcion2) . "',";
    $sql .= "'" . db_escape($db, $tipo_adjunto2_1) . "',";
    $sql .= "'" . db_escape($db, $adjunto2_1_imagen) . "',";
    $sql .= "'" . db_escape($db, $adjunto2_1_video) . "',";
    $sql .= "'" . db_escape($db, $tipo_adjunto2_2) . "',";
    $sql .= "'" . db_escape($db, $adjunto2_2_imagen) . "',";
    $sql .= "'" . db_escape($db, $adjunto2_2_video) . "',";

    $sql .= "'" . db_escape($db, $subtitulo3) . "',";
    $sql .= "'" . db_escape($db, $descripcion3) . "',";
    $sql .= "'" . db_escape($db, $tipo_adjunto3_1) . "',";
    $sql .= "'" . db_escape($db, $adjunto3_1_imagen) . "',";
    $sql .= "'" . db_escape($db, $adjunto3_1_video) . "',";
    $sql .= "'" . db_escape($db, $tipo_adjunto3_2) . "',";
    $sql .= "'" . db_escape($db, $adjunto3_2_imagen) . "',";
    $sql .= "'" . db_escape($db, $adjunto3_2_video) . "',";

    $sql .= "'" . db_escape($db, $current_date) . "'";

    $sql .= ")";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);

    if ($result) {
        return mysqli_insert_id($db);
    } else {
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_publicacion($publicacion) {
    global $db;

    // Ensure the id is provided
    if (!isset($publicacion['id'])) {
        return "ID is required to update the record.";
    }

    $id = $publicacion['id'];

    // Define the fields that we may update
    $fields = [
        'titulo' => isset($publicacion['titulo']) ? $publicacion['titulo'] : null,
        'imagen' => isset($publicacion['imagen']) ? $publicacion['imagen'] : null,
        'estado' => isset($publicacion['estado']) ? $publicacion['estado'] : null,
        'tipo_seccion' => isset($publicacion['tipo_seccion']) ? $publicacion['tipo_seccion'] : null,
        'categoria' => isset($publicacion['categoria']) ? $publicacion['categoria'] : null,
        'resumen' => isset($publicacion['resumen']) ? $publicacion['resumen'] : null,
        'link_video' => isset($publicacion['link_video']) ? $publicacion['link_video'] : null,
        'subtitulo1' => isset($publicacion['subtitulo1']) ? $publicacion['subtitulo1'] : null,
        'descripcion1' => isset($publicacion['descripcion1']) ? $publicacion['descripcion1'] : null,
        'tipo_adjunto1_1' => isset($publicacion['tipo_adjunto1_1']) ? $publicacion['tipo_adjunto1_1'] : null,
        'adjunto1_1_imagen' => isset($publicacion['adjunto1_1_imagen']) ? $publicacion['adjunto1_1_imagen'] : null,
        'adjunto1_1_video' => isset($publicacion['adjunto1_1_video']) ? $publicacion['adjunto1_1_video'] : null,
        'tipo_adjunto1_2' => isset($publicacion['tipo_adjunto1_2']) ? $publicacion['tipo_adjunto1_2'] : null,
        'adjunto1_2_imagen' => isset($publicacion['adjunto1_2_imagen']) ? $publicacion['adjunto1_2_imagen'] : null,
        'adjunto1_2_video' => isset($publicacion['adjunto1_2_video']) ? $publicacion['adjunto1_2_video'] : null,
        'subtitulo2' => isset($publicacion['subtitulo2']) ? $publicacion['subtitulo2'] : null,
        'descripcion2' => isset($publicacion['descripcion2']) ? $publicacion['descripcion2'] : null,
        'tipo_adjunto2_1' => isset($publicacion['tipo_adjunto2_1']) ? $publicacion['tipo_adjunto2_1'] : null,
        'adjunto2_1_imagen' => isset($publicacion['adjunto2_1_imagen']) ? $publicacion['adjunto2_1_imagen'] : null,
        'adjunto2_1_video' => isset($publicacion['adjunto2_1_video']) ? $publicacion['adjunto2_1_video'] : null,
        'tipo_adjunto2_2' => isset($publicacion['tipo_adjunto2_2']) ? $publicacion['tipo_adjunto2_2'] : null,
        'adjunto2_2_imagen' => isset($publicacion['adjunto2_2_imagen']) ? $publicacion['adjunto2_2_imagen'] : null,
        'adjunto2_2_video' => isset($publicacion['adjunto2_2_video']) ? $publicacion['adjunto2_2_video'] : null,
        'subtitulo3' => isset($publicacion['subtitulo3']) ? $publicacion['subtitulo3'] : null,
        'descripcion3' => isset($publicacion['descripcion3']) ? $publicacion['descripcion3'] : null,
        'tipo_adjunto3_1' => isset($publicacion['tipo_adjunto3_1']) ? $publicacion['tipo_adjunto3_1'] : null,
        'adjunto3_1_imagen' => isset($publicacion['adjunto3_1_imagen']) ? $publicacion['adjunto3_1_imagen'] : null,
        'adjunto3_1_video' => isset($publicacion['adjunto3_1_video']) ? $publicacion['adjunto3_1_video'] : null,
        'tipo_adjunto3_2' => isset($publicacion['tipo_adjunto3_2']) ? $publicacion['tipo_adjunto3_2'] : null,
        'adjunto3_2_imagen' => isset($publicacion['adjunto3_2_imagen']) ? $publicacion['adjunto3_2_imagen'] : null,
        'adjunto3_2_video' => isset($publicacion['adjunto3_2_video']) ? $publicacion['adjunto3_2_video'] : null,
    ];

    // Filter out null values
    $fields = array_filter($fields, function ($value) {
        return !is_null($value);
    });

    // Construct the SET part of the SQL query
    $set = [];
    foreach ($fields as $key => $value) {
        $set[] = "$key='" . db_escape($db, $value) . "'";
    }

    if (empty($set)) {
        return "No fields to update.";
    }

    $sql = "UPDATE publicaciones SET " . implode(", ", $set) . " WHERE id='" . db_escape($db, $id) . "' LIMIT 1";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);

    if ($result) {
        return mysqli_affected_rows($db);
    } else {
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function find_publicacion_by_id($id) {
    global $db;

    $sql = "SELECT * FROM publicaciones WHERE id='" . db_escape($db, $id) . "' ";

    // echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $resp = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $resp; // returns an assoc. array
}

// MIS VIDEOS DESTACADOS

function find_videos_by_count_user($user_id) {
    global $db;
    $sql = "SELECT * FROM settings_videos ";
    $sql .= " where  user_id='$user_id'    ORDER BY id DESC ";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function insertar_video_destacados($video) {
    global $db;
    $sql = "INSERT INTO settings_videos ";
    $sql .= "(user_id,titulo_video_one,url_video_one,titulo_video_two,url_video_two,titulo_video_three,url_video_three,"
        . "titulo_video_four,url_video_four,titulo_video_five,url_video_five,"
        . "titulo_video_six,url_video_six,titulo_video_seven,url_video_seven,"
        . "titulo_video_eight,url_video_eight,estado) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $video['user_id']) . "',";
    $sql .= "'" . db_escape($db, $video['titulo_video_one']) . "',";
    $sql .= "'" . db_escape($db, $video['url_video_one']) . "',";
    $sql .= "'" . db_escape($db, $video['titulo_video_two']) . "',";
    $sql .= "'" . db_escape($db, $video['url_video_two']) . "',";
    $sql .= "'" . db_escape($db, $video['titulo_video_three']) . "',";
    $sql .= "'" . db_escape($db, $video['url_video_three']) . "',";
    $sql .= "'" . db_escape($db, $video['titulo_video_four']) . "',";
    $sql .= "'" . db_escape($db, $video['url_video_four']) . "',";
    $sql .= "'" . db_escape($db, $video['titulo_video_five']) . "',";
    $sql .= "'" . db_escape($db, $video['url_video_five']) . "',";
    $sql .= "'" . db_escape($db, $video['titulo_video_six']) . "',";
    $sql .= "'" . db_escape($db, $video['url_video_six']) . "',";
    $sql .= "'" . db_escape($db, $video['titulo_video_seven']) . "',";
    $sql .= "'" . db_escape($db, $video['url_video_seven']) . "',";
    $sql .= "'" . db_escape($db, $video['titulo_video_eight']) . "',";
    $sql .= "'" . db_escape($db, $video['url_video_eight']) . "',";
    $sql .= "'" . db_escape($db, $video['statu']) . "'";
    $sql .= ")";

    // echo $sql;

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if ($result) {
        return mysqli_insert_id($db);
    } else {
        // INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function find_video_destacado_by_id($id) {
    global $db;
    $sql = "SELECT * FROM settings_videos WHERE id='" . db_escape($db, $id) . "' ";
    // echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $resp = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $resp; // returns an assoc. array
}

function update_video_destacado($video) {
    global $db;
    $sql = "UPDATE settings_videos SET ";
    $sql .= "user_id='" . db_escape($db, $video['user_id']) . "', ";
    $sql .= "titulo_video_one='" . db_escape($db, $video['titulo_video_one']) . "', ";
    $sql .= "url_video_one='" . db_escape($db, $video['url_video_one']) . "', ";
    $sql .= "titulo_video_two='" . db_escape($db, $video['titulo_video_two']) . "', ";
    $sql .= "url_video_two='" . db_escape($db, $video['url_video_two']) . "', ";
    $sql .= "titulo_video_three='" . db_escape($db, $video['titulo_video_three']) . "', ";
    $sql .= "url_video_three='" . db_escape($db, $video['url_video_three']) . "', ";
    $sql .= "titulo_video_four='" . db_escape($db, $video['titulo_video_four']) . "', ";
    $sql .= "url_video_four='" . db_escape($db, $video['url_video_four']) . "', ";
    $sql .= "titulo_video_five='" . db_escape($db, $video['titulo_video_five']) . "', ";
    $sql .= "url_video_five='" . db_escape($db, $video['url_video_five']) . "', ";
    $sql .= "titulo_video_six='" . db_escape($db, $video['titulo_video_six']) . "', ";
    $sql .= "url_video_six='" . db_escape($db, $video['url_video_six']) . "', ";
    $sql .= "titulo_video_seven='" . db_escape($db, $video['titulo_video_seven']) . "', ";
    $sql .= "url_video_seven='" . db_escape($db, $video['url_video_seven']) . "', ";
    $sql .= "titulo_video_eight='" . db_escape($db, $video['titulo_video_eight']) . "', ";
    $sql .= "url_video_eight='" . db_escape($db, $video['url_video_eight']) . "', ";
    $sql .= "estado='" . db_escape($db,1) . "' ";
    $sql .= "WHERE id=" . db_escape($db, $video['id']) . " ";
    //$sql .= "LIMIT 1";

    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function search_video_destacado_by_id($video_id) {
    global $db;
    $sql = "SELECT * FROM settings_videos ";
    $sql .= "WHERE id='" . db_escape($db, $video_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $registro = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $registro; // returns an assoc. array
}

function get_registers_video_destacado($user_id) {
    global $db;
    $sql = "SELECT COUNT(*) as valor FROM settings_videos ";
    $sql .= "WHERE user_id='" . db_escape($db, $user_id) . "' ";

// echo $sql;
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $screen = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $screen; // returns an assoc. array
}


/* SERVICIOS API FLUTTER */

function get_info_gym_slider_screen_datos($id_tienda) {
    global $db;
    $sql = "SELECT users.user_id,users.business_name,users.gallery,users.image_name,users.useraddress ,users.cod_tipo_servicio ,users.ruc,users.cod_rubro,users.cod_distrito , ";
    $sql .= " ubigeo_peru_districts.name,rubro.codigo,rubro.descripcion ";
    $sql .= "from users ";
    $sql .= "LEFT JOIN  ubigeo_peru_districts on users.cod_distrito = ubigeo_peru_districts.id  ";
    $sql .= "LEFT JOIN rubro on users.cod_rubro = rubro.id ";
//$sql .= "from users ";
    $sql .= "WHERE user_id='" . db_escape($db, $id_tienda) . "' ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
//$rows = [];
    $encabezado = array();
    $sliders = get_info_gym_slider($id_tienda);
    $screens = get_info_gym_screen($id_tienda);
    $clientes = get_clientes_by_tienda($id_tienda);
    $setting_videos = get_videos_by_user_id($id_tienda);
    $sucursales = get_sucursales_by_tienda($id_tienda);
    $envios = get_envios_by_tienda($id_tienda);
    $dietas = get_dietas_by_tienda($id_tienda);

    $detalle_slider = array();
    $detalle_screen = array();
    $array_categories = array();
    $array_products = array();
    $array_planes = array();
    $array_descuentos = array();
    $array_estrategias = array();
    $array_clientes = array();
    $array_products_images = array();
    $array_videos = array();
    $array_sucursales = array();
    $array_envios = array();
    $array_dietas = array();
    $array_planes_images = array();
    $array_descuentos_images = array();
    $array_estrategia_images = array();
    $array_products_images_new = array();

    $url_servidor= "https://myapp.fulventas.com/";

    $url_logo = $url_servidor . 'public/uploads/user-images/';
    $url_logo_screen = $url_servidor . 'public/uploads/logos/';
    $url_slider = $url_servidor . 'public/uploads/recent-products/';
    $url_products = $url_servidor . 'public/uploads/recent-products/';
    $url_planes = $url_servidor . 'public/uploads/planes/';
    $url_descuentos = $url_servidor . 'public/uploads/descuentos/';
    $url_estrategias = $url_servidor . 'public/uploads/estrategias/';
    $url_categorias = $url_servidor . 'public/uploads/categories/';
    $url_horarios = $url_servidor . 'public/uploads/horarios/';
    $url_profesores = $url_servidor . 'public/uploads/profesores/';
    $url_clientes = $url_servidor . 'public/uploads/clientes/';
    $url_video_youtube = 'https://www.youtube.com/embed/';
    $url_catalogo = $url_servidor . 'public/uploads/catalogos/';
    $url_setting_video = $url_servidor . 'public/uploads/settings-videos/';

    while ($row = mysqli_fetch_array($result)) {
        $id = $row['user_id'];
        $business = $row['business_name'];
        $gallery = $row['gallery'];
        $imagen = $row['image_name'];
        $tipoPlan = $row['cod_tipo_servicio'];
        $codRubro = $row['cod_rubro'];
        $ruc = $row['ruc'];
        $rubro = $row['descripcion'];
        $Distrito = $row['name'];
        $direccion = $row['useraddress'];

        foreach ($sliders as $value) {
            $detalle_slider[] = array(
                'titulo' => $value['title'],
                'imagen' => $url_slider . $value['image_name'],
            );
        }
        foreach ($screens as $valor) {
            $detalle_screen = array(
                'facebook_url' => $valor['facebook_url'],
                'instagram_url' => $valor['instagram_url'],
                'color' => $valor['color'],
                'codigoColor' => $valor['codigo'],
                'video' => $url_video_youtube . $valor['url_video'],
                'color_texto' => $valor['color_texto'],
                'logo' => $url_logo_screen . $valor['image_logo']
            );
        }

        foreach ($clientes as $cliente) {
            $array_clientes[] = array(
                'codigo' => $cliente['codigo'],
                'nombres' => $cliente['nombres'],
                'celular' => $cliente['celular'],
                'email' => $cliente['email'],
                'direccion' => $cliente['direccion'],
                'foto' => $url_clientes . $cliente['image_name']
            );
        }

        foreach ($setting_videos as $setting) {
            $array_videos[] = array(
                'cod_tienda' => $setting['user_id'],
                'titulo_video_1' => $setting['titulo_video_one'],
                'link_video_1' => $setting['url_video_one'],
                'titulo_video_2' => $setting['titulo_video_two'],
                'link_video_2' => $setting['url_video_two'],
                'titulo_video_3' => $setting['titulo_video_three'],
                'link_video_3' => $setting['url_video_three'],
                'titulo_video_4' => $setting['titulo_video_four'],
                'link_video_4' => $setting['url_video_four'],
                'titulo_video_5' => $setting['titulo_video_five'],
                'link_video_5' => $setting['url_video_five'],
                'titulo_video_6' => $setting['titulo_video_six'],
                'link_video_6' => $setting['url_video_six'],
                'titulo_video_7' => $setting['titulo_video_seven'],
                'link_video_7' => $setting['url_video_seven'],
                'titulo_video_8' => $setting['titulo_video_eight'],
                'link_video_8' => $setting['url_video_eight']
            );
        }

        foreach ($sucursales as $sucursal) {
            $array_sucursales[] = array(
                'cod_tienda' => $sucursal['user_id'],
                'cod_sucursal' => $sucursal['id'],
                'nombre' => $sucursal['nombre'],
                'distrito' => $sucursal['distrito'],
                'direccion' => $sucursal['direccion'],
                'numero_sucursal' => $sucursal['numero_sucursal'],
                'correo' => $sucursal['correo'],
                'celular' => $sucursal['celular'],
                'horario' => $sucursal['horario'],
                'latitud' => $sucursal['latitud'],
                'longitud' => $sucursal['longitud']
            );
        }

        foreach ($envios as $envio) {
            $array_envios[] = array(
                'cod_tienda' => $envio['user_id'],
                'cod_sucursal' => $envio['sucursal_id'],
                'nombre_sucursal' => $envio['nombre'],
                'distrito' => $envio['distrito'],
                'precio' => $envio['precio']
            );
        }

        $array_tipo_dieta = [
            ["id" => "1", "title" => "Dieta para bajar de peso (baja en calorias)"],
            ["id" => "2", "title" => "Dieta baja en fibras"],
            ["id" => "3", "title" => "Dieta alta en proteinas"],
            ["id" => "4", "title" => "Dieta para subir de peso"],
            ["id" => "5", "title" => "Dieta baja en colesterol"],
            ["id" => "6", "title" => "Dieta baja en grasas"],
            ["id" => "7", "title" => "Dieta libre de gluten"],
            ["id" => "8", "title" => "Dieta baja en sal"],
            ["id" => "9", "title" => "Dieta para diabeticos"],
            ["id" => "10", "title" => "Otros dietas"]
        ];

        $array_tipo_disciplinas = [
            ["id" => "1", "title" => "fullbody"],
            ["id" => "2", "title" => "TaeBo"],
            ["id" => "3", "title" => "Musculación"],
            ["id" => "4", "title" => "Aeróbicos"],
            ["id" => "5", "title" => "yoga"],
            ["id" => "6", "title" => "bailes"],
            ["id" => "7", "title" => "crossfit"],
            ["id" => "8", "title" => "CardioBox"],
            ["id" => "9", "title" => "Circuit Training"],
            ["id" => "10", "title" => "Entrenamiento funcional"],
            ["id" => "11", "title" => "spinning"],
            ["id" => "12", "title" => "step"],
            ["id" => "13", "title" => "Pilates"],
            ["id" => "14", "title" => "boxeo"],
            ["id" => "15", "title" => "taekwondo"],
            ["id" => "16", "title" => "karate"],
            ["id" => "17", "title" => "yudo"],
            ["id" => "18", "title" => "mua thai"],
            ["id" => "19", "title" => "TRX"],
            ["id" => "20", "title" => "Power-Jump"],
            ["id" => "21", "title" => "Zumba"],
            ["id" => "22", "title" => "otros"]
        ];
        $tipo_dieta_val = "";
        $disciplina_val = "";

        foreach ($dietas as $dieta) {
            foreach ($array_tipo_dieta as $row) {
                if ($row['id'] === $dieta['tipo_dieta']) {
                    $tipo_dieta_val = $row['title'];
                }
            };

            foreach ($array_tipo_disciplinas as $fila) {
                if ($fila['id'] === $dieta['disciplina']) {
                    $disciplina_val = $fila['title'];
                }
            };

            $array_dietas[] = array(
                'key' => $dieta['id'],
                'cod_tienda' => $dieta['user_id'],
                'tipo_dieta' => $tipo_dieta_val,
                'nombre' => $dieta['nombre_dieta'],
                'dias_semana' => $dieta['dias_semana'],
                'duracion' => $dieta['duracion_dieta'],
                'fecha_inicio' => $dieta['fecha_inicio'],
                'fecha_fin' => $dieta['fecha_fin'],
                'alumno' => $dieta['alumno'],
                'disciplina' => $disciplina_val,
                'alergias' => $dieta['alergias'],
                'edad' => $dieta['edad'],
                'enfermedad_cronica' => $dieta['enfermedad_cronica'],
                'alergia_medicamento' => $dieta['alergia_medicamento']
            );
        }

        $categories = get_categories_by_rubro($codRubro);
        foreach ($categories as $categoria) {
            $array_categories[] = array(
                //'id' => $categoria['id'],
                'titulo' => $categoria['title'],
                'alias' => $categoria['alias'],
                'imagen_categoria' => $url_categorias . $categoria['image_name']
            );
        }
        $productos = get_carro_cabecera_products($id);
        $codProdu;
        $codProduImage;
        $i = 1;
        foreach ($productos as $producto) {
            $productos_images = get_carro_detalle_images_products($producto['id']);

            $array_products[] = array(
                'codProducto' => $producto['id'],
                'nombre' => $producto['title'],
                'descripcion' => $producto['description'],
                'categoria' => $producto['category'] === '1' ? "Producto" : "Servicio",
                'tipo_producto' => $producto['tipo_producto'] === '1' ? "Producto" : "Servicio",
                'foto' => $url_products . $producto['image_name'],
                'marca' => $producto['marca'],
                'precio' => $producto['price'],
                'descuento' => $producto['descuento'],
                'precio_descuento' => $producto['previous_price'],
                'stock' => $producto['qty'],
                'promocion' => $producto['promocion'] === "1" ? "Si" : "No",
                'fecha_inicio_vigencia' => $producto['fecha_inicio'],
                'fecha_fin_vigencia' => $producto['fecha_fin'],
                'horario' => $producto['horario'],
                'imagen_horario' => $producto['horario_foto'] === '' ? "" : $url_horarios . $producto['horario_foto'],
                'profesor' => $producto['profesor'],
                'imagen_profesor' => $producto['profesor_foto'] === '' ? "" : $url_profesores . $producto['profesor_foto'],
                'link_video_1' => $producto['link_video_one'],
                'link_video_2' => $producto['link_video_two'],
                'destacado' => $producto['outstanding'] === '1' ? "No" : "Si"
            );
        }
        $planes = get_cabecera_plan($id);
        foreach ($planes as $plan) {
            $array_planes[] = array(
                'Codigo' => $plan['id'],
                'nombre' => $plan['title'],
                'descripcion' => $plan['descripcion'],
                'categoria' => $plan['category'] === '1' ? "Producto" : "Servicio",
                'tipo_producto' => $plan['tipo_producto'] === '1' ? "Producto" : "Servicio",
                'foto' => $url_planes . $plan['image_name'],
                'precio' => $plan['precio_normal'],
                'descuento' => $plan['porcentaje'],
                'precio_descuento' => $plan['precio_plan'],
                'stock' => $plan['qty'],
                'promocion' => $plan['promocion'] === "1" ? "Si" : "No",
                'fecha_inicio_vigencia' => $plan['fecha_inicio'],
                'fecha_fin_vigencia' => $plan['fecha_fin'],
                'horario' => $plan['horario'],
                'imagen_horario' => $plan['horario_foto'] === '' ? "" : $url_horarios . $plan['horario_foto'],
                'profesor' => $plan['profesor'],
                'imagen_profesor' => $plan['profesor_foto'] === '' ? "" : $url_profesores . $plan['profesor_foto'],
                'link_video_1' => $plan['link_video_one'],
                'link_video_2' => $plan['link_video_two']
            );
        }

        $descuentos = get_cabecera_descuentos($id);
        foreach ($descuentos as $descuento) {
            $array_descuentos[] = array(
                'Codigo' => $descuento['id'],
                'nombre' => $descuento['title'],
                'descripcion' => $descuento['descripcion'],
                'marca' => $descuento['marca'],
                'categoria' => $descuento['category'] === '1' ? "Producto" : "Servicio",
                'tipo_producto' => $descuento['tipo_producto'] === '1' ? "Producto" : "Servicio",
                'foto' => $url_descuentos . $descuento['image_name'],
                'precio' => $descuento['precio_normal'],
                'descuento' => $descuento['porcentaje'],
                'precio_descuento' => $descuento['precio_descuento'],
                'stock' => $descuento['qty'],
                'promocion' => $descuento['promocion'] === "1" ? "Si" : "No",
                'fecha_inicio_vigencia' => $descuento['fecha_inicio'],
                'fecha_fin_vigencia' => $descuento['fecha_fin'],
                'horario' => $descuento['horario'],
                'imagen_horario' => $descuento['horario_foto'] === '' ? "" : $url_horarios . $descuento['horario_foto'],
                'profesor' => $descuento['profesor'],
                'imagen_profesor' => $descuento['profesor_foto'] === '' ? "" : $url_profesores . $descuento['profesor_foto'],
                'link_video_1' => $descuento['link_video_one'],
                'link_video_2' => $descuento['link_video_two']
            );
        }

        $estrategia = get_cabecera_estrategias($id);
        foreach ($estrategia as $estrategia) {
            $tipo_promo = "";
            if ($estrategia['tipo_promocion'] === '1') {
                $tipo_promo = "Oferta";
            }
            if ($estrategia['tipo_promocion'] === '2') {
                $tipo_promo = "Paquete";
            }
            if ($estrategia['tipo_promocion'] === '3') {
                $tipo_promo = "Cortesia";
            }
            if ($estrategia['tipo_promocion'] === '5') {
                $tipo_promo = "2 x 1 - Promocion Producto";
            }

            $array_estrategias[] = array(
                'Codigo' => $estrategia['id'],
                'nombre' => $estrategia['title'],
                'descripcion' => $estrategia['descripcion'],
                'marca' => $estrategia['marca'],
                'categoria' => $estrategia['category'] === '1' ? "Producto" : "Servicio",
                'tipo_producto' => $estrategia['tipo_producto'] === '1' ? "Producto" : "Servicio",
                'tipo_promocion' => $tipo_promo,
                'foto' => $url_estrategias . $estrategia['image_name'],
                'precio' => $estrategia['precio_normal'],
                'precio_paquete' => $estrategia['precio_paquete'],
                'precio_oferta' => $estrategia['precio_oferta'],
                'stock' => $estrategia['qty'],
                'promocion' => $estrategia['promocion'] === "1" ? "Si" : "No",
                'fecha_inicio_vigencia' => $estrategia['fecha_inicio'],
                'fecha_fin_vigencia' => $estrategia['fecha_fin'],
                'horario' => $estrategia['horario'],
                'imagen_horario' => $estrategia['horario_foto'] === '' ? "" : $url_horarios . $estrategia['horario_foto'],
                'profesor' => $estrategia['profesor'],
                'imagen_profesor' => $estrategia['profesor_foto'] === '' ? "" : $url_profesores . $estrategia['profesor_foto'],
                'link_video_1' => $estrategia['link_video_one'],
                'link_video_2' => $estrategia['link_video_two']
            );
        }

        $catalogos = get_cabecera_catalogo($id);
        foreach ($catalogos as $catalogo) {
            $array_catalogo[] = array(
                'Codigo' => $catalogo['id'],
                'nombre' => $catalogo['titulo'],
                'descripcion' => $catalogo['descripcion'],
                'marca' => $catalogo['marca'],
                'categoria' => $catalogo['category'] === '1' ? "Producto" : "Servicio",
                'tipo_producto' => $catalogo['tipo_producto'] === '1' ? "Producto" : "Servicio",
                'foto' => $url_catalogo . $catalogo['image_name'],
                'precio' => $catalogo['price'],
                'descuento' => $catalogo['porcentaje'],
                'precio_descuento' => $catalogo['precio_descuento'],
                'stock' => $catalogo['qty'],
                'promocion' => $catalogo['promocion'] === "1" ? "Si" : "No",
                'fecha_inicio_vigencia' => $catalogo['fecha_inicio'],
                'fecha_fin_vigencia' => $catalogo['fecha_fin'],
                'link_video_1' => $catalogo['link_video_one'],
                'link_video_2' => $catalogo['link_video_two']
            );
        }

        $type_plan = "";
        if ($tipoPlan === '1') {
            $type_plan = "Catalogo";
            $encabezado = array(
                'id' => $id,
                'nombreGYM' => $business,
                'galeria' => $gallery,
                'logo_representante' => $url_logo . $imagen,
                'ruc' => $ruc,
                'rubro' => $rubro,
                'distrito' => $Distrito,
                'direccion' => $direccion,
                'tipoPlan' => $type_plan,
                'slider' => $detalle_slider,
                'personalizado' => $detalle_screen,
                'categorias' => $array_categories,
                'planes' => $array_planes,
                'descuentos' => $array_descuentos,
                'estrategias' => $array_estrategias,
                'catalogo' => $array_catalogo,
                'clientes' => $array_clientes,
                'sucursales' => $array_sucursales,
                'envios' => $array_envios,
                'dietas' => $array_dietas
            );
        }
        if ($tipoPlan === '2') {
            $type_plan = "Carro Compras";
            $encabezado = array(
                'id' => $id,
                'nombreGYM' => $business,
                'galeria' => $gallery,
                'logo_representante' => $url_logo . $imagen,
                'ruc' => $ruc,
                'rubro' => $rubro,
                'distrito' => $Distrito,
                'direccion' => $direccion,
                'tipoPlan' => $type_plan,
                'slider' => $detalle_slider,
                'personalizado' => $detalle_screen,
                'videos' => $array_videos,
                'categorias' => $array_categories,
                'productos' => $array_products,
                'planes' => $array_planes,
                'descuentos' => $array_descuentos,
                'estrategias' => $array_estrategias,
                'clientes' => $array_clientes,
                'sucursales' => $array_sucursales,
                'envios' => $array_envios,
                'dietas' => $array_dietas
            );
        }

        $json_encabezado = json_encode($encabezado, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);
    }
    return $json_encabezado;
}

function get_info_gym_productos_servicios_images($product_id) {
    global $db;
    $sql = "SELECT * FROM products";
//$sql .= " where id= '$product_id' ORDER BY id DESC ";
    $sql .= " WHERE id='" . db_escape($db, $product_id) . "' ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $encabezado = array();
    $array_products_images = array();
    $productos_images = get_carro_detalle_images_products($product_id);
    $json_encabezado = "";

    $url_servidor= "https://myapp.fulventas.com/";

    $url_horarios = $url_servidor . 'public/uploads/horarios/';
    $url_profesores = $url_servidor . 'public/uploads/profesores/';
    $url_products = $url_servidor . 'public/uploads/recent-products/';
    while ($producto = mysqli_fetch_array($result)) {
        foreach ($productos_images as $productImage) {
            $array_products_images[] = array(
//'ProductoID' => $productImage['product_id'],
                'imagen' => $url_products . $productImage['image_name'],
            );
        }
        $encabezado = array(
            'codProducto' => $producto['id'],
            'nombre' => $producto['title'],
            'descripcion' => $producto['description'],
            'categoria' => $producto['category'] === '1' ? "Producto" : "Servicio",
            'tipo_producto' => $producto['tipo_producto'] === '1' ? "Producto" : "Servicio",
            'foto' => $url_products . $producto['image_name'],
            'precio' => $producto['price'],
            'descuento' => $producto['descuento'],
            'precio_descuento' => $producto['previous_price'],
            'stock' => $producto['qty'],
            'promocion' => $producto['promocion'] === "1" ? "Si" : "No",
            'fecha_inicio_vigencia' => $producto['fecha_inicio'],
            'fecha_fin_vigencia' => $producto['fecha_fin'],
            'horario' => $producto['horario'],
            'imagen_horario' => $producto['horario_foto'] === '' ? "" : $url_horarios . $producto['horario_foto'],
            'profesor' => $producto['profesor'],
            'imagen_profesor' => $producto['profesor_foto'] === '' ? "" : $url_profesores . $producto['profesor_foto'],
            'imagenes_productos' => $array_products_images
        );

        $json_encabezado = json_encode($encabezado, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);
    }
    mysqli_free_result($result);
    echo $json_encabezado;
}

function get_info_gym_planes_images($plan_id) {
    global $db;
    $sql = "SELECT * FROM plan";
    $sql .= " WHERE id='" . db_escape($db, $plan_id) . "' ORDER BY id DESC ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $encabezado = array();
    $array_plan_images = array();
    $planes_images = get_images_by_array_plan($plan_id);
    $json_encabezado = "";
    $url_servidor= "https://myapp.fulventas.com/";

    $url_horarios = $url_servidor . 'public/uploads/horarios/';
    $url_profesores = $url_servidor . 'public/uploads/profesores/';
    $url_planes = $url_servidor . 'public/uploads/planes/';

    while ($plan = mysqli_fetch_array($result)) {
        foreach ($planes_images as $planImage) {
            $array_plan_images[] = array(
                'imagen' => $url_planes . $planImage['image_name'],
            );
        }
        $encabezado = array(
            'Codigo' => $plan['id'],
            'nombre' => $plan['title'],
            'descripcion' => $plan['descripcion'],
            'categoria' => $plan['category'] === '1' ? "Producto" : "Servicio",
            'tipo_producto' => $plan['tipo_producto'] === '1' ? "Producto" : "Servicio",
            'foto' => $url_planes . $plan['image_name'],
            'precio' => $plan['precio_normal'],
            'descuento' => $plan['porcentaje'],
            'precio_descuento' => $plan['precio_plan'],
            'stock' => $plan['qty'],
            'promocion' => $plan['promocion'] === "1" ? "Si" : "No",
            'fecha_inicio_vigencia' => $plan['fecha_inicio'],
            'fecha_fin_vigencia' => $plan['fecha_fin'],
            'horario' => $plan['horario'],
            'imagen_horario' => $plan['horario_foto'] === '' ? "" : $url_horarios . $plan['horario_foto'],
            'profesor' => $plan['profesor'],
            'imagen_profesor' => $plan['profesor_foto'] === '' ? "" : $url_profesores . $plan['profesor_foto'],
            'imagenes' => $array_plan_images
        );
        $json_encabezado = json_encode($encabezado, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);
    }
    mysqli_free_result($result);
    //echo '<pre>' . $json_encabezado . '</pre>';
    echo $json_encabezado;
}

function get_info_gym_descuentos_images($descuento_id) {
    global $db;
    $sql = "SELECT * FROM descuentos";
    $sql .= " WHERE id='" . db_escape($db, $descuento_id) . "' ORDER BY id DESC ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    $encabezado = array();
    $array_descuentos_images = array();

    $descuentos_images = get_images_by_descuento_id($descuento_id);
    $json_encabezado = "";

    $url_servidor= "https://myapp.fulventas.com/";

    $url_horarios = $url_servidor . 'public/uploads/horarios/';
    $url_profesores = $url_servidor . 'public/uploads/profesores/';
    $url_descuentos = $url_servidor . 'public/uploads/descuentos/';

    while ($descuento = mysqli_fetch_array($result)) {
        foreach ($descuentos_images as $descuentoImage) {
            $array_descuentos_images[] = array(
                'imagen' => $url_descuentos . $descuentoImage['image_name'],
            );
        }
        $encabezado = array(
            'Codigo' => $descuento['id'],
            'nombre' => $descuento['title'],
            'descripcion' => $descuento['descripcion'],
            'categoria' => $descuento['category'] === '1' ? "Producto" : "Servicio",
            'tipo_producto' => $descuento['tipo_producto'] === '1' ? "Producto" : "Servicio",
            'foto' => $url_descuentos . $descuento['image_name'],
            'precio' => $descuento['precio_normal'],
            'descuento' => $descuento['porcentaje'],
            'precio_descuento' => $descuento['precio_descuento'],
            'stock' => $descuento['qty'],
            'promocion' => $descuento['promocion'] === "1" ? "Si" : "No",
            'fecha_inicio_vigencia' => $descuento['fecha_inicio'],
            'fecha_fin_vigencia' => $descuento['fecha_fin'],
            'horario' => $descuento['horario'],
            'imagen_horario' => $descuento['horario_foto'] === '' ? "" : $url_horarios . $descuento['horario_foto'],
            'profesor' => $descuento['profesor'],
            'imagen_profesor' => $descuento['profesor_foto'] === '' ? "" : $url_profesores . $descuento['profesor_foto'],
            'imagenes' => $array_descuentos_images
        );
        $json_encabezado = json_encode($encabezado, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);
    }
    mysqli_free_result($result);
    echo $json_encabezado;
}

function get_info_gym_estrategias_images($estrategia_id) {
    global $db;
    $sql = "SELECT * FROM estrategia_ventas";
    $sql .= " WHERE id='" . db_escape($db, $estrategia_id) . "' ORDER BY id DESC ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    $encabezado = array();
    $array_estrategias_images = array();
    $estrategias_images = get_images_by_estrategia_id($estrategia_id);
    $json_encabezado = "";
    $url_servidor= "https://myapp.fulventas.com/";

    $url_horarios = $url_servidor . 'public/uploads/horarios/';
    $url_profesores = $url_servidor . 'public/uploads/profesores/';
    $url_estrategias = $url_servidor . 'public/uploads/estrategias/';

    while ($estrategia = mysqli_fetch_array($result)) {
        foreach ($estrategias_images as $estrategiaImage) {
            $array_estrategias_images[] = array(
                'imagen' => $url_estrategias . $estrategiaImage['image_name'],
            );
        }
        $tipo_promo = "";
        if ($estrategia['tipo_promocion'] === '1') {
            $tipo_promo = "Oferta";
        }
        if ($estrategia['tipo_promocion'] === '2') {
            $tipo_promo = "Paquete";
        }
        if ($estrategia['tipo_promocion'] === '3') {
            $tipo_promo = "Cortesia";
        }
        if ($estrategia['tipo_promocion'] === '5') {
            $tipo_promo = "2 x 1 - Promocion Producto";
        }

        $encabezado = array(
            'Codigo' => $estrategia['id'],
            'nombre' => $estrategia['title'],
            'descripcion' => $estrategia['descripcion'],
            'categoria' => $estrategia['category'] === '1' ? "Producto" : "Servicio",
            'tipo_producto' => $estrategia['tipo_producto'] === '1' ? "Producto" : "Servicio",
            'tipo_promocion' => $tipo_promo,
            'foto' => $url_estrategias . $estrategia['image_name'],
            'precio' => $estrategia['precio_normal'],
            'precio_paquete' => $estrategia['precio_paquete'],
            'precio_oferta' => $estrategia['precio_oferta'],
            'stock' => $estrategia['qty'],
            'promocion' => $estrategia['promocion'] === "1" ? "Si" : "No",
            'fecha_inicio_vigencia' => $estrategia['fecha_inicio'],
            'fecha_fin_vigencia' => $estrategia['fecha_fin'],
            'horario' => $estrategia['horario'],
            'imagen_horario' => $estrategia['horario_foto'] === '' ? "" : $url_horarios . $estrategia['horario_foto'],
            'profesor' => $estrategia['profesor'],
            'imagen_profesor' => $estrategia['profesor_foto'] === '' ? "" : $url_profesores . $estrategia['profesor_foto'],
            'imagenes' => $array_estrategias_images
        );
        $json_encabezado = json_encode($encabezado, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);
    }
    mysqli_free_result($result);
    echo $json_encabezado;
}

/* Catalogo */

function get_info_gym_catalogo_images($catalogo_id) {
    global $db;
    $sql = "SELECT * FROM catalogo";
    $sql .= " WHERE id='" . db_escape($db, $catalogo_id) . "' ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $encabezado = array();
    $array_catalogo_images = array();
    $catalogo_images = get_images_by_catalog_id($catalogo_id);
    $json_encabezado = "";
    $url_servidor= "https://myapp.fulventas.com/";

    $url_catalogo = $url_servidor . 'public/uploads/catalogos/';
    while ($catalogo = mysqli_fetch_array($result)) {
        foreach ($catalogo_images as $catalogoImage) {
            $array_catalogo_images[] = array(
                'imagen' => $url_catalogo . $catalogoImage['image_name'],
            );
        }
        $encabezado = array(
            'codigo' => $catalogo['id'],
            'nombre' => $catalogo['titulo'],
            'descripcion' => $catalogo['descripcion'],
            'categoria' => $catalogo['category'] === '1' ? "Producto" : "Servicio",
            'tipo_producto' => $catalogo['tipo_producto'] === '1' ? "Producto" : "Servicio",
            'foto' => $url_catalogo . $catalogo['image_name'],
            'precio' => $catalogo['price'],
            'descuento' => $catalogo['precio_descuento'],
            'stock' => $catalogo['qty'],
            'porcentaje' => $catalogo['porcentaje'],
            'promocion' => $catalogo['promocion'] === "1" ? "Si" : "No",
            'fecha_inicio' => $catalogo['fecha_inicio'],
            'fecha_fin' => $catalogo['fecha_fin'],
            'imagenes' => $array_catalogo_images
        );

        $json_encabezado = json_encode($encabezado, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);
    }
    mysqli_free_result($result);
    echo $json_encabezado;
}

function get_info_tecnica_clientes_by_id($cliente_id) {
    global $db;
    $sql = "SELECT * FROM info_tecnica ";
    $sql .= "WHERE cliente_id=" . db_escape($db, $cliente_id) . " ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}



function get_progreso_tecnica_clientes_by_id($cliente_id) {
    global $db;
    $sql = "SELECT * FROM progreso_cliente ";
    $sql .= "WHERE cliente_id=" . db_escape($db, $cliente_id) . " ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_info_dieta_detalle_by_id($dieta_id) {
    global $db;
    $sql = "SELECT * FROM dieta_detalle ";
    $sql .= "WHERE dieta_id=" . db_escape($db, $dieta_id) . " ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
    return $rows;
}

function get_info_gym_cliente($cliente_id) {
    global $db;
    $sql = "SELECT * FROM clientes";
    $sql .= " WHERE id='" . db_escape($db, $cliente_id) . "' ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $encabezado = array();
    $array_info_tecnica_cliente = array();
    $array_info_progreso_cliente = array();
    $info_tecnica_rutina_dieta = get_info_tecnica_clientes_by_id($cliente_id);
    $progreso_tecnico = get_progreso_tecnica_clientes_by_id($cliente_id);
    $json_encabezado = "";
    $url_servidor= "https://myapp.fulventas.com/";

    $url_rutina = $url_servidor . 'public/uploads/rutinas/';
    $url_dieta = $url_servidor . 'public/uploads/dietas/';
    $url_cliente = $url_servidor . 'public/uploads/clientes/';
    $url_progresos = $url_servidor . 'public/uploads/progresos/';

    while ($cliente = mysqli_fetch_array($result)) {
        foreach ($info_tecnica_rutina_dieta as $info) {
            $array_info_tecnica_cliente[] = array(
                'rutina' => $url_rutina . $info['image_rutina'],
                'rutina-2' => $url_dieta . $info['image_dieta'],
                'fecha_inicio_rutina' => $info['fecha_inicio_rutina'],
                'fecha_fin_rutina' => $info['fecha_fin_rutina'],
                'frecuencia_rutina' => $info['frecuencia_rutina']
            );
        }

        foreach ($progreso_tecnico as $progreso) {
            $array_info_progreso_cliente[] = array(
                'fecha' => $progreso['fecha'],
                'asunto' => $progreso['asunto'],
                'detalle' => $progreso['detalle'],
                'progreso1' => $url_progresos . $progreso['progreso_image'],
                'progreso2' => $url_progresos . $progreso['progreso_fisico_image']
            );
        }

        $encabezado = array(
            'codigo' => $cliente['id'],
            'nombres' => $cliente['nombres'],
            'celular' => $cliente['celular'],
            'email' => $cliente['email'],
            'direccion' => $cliente['direccion'],
            'foto' => $url_cliente . $cliente['image_name'],
            'infotecnica' => $array_info_tecnica_cliente,
            'progresotecnico' => $array_info_progreso_cliente
        );

        $json_encabezado = json_encode($encabezado, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);
    }
    mysqli_free_result($result);
    echo $json_encabezado;
}

function get_info_detalle_dieta($dieta_id) {
    global $db;

    $array_tipo_dieta = [
        ["id" => "1", "title" => "Dieta para bajar de peso (baja en calorias)"],
        ["id" => "2", "title" => "Dieta baja en fibras"],
        ["id" => "3", "title" => "Dieta alta en proteinas"],
        ["id" => "4", "title" => "Dieta para subir de peso"],
        ["id" => "5", "title" => "Dieta baja en colesterol"],
        ["id" => "6", "title" => "Dieta baja en grasas"],
        ["id" => "7", "title" => "Dieta libre de gluten"],
        ["id" => "8", "title" => "Dieta baja en sal"],
        ["id" => "9", "title" => "Dieta para diabeticos"],
        ["id" => "10", "title" => "Otros dietas"]
    ];

    $array_tipo_disciplinas = [
        ["id" => "1", "title" => "fullbody"],
        ["id" => "2", "title" => "TaeBo"],
        ["id" => "3", "title" => "Musculación"],
        ["id" => "4", "title" => "Aeróbicos"],
        ["id" => "5", "title" => "yoga"],
        ["id" => "6", "title" => "bailes"],
        ["id" => "7", "title" => "crossfit"],
        ["id" => "8", "title" => "CardioBox"],
        ["id" => "9", "title" => "Circuit Training"],
        ["id" => "10", "title" => "Entrenamiento funcional"],
        ["id" => "11", "title" => "spinning"],
        ["id" => "12", "title" => "step"],
        ["id" => "13", "title" => "Pilates"],
        ["id" => "14", "title" => "boxeo"],
        ["id" => "15", "title" => "taekwondo"],
        ["id" => "16", "title" => "karate"],
        ["id" => "17", "title" => "yudo"],
        ["id" => "18", "title" => "mua thai"],
        ["id" => "19", "title" => "TRX"],
        ["id" => "20", "title" => "Power-Jump"],
        ["id" => "21", "title" => "Zumba"],
        ["id" => "22", "title" => "otros"]
    ];

    $sql = "SELECT * FROM dieta";
    $sql .= " WHERE id='" . db_escape($db, $dieta_id) . "' ";
    mysqli_set_charset($db, "utf8");
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $encabezado = array();
    $array_detalle_dieta = array();
    $detalle_dieta_result = get_info_dieta_detalle_by_id($dieta_id);
    $json_encabezado = "";
    $url_servidor= "https://myapp.fulventas.com/";

    $url_dieta = $url_servidor . 'public/uploads/dietas/';
    $tipo_dieta_val = "";
    $disciplina_val = "";
    while ($detalle = mysqli_fetch_array($result)) {
        foreach ($detalle_dieta_result as $detail) {
            $array_detalle_dieta[] = array(
                'descripcion' => $detail['descripcion'],
                'image' => $url_dieta . $detail['image_name'],
                'tipo-comida' => $detail['tipo_comida'],
                'dia_dieta' => $detail['dia_dieta'],
                'nombre-comida' => $detail['nombre_comida'],
                'hora' => $detail['hora'],
                'recomendacion' => $detail['recomendacion']
            );
        }
        foreach ($array_tipo_dieta as $row) {
            if ($row['id'] === $detalle['tipo_dieta']) {
                $tipo_dieta_val = $row['title'];
            }
        };

        foreach ($array_tipo_disciplinas as $fila) {
            if ($fila['id'] === $detalle['disciplina']) {
                $disciplina_val = $fila['title'];
            }
        };

        $encabezado = array(
            'key' => $detalle['id'],
            'cod_tienda' => $detalle['user_id'],
            //'tipo_dieta' => $detalle['tipo_dieta'],
            'tipo_dieta' => $tipo_dieta_val,
            'nombre' => $detalle['nombre_dieta'],
            'dias_semana' => $detalle['dias_semana'],
            'duracion' => $detalle['duracion_dieta'],
            'fecha_inicio' => $detalle['fecha_inicio'],
            'fecha_fin' => $detalle['fecha_fin'],
            'alumno' => $detalle['alumno'],
            'disciplina' => $disciplina_val,
            'alergias' => $detalle['alergias'],
            'edad' => $detalle['edad'],
            'enfermedad_cronica' => $detalle['enfermedad_cronica'],
            'alergia_medicamento' => $detalle['alergia_medicamento'],
            'detalle_dieta' => $array_detalle_dieta
        );
        $json_encabezado = json_encode($encabezado, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);
    }
    mysqli_free_result($result);
    echo $json_encabezado;
}
?>
