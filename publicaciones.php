<?php

require_once('init.php');
date_default_timezone_set("America/Lima");

// Establecer el encabezado para JSON
header('Content-Type: application/json');

global $db;

function get_publicaciones_by_user_id($user_id) {
    // Implementar la lógica para obtener publicaciones filtradas por user_id
    return find_all_publicaciones('x', true, $user_id); // Modificar esta línea según la lógica de tu aplicación
}

function handle_error($message) {
    echo json_encode(array("error" => $message));
    exit;
}

// Validar y obtener user_id
if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
    handle_error("El campo user_id es requerido.");
}

$user_id = $_GET['user_id'];

// Obtener publicaciones filtradas por user_id
$publicaciones = get_publicaciones_by_user_id($user_id);

if ($publicaciones !== false && count($publicaciones) > 0) {
    echo json_encode($publicaciones, JSON_PRETTY_PRINT);
} else {
    echo json_encode(array("message" => "No se encontraron publicaciones."));
}

// Cerrar la conexión
db_disconnect($db);

?>
