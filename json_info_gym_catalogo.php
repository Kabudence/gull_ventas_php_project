<?php
require_once 'init.php';
require_once 'query_functions.php';

// Simula un parámetro GET
$_GET['key'] = 1;

echo "Inicio de ejecución"; // Para verificar si el archivo se carga

if (isset($_GET['key'])) {
    echo "Key recibida: " . $_GET['key']; // Para verificar que el parámetro se recibe correctamente
    $catalogo_id = $_GET['key'];
    $datos = get_info_gym_catalogo_images($catalogo_id);
    echo "<pre>";
    print_r($datos); // Verifica el contenido de la variable $datos
    echo "</pre>";
} else {
    echo "Key no proporcionada.";
}
?>
