<?php require_once('init.php'); ?>
<?php
if (isset($_GET['key'])) {
    $dieta_id = $_GET['key'];
    $datos = get_info_detalle_dieta($dieta_id);    
}
?>