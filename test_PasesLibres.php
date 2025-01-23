<?php
require_once('init.php'); // Carga logger, funciones, DB y query_functions

// ID del usuario
$id_user = 2;

// Llamar a la función
$datos = getPseslibres_byUserId($id_user);

// Mostrar en JSON
header('Content-Type: application/json');
echo json_encode($datos);
