<?php

require_once('init.php');
date_default_timezone_set("America/Lima");

if (!empty($_POST)) {
    //date_default_timezone_set("America/Lima");
    $ordered_products = [];
    $ordered_products['product_id'] = $_POST['product_id'];
    $ordered_products['order_id'] = $_POST['order_id'];
    $ordered_products['tipo_categoria'] = $_POST['tipo_categoria'];
    $ordered_products['ordered_quantity'] = $_POST['ordered_quantity'];

    //$ordered_products['product_size_id'] = $_POST['product_size_id'];
    //$ordered_products['product_color_id'] = $_POST['product_color_id'];
    //$ordered_products['inventory_id'] = $_POST['inventory_id'];
    //$ordered_products['date'] = date("Y-m-d H:i:s"); 
    //$ordered_products['ordered_color_id'] = 1;
    //$product = get_product_by_id($ordered_products['product_id']);
    //$users= find_user_by_id($product['user_id']);
    //$destinatario=$users['email'];

    if (insert_ordered_products($ordered_products) > -1) {
        /* $existing_inventory = get_inventory_by_id($ordered_products['inventory_id']);
          echo $existing_inventory['available_qty'];
          $inventory['available_qty'] = $existing_inventory['available_qty'] - $ordered_products['ordered_quantity'];
          $inventory['inventory_id'] = $existing_inventory['inventory_id'];
          if(update_inventory_by_id($inventory)){
          echo "1";
          }else{
          echo "2";
          } */
        echo json_encode(1);
    } else {
        echo "2";
    }
}
?>




