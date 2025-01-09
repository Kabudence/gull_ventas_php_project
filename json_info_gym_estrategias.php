<?php require_once('init.php'); ?>
<?php
if (isset($_GET['key'])) {
    $estrategia_id = $_GET['key'];
    $datos = get_info_gym_estrategias_images($estrategia_id);    
}
?>