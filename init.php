<?php
// 1) Incluir logger
require_once('logger.php');

// 2) Output buffering
ob_start();
write_log("Iniciando script init.php");

// 3) Configuración de la carpeta de sesiones
$session_path = __DIR__ . '/sessions';
if (!is_dir($session_path)) {
	mkdir($session_path, 0777, true);
	write_log("Carpeta de sesiones creada en: $session_path");
}
session_save_path($session_path);
session_start();
write_log("Sesión iniciada.");

// 4) Definir constantes de rutas
define("PRIVATE_PATH", dirname(__FILE__));
define("PROJECT_PATH", dirname(PRIVATE_PATH));
define("PUBLIC_PATH", PROJECT_PATH . '/public');
define("PUBLIC_COMISION", 6);

$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
define("WWW_ROOT", $doc_root);

write_log("Constantes definidas correctamente.");

// 5) Incluir funciones y conexión DB
require_once('functions.php');
require_once('database.php');
require_once('query_functions.php');

// 6) Conexión a la BD
$db = db_connect();
if (!$db) {
	write_log("Error al conectar a la base de datos: " . mysqli_connect_error());
	die("Error al conectar a la base de datos: " . mysqli_connect_error());
}
write_log("Conexión a la base de datos establecida.");
