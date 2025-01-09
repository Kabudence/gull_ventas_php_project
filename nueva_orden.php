<?php

require_once('init.php');

date_default_timezone_set("America/Lima");

if (!empty($_POST)) {
    //date_default_timezone_set('UTC');
    //date_default_timezone_set("America/Lima");

    $order = [];
    $order['order_method'] = $_POST['order_method'];
    $order['order_amount'] = $_POST['order_amount'];
    $order['order_costo_envio'] = $_POST['order_costo_envio'];
    $order['order_comision_culqui'] = $_POST['order_comision_culqui'];
    $order['order_user_id'] = $_POST['order_user_id'];
    $order['order_client_id'] = $_POST['order_client_id'];
    $order['order_sucursal_id'] = $_POST['sucursal_recojo'];
    $order['order_distrito'] = $_POST['distrito'];
    $order['order_status'] = 1;
    //$order['order_time'] = date("Y-m-d H:i:s");
    $order['order_noti'] = 0;
    $inserted_id = insert_order($order);
    
    //$users = find_user_by_id($order['order_user_id']);
    //$destinatario = $users['email'];
    
    if ($inserted_id > 0)
        echo json_encode($inserted_id);
    else
        echo json_encode(0);
}
?>


