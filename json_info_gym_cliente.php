<?php require_once('init.php'); ?>
<?php
if (isset($_GET['key'])) {
    $cliente_id = $_GET['key'];
    $datos = get_info_gym_cliente($cliente_id);
    //echo json_encode($datos);
}

?>

