<?php
// Output buffering para manejar encabezados correctamente
ob_start();

// Configuración de la carpeta de sesiones
$session_path = __DIR__ . '/sessions';
if (!is_dir($session_path)) {
	mkdir($session_path, 0777, true); // Crea la carpeta si no existe
}
session_save_path($session_path); // Establece la carpeta de sesiones
session_start(); // Inicia la sesión

// Definición de constantes para rutas del proyecto
define("PRIVATE_PATH", dirname(__FILE__));
define("PROJECT_PATH", dirname(PRIVATE_PATH));
define("PUBLIC_PATH", PROJECT_PATH . '/public');
define("PUBLIC_COMISION", 6);

// Asignación de la URL raíz
$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
define("WWW_ROOT", $doc_root);

// Incluir funciones necesarias
require_once('functions.php');
require_once('database.php');
require_once('query_functions.php');

// Conexión a la base de datos
$db = db_connect();
if (!$db) {
	die("Error al conectar a la base de datos: " . mysqli_connect_error());
}
?>
