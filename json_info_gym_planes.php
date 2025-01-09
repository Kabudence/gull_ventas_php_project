<?php require_once('init.php'); ?>
<?php
if (isset($_GET['key'])) {
    $plan_id = $_GET['key'];
    $datos = get_info_gym_planes_images($plan_id);    
}
?>A