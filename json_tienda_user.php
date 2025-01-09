<?php require_once('init.php'); ?>
<?php

$id_tienda = 5;
$datos = json_obtener_tienda_id($id_tienda);
echo json_encode($datos);
?>
