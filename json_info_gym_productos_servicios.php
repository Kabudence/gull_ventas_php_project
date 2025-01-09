<?php require_once('../../private/init.php'); ?>
<?php
if (isset($_GET['key'])) {
    $product_id = $_GET['key'];
    $datos = get_info_gym_productos_servicios_images($product_id);
    //echo json_encode($datos);
}
?>