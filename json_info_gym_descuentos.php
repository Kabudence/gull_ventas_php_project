<?php require_once('init.php'); ?>
<?php
if (isset($_GET['key'])) {
    $descuento_id = $_GET['key'];
    $datos = get_info_gym_descuentos_images($descuento_id);
}
?>