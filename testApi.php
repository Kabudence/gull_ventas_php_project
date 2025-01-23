<?php require_once('init.php'); ?>

<?php
$id_user = 2; // ID del usuario para obtener pases libres

// Llamar a la función que obtendrá los datos
$datos = getPseslibres_byUserId($id_user);

// Convertir los datos a formato JSON para su uso
echo json_encode($datos);
?>
